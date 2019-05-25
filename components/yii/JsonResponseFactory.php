<?php

namespace app\components\yii;

class JsonResponseFactory
{

    const CODE_NO_ERROR = 0;
    const CODE_COMMON_ERROR = 1;
    const CODE_API_INVOKE_ERROR = 11;

    public static function buildSuccessResponse($data, string $message = ''): array
    {
        return self::buildData($message, self::CODE_NO_ERROR, $data);
    }

    public static function buildErrorResponse(string $message, $data = null, int $status = self::CODE_COMMON_ERROR): array
    {
        return self::buildData($message, $status, $data);
    }

    private static function buildData(string $message, int $status, $data = null): array
    {
        $result = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
        return $result;
    }

    public static function isJsonResponse(): bool
    {
        return (!empty($_SERVER['HTTP_X_RESPONSE_TYPE'])) && $_SERVER['HTTP_X_RESPONSE_TYPE'] == 'json';
    }

}