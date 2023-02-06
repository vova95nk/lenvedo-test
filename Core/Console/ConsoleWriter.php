<?php

declare(strict_types=1);

namespace Lenvendo\Console;

use Creator\Command;

/**
 * Класс для подготовки и вывода информации в консоль о команде
 * @see Command
 */
class ConsoleWriter
{
    private string $renderData;

    private const TAB_SYM = '    ';

    private const DOUBLE_TAB_SYM = '        ';

    public function __construct(protected array $data)
    {
    }

    public function write(): void
    {
        $this->setName();
        $this->setArguments();
        $this->setOptions();

        print_r($this->renderData);
    }

    private function setName(): void
    {
        $this->renderData = sprintf(PHP_EOL . 'Called command : %s' . PHP_EOL, $this->data['name']);
    }

    private function setArguments(): void
    {
        $this->renderData .= PHP_EOL . 'Arguments: ' . PHP_EOL;

        foreach ($this->data['arguments'] as $argument) {
            $row = sprintf(self::TAB_SYM . '-' . self::TAB_SYM . '%s' . PHP_EOL, $argument);

            $this->renderData .= $row;
        }
    }

    private function setOptions(): void
    {
        $this->renderData .= PHP_EOL . 'Options: ' . PHP_EOL;

        foreach ($this->data['options'] as $part => $values) {
            $row = sprintf(self::TAB_SYM . '-' . self::TAB_SYM . '%s' . PHP_EOL, $part);

            $this->renderData .= $row;

            if (is_iterable($values)) {
                foreach ($values as $value) {
                    $row = sprintf(self::DOUBLE_TAB_SYM . '-' . self::TAB_SYM . '%s' . PHP_EOL, $value);

                    $this->renderData .= $row;
                }
            } else {
                $row = sprintf(self::DOUBLE_TAB_SYM . '-' . self::TAB_SYM . '%s' . PHP_EOL, $values);

                $this->renderData .= $row;
            }
        }
    }
}