<?php

declare(strict_types=1);

namespace Filesystem;

use Filesystem\Interfaces\BuilderInterface;
use Filesystem\Interfaces\SaverInterface;

abstract class SaverAbstract implements BuilderInterface, SaverInterface
{
    public function __construct(protected string $workDir, protected string $filename)
    {
    }

    public function getPathToSave(): string
    {
        $dir = sprintf($this->workDir . '/%s', $this->filename[0]);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }
}