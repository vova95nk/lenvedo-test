#!/usr/bin/env php

<?php

require __DIR__ . '/vendor/autoload.php';

use Creator\CommandBuilder;
use Lenvendo\Filesystem\CommandSaver;
use Lenvendo\Filesystem\CommandReader;
use Lenvendo\Console\ConsoleWriter;

unset($argv[0]);

$reader = new CommandReader();

if (count($argv) === 0) {
    $reader->readAll();
}

if (count($argv) === 2 && in_array('{help}', $argv)) {
    if ($argv[1] !== '{help}') {
        $reader->readCommand($argv[1]);
    } else {
        var_dump('Некорректный формат запроса для просмотра команды');
    }
}

if (count($argv) > 2) {
    $builder = new CommandBuilder($argv);
    $command = $builder->get();
    $saver = new CommandSaver($command);
    $saver->save();

    if (in_array('{help}', $argv)) {
        $reader->readCommand($command->getName());
    }
}