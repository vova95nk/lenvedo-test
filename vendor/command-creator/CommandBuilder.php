<?php

declare(strict_types=1);

namespace Creator;

use Exception;
use Creator\Command;

class CommandBuilder
{
    public string $commandName;

    public array $arguments;

    public array $options;

    /**
     * @throws Exception
     */
    public function __construct(protected array $input)
    {
        $this->setName();
        $this->setArguments();
        $this->setOptions();
    }

    /**
     * @throws Exception
     */
    private function setName(): void
    {
        $name = $this->input[1];

        if (preg_match("[^\w]u", $name)) {
            $this->commandName = $name;

            unset($this->input[1]);
        } else {
            throw new Exception('Не задано имя для команды');
        }
    }

    /**
     * @throws Exception
     */
    private function setArguments(): void
    {
        $result = [];

        foreach ($this->input as $data) {
            if (preg_match("[^\w]u", $data)) {
                $result[] = $data;

                continue;
            }

            if (preg_match('[^\{]', $data)) {
                $result[] = str_replace(['{', '}'], '', $data);
            }
        }

        if (count($result) === 0) {
            throw new Exception('Не переданы аргументы');
        }

        $this->arguments = $result;
    }

    /**
     * @throws Exception
     */
    private function setOptions(): void
    {
        $result = [];

        foreach ($this->input as $data) {
            if (preg_match('[^\[]', $data)) {
                $option = str_replace(['[', ']'], '', $data);
                $option = explode('=', $option);

                if (count($option) === 2) {
                    $result[$option[0]] = $option[1];
                }
            }
        }

        if (count($result) === 0) {
            throw new Exception('Не переданы опции');
        }

        $this->options = $result;
    }

    public function get(): Command
    {
        return new Command(
            $this->commandName,
            $this->arguments,
            $this->options
        );
    }
}