<?php

class QResponse
{

    public static function getProjectName(): string
    {
        return CURRENT_PROJECT_NAME;
    }

    /**
     * @param array $data
     * @param string $message
     * @return array
     */
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
        self::log(self::TYPE_ERROR, $message ?: $e->getMessage(), $e->getTrace(), $e->getFile(), $e->getLine());
    }

    /**
     * 记录日志
     *
     * @param string $error_type
     * @param string $message
     * @param array $trace
     * @param string $filename
     * @param int $line
     */
    public static function log(string $error_type, string $message, array $trace = [], string $filename = '', int $line = 0)
    {
        $log = [
            'project_name' => QResponse::getProjectName(),
            'unique_id' => QUniqueRequest::getId(),
            'error_type' => $error_type,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => $message,
            'trace' => urlencode(json_encode($trace)),
            'filename' => $filename,
            'line' => $line,
            'request_uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
            'http_referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
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

    public static function access($message)
    {
        if (!(is_string($message))) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $directoryPath = self::_getLogDirectory();
        file_put_contents($directoryPath . '/access.log', $message, FILE_APPEND);
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