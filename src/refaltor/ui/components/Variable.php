<?php

namespace refaltor\ui\components;

class Variable implements \JsonSerializable
{
    private string $condition = "";
    private array $values = [];

    public function __construct(string $condition, array $values = [])
    {
        $this->condition = $condition;
        $this->values = $values;
    }

    public static function create(string $condition): self
    {
        return new self($condition);
    }

    public static function when(string $condition, array $values): self
    {
        return new self($condition, $values);
    }

    public function requires(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    public function set(string $name, $value): self
    {
        $this->values[$name] = $value;
        return $this;
    }

    public function setValues(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $data = [
            "requires" => $this->condition,
        ];

        foreach ($this->values as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}
