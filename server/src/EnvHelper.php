<?php

declare(strict_types=1);

namespace Weather;

use InvalidArgumentException;

/**
 * Вспомогательный класс для работы с переменными окружения
 */
class EnvHelper
{

    /**
     * Загружает данные в глобальную переменную $_ENV из переданного пути и наименований файлов
     *
     * @param string $path             Путь к директории с файлами
     * @param array  $fileNameList     Список имён файлов для считывания
     * @param bool   $skipMissingFiles Пропускать ли отсутствующие по указанному пути файлы
     *                                 Если true, то выполнение продолжится без ошибок, если false, то будет выбрашено
     *                                 исключение и работа метода прервётся
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function loadEnvironmentData(
        string $path,
        array  $fileNameList = [],
        bool   $skipMissingFiles = false,
    ): void
    {
        $envData = [];

        foreach ($fileNameList as $envFileName) {
            $fileFullPath = $path . $envFileName;

            if (!file_exists($fileFullPath)) {
                if ($skipMissingFiles) {
                    continue;
                }

                throw new InvalidArgumentException("Файл \"$envFileName\" по пути \"$path\" не найден!");
            }

            $lines = file($fileFullPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                if (str_starts_with($line, '#')) {
                    continue;
                }

                [$key, $value] = explode('=', $line, 2);
                $envData[trim($key)] = trim($value);
            }
        }

        $_ENV = array_merge($_ENV, $envData);
    }

    /**
     * Получает значение из глобальной переменной $_ENV по ключу
     *
     * @param string $key Ключ массива
     *
     * @return int|string Значение
     *
     */
    public static function get(string $key): int|string
    {
        return $_ENV[$key];
    }

    /**
     * Устанавливает значение $_ENV
     *
     * @param string $key   Ключ
     * @param mixed  $value Значение
     *
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_ENV[$key] = $value;
    }

}