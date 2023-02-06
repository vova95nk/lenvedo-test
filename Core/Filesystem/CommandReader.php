<?php

declare(strict_types=1);

namespace Lenvendo\Filesystem;

use Lenvendo\Console\ConsoleWriter;

class CommandReader
{
    public const MAIN_DIR = './storage/commands';

    public function readAll(): void
    {
        $dir = scandir(self::MAIN_DIR);

        for ($i = 2; $i < count($dir); $i++){
            $path = self::MAIN_DIR . '/' . $dir[$i];

            if (is_dir($path)){
                $this->readDir($path);
            }
        }
    }

    public function readCommand(string $commandName): void
    {
        $data = scandir(self::MAIN_DIR . '/' . $commandName[0] . '/');

        if (in_array($commandName, $data)) {
            $path = self::MAIN_DIR . '/' . $commandName[0] . '/' . $commandName;
            $rawCmd = file_get_contents($path);

            try {
                $cmdData = unserialize($rawCmd);
            } catch (\Exception) {
                var_dump('Ошибка в чтении сериализованного файла');

                exit(1);
            }

            $this->renderResult($cmdData);
        } else {
            var_dump('Запрашиваемая команда - не найдена');
        }
    }

    private function readDir(string $path): void
    {
        $data = scandir($path);

        for ($i = 2; $i < count($data); $i++) {
            $path = self::MAIN_DIR . '/' . $data[$i][0] . '/' . $data[$i];
            $rawCmd = file_get_contents($path);
            $cmdData = unserialize($rawCmd);

            $this->renderResult($cmdData);
        }
    }

    private function renderResult(array $data): void
    {
        $reader = new ConsoleWriter($data);
        $reader->write();
    }
}