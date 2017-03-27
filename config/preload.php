<?php

class QResponse
{

    public static function successJsonResponse(array $data, string $message = ''): array
    {
        $result = [
            'status' => 0,
            'data' => $data,
        ];
        if ($message) {
            $result['message'] = $message;
        }
        return $result;
    }

    public static function errorJsonResponse(string $message): array
    {
        $result = [
            'status' => 1,
            'message' => $message,
        ];
        return $result;
    }

    public static function isJsonResponse(): bool
    {
        $isAjaxRequest = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
        return $isAjaxRequest && (!empty($_SERVER['HTTP_X_RESPONSE_TYPE'])) && $_SERVER['HTTP_X_RESPONSE_TYPE'] == 'json';
    }

}

class QUniqueRequest
{
    private static $_unique_request_id = null;

    public static function getId(): string
    {
        if (is_null(self::$_unique_request_id)) {
            self::$_unique_request_id = self::_generateId();
        }
        return self::$_unique_request_id;
    }

    private static function _generateId(): string
    {
        $host = gethostname();
        $pid = sprintf('%05s', getmypid());
        return uniqid("$host-$pid-");
    }
}

class QCustomLogger
{
    const TYPE_ERROR = 'error';
    const TYPE_INFO = 'info';
    const TYPE_DEBUG = 'debug';

    public static function logException(\Throwable $e, string $message = '')
    {
        self::log(self::TYPE_ERROR, $message ?: $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
    }

    public static function log(string $error_type, string $message, string $filename = '', int $line = 0, string $trace = '')
    {
        $log = [
            'project_name' => CURRENT_PROJECT_NAME,
            'unique_id' => QUniqueRequest::getId(),
            'error_type' => $error_type,
            'datetime' => date('Y-m-d H:i:s'),
            'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
            'message' => str_replace([';', "\r\n", "\n", "\r"], ',', $message),
            'filename' => $filename,
            'line' => $line,
            'trace' => str_replace([';', "\r\n", "\n", "\r"], ',', $trace),
            'http_referer' => $_SERVER['HTTP_REFERER'] ?? ''
        ];

        file_put_contents(self::_getLogFile(), implode(";", $log) . "\n", FILE_APPEND);
    }

    private static function _getLogDirectory(): string
    {
        $directoryPath = Yii::getAlias('@runtime');
        //$directoryPath = '/var/log/q';
        return $directoryPath;
    }

    private static function _getLogFile(): string
    {
        $directoryPath = self::_getLogDirectory();
        if (php_sapi_name() === 'cli') {//root
            return $directoryPath . '/console_error.log';
        }
        return $directoryPath . '/error.log';
    }

    public static function access(string $message, bool $isBegin = false)
    {
        $dt = date('Y-m-d H:i:s');
        if ($isBegin) {
            $url = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];
            $remote_ip = $_SERVER['REMOTE_ADDR'];
            $title = QUniqueRequest::getId() . "\n[{$dt}] [{$remote_ip}] [{$method}] [{$url}] " . PHP_EOL;
            $log_body = $title . $message . PHP_EOL;
        } else {
            $log_body = QUniqueRequest::getId() . "\n {$dt}>>> " . $message . PHP_EOL . PHP_EOL;
        }

        $access_log_filename = 'access-' . date('Ymd') . '.log';
        $directoryPath = self::_getLogDirectory();
        file_put_contents($directoryPath . '/' . $access_log_filename, $log_body, FILE_APPEND);
    }

    public static function debug($message, string $filename = 'debug.log')
    {
        if (!(is_string($message))) {
            $message = json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $directoryPath = self::_getLogDirectory();
        if (php_sapi_name() === 'cli') {//root
            $filename = "console_{$filename}";
        }
        file_put_contents("{$directoryPath}/{$filename}", $message . PHP_EOL, FILE_APPEND);
    }
}