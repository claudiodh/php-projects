<?php

namespace src\Logger;

class Log
{
    public const LOG_FILE = __DIR__ . '/../../runtime/application.log';

    public const TYPE_ERROR = '[ERROR]';
    public const TYPE_INFO = '[INFO]';
    public const TYPE_WARN = '[WARN]';

    public static function error(string $message)
    {
        self::writeToFile($message, self::TYPE_ERROR);
    }

    public static function warn(string $message)
    {
        self::writeToFile($message, self::TYPE_WARN);
    }

    public static function info(string $message)
    {
        self::writeToFile($message, self::TYPE_INFO);
    }

    public static function writeToFile(string $message, string $type)
    {
        error_log(
            message: "[ERROR]: " . $message . PHP_EOL,
            message_type: 3,
            destination: self::LOG_FILE
        );
    }

}
