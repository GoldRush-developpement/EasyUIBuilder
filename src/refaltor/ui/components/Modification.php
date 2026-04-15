<?php

namespace refaltor\ui\components;

class Modification implements \JsonSerializable
{
    private string $arrayName = '';
    private string $operation;
    private $value = null;
    private string $controlName = '';
    private array $where = [];
    private array $target = [];

    const OP_INSERT_BACK = 'insert_back';
    const OP_INSERT_FRONT = 'insert_front';
    const OP_INSERT_AFTER = 'insert_after';
    const OP_INSERT_BEFORE = 'insert_before';
    const OP_MOVE_BACK = 'move_back';
    const OP_MOVE_FRONT = 'move_front';
    const OP_MOVE_AFTER = 'move_after';
    const OP_MOVE_BEFORE = 'move_before';
    const OP_SWAP = 'swap';
    const OP_REPLACE = 'replace';
    const OP_REMOVE = 'remove';

    const ARRAY_CONTROLS = 'controls';
    const ARRAY_BINDINGS = 'bindings';
    const ARRAY_VARIABLES = 'variables';
    const ARRAY_ANIMS = 'anims';
    const ARRAY_BUTTON_MAPPINGS = 'button_mappings';

    public function __construct(string $operation)
    {
        $this->operation = $operation;
    }

    // ---- Factory methods for insert operations ----

    public static function insertBack(string $arrayName): self
    {
        $mod = new self(self::OP_INSERT_BACK);
        $mod->arrayName = $arrayName;
        return $mod;
    }

    public static function insertFront(string $arrayName): self
    {
        $mod = new self(self::OP_INSERT_FRONT);
        $mod->arrayName = $arrayName;
        return $mod;
    }

    public static function insertAfter(string $controlName): self
    {
        $mod = new self(self::OP_INSERT_AFTER);
        $mod->controlName = $controlName;
        return $mod;
    }

    public static function insertBefore(string $controlName): self
    {
        $mod = new self(self::OP_INSERT_BEFORE);
        $mod->controlName = $controlName;
        return $mod;
    }

    public static function insertAfterWhere(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_INSERT_AFTER);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    public static function insertBeforeWhere(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_INSERT_BEFORE);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    // ---- Factory methods for move operations ----

    public static function moveBack(string $arrayName): self
    {
        $mod = new self(self::OP_MOVE_BACK);
        $mod->arrayName = $arrayName;
        return $mod;
    }

    public static function moveFront(string $arrayName): self
    {
        $mod = new self(self::OP_MOVE_FRONT);
        $mod->arrayName = $arrayName;
        return $mod;
    }

    public static function moveAfter(string $controlName): self
    {
        $mod = new self(self::OP_MOVE_AFTER);
        $mod->controlName = $controlName;
        return $mod;
    }

    public static function moveBefore(string $controlName): self
    {
        $mod = new self(self::OP_MOVE_BEFORE);
        $mod->controlName = $controlName;
        return $mod;
    }

    public static function moveBackWhere(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_MOVE_BACK);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    public static function moveFrontWhere(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_MOVE_FRONT);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    public static function moveAfterWhere(string $arrayName, array $where, array $target): self
    {
        $mod = new self(self::OP_MOVE_AFTER);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        $mod->target = $target;
        return $mod;
    }

    public static function moveBeforeWhere(string $arrayName, array $where, array $target): self
    {
        $mod = new self(self::OP_MOVE_BEFORE);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        $mod->target = $target;
        return $mod;
    }

    // ---- Factory methods for swap/replace/remove ----

    public static function swap(string $arrayName, array $where, array $target): self
    {
        $mod = new self(self::OP_SWAP);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        $mod->target = $target;
        return $mod;
    }

    public static function replace(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_REPLACE);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    public static function remove(string $arrayName, array $where): self
    {
        $mod = new self(self::OP_REMOVE);
        $mod->arrayName = $arrayName;
        $mod->where = $where;
        return $mod;
    }

    // ---- Chainable setters ----

    public function setArrayName(string $arrayName): self
    {
        $this->arrayName = $arrayName;
        return $this;
    }

    public function setOperation(string $operation): self
    {
        $this->operation = $operation;
        return $this;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function setControlName(string $controlName): self
    {
        $this->controlName = $controlName;
        return $this;
    }

    public function setWhere(array $where): self
    {
        $this->where = $where;
        return $this;
    }

    public function setTarget(array $target): self
    {
        $this->target = $target;
        return $this;
    }

    // ---- Getters ----

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getArrayName(): string
    {
        return $this->arrayName;
    }

    // ---- Serialization ----

    public function jsonSerialize(): mixed
    {
        $data = [];

        if ($this->arrayName !== '') {
            $data['array_name'] = $this->arrayName;
        }

        $data['operation'] = $this->operation;

        if ($this->controlName !== '') {
            $data['control_name'] = $this->controlName;
        }

        if (!empty($this->where)) {
            $data['where'] = $this->where;
        }

        if (!empty($this->target)) {
            $data['target'] = $this->target;
        }

        if ($this->value !== null) {
            $data['value'] = $this->value;
        }

        return $data;
    }
}
