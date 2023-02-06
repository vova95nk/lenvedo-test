<?php

declare(strict_types=1);

namespace Lenvendo\Filesystem;

use Creator\Command;
use Filesystem\SaverAbstract;

class CommandSaver extends SaverAbstract
{
    public const MAIN_DIR = './storage/commands';

    public function __construct(private readonly Command $command)
    {
        parent::__construct(self::MAIN_DIR, $this->command->getName());
    }

    public function save(): void
    {
        $path = $this->getPathToSave();

        file_put_contents($path . '/' . $this->command->getName(), serialize($this->command->toArray()));
    }
}