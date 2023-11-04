<?php

namespace refaltor\ui\elements;

class StackPanel extends Panel implements \JsonSerializable
{
    private string $orientation;

    public function __construct(string $name, string $orientation, ?string $extend = null)
    {
        $this->orientation = $orientation;
        parent::__construct($name, $extend);
    }

    public static function create(string $name): self
    {
        return new self($name, "");
    }

    public function jsonSerialize()
    {
        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;


        $data =  parent::jsonSerialize();
        $data[$name]['orientation'] = $this->orientation;
        $data[$name]['type'] = 'stack_panel';
        return $data;
    }

    /**
     * @return string
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    /**
     * @param string $orientation
     */
    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;
        return $this;
    }
}