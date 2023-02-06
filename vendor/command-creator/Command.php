<?php

declare(strict_types=1);

namespace Creator;

class Command
{
    public function __construct(
        protected string $name,
        protected array  $arguments,
        protected array  $options
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'arguments' => $this->arguments,
            'options' => $this->options,
        ];
    }

    public function showInfo(): void
    {
        dd();
    }
}