<?php

namespace refaltor\ui\elements;

class Grid extends Element implements \JsonSerializable
{
    private array $gridDimensions = [0, 0];
    private int $maximumGridItems = 0;
    private string $gridDimensionBinding = '';
    private string $gridRescalingType = 'none';
    private string $gridFillDirection = 'none';
    private string $gridItemTemplate = '';
    private int $precachedGridItemCount = 0;

    public function __construct(
        string $name,
        ?string $extend = null
    )
    {
        $this->name = $name;
        $this->extend = $extend;

        parent::__construct($name, $extend);
    }

    public static function create(string $name): self {
        return new self($name);
    }

    public function jsonSerialize()
    {
        $dataParent = parent::jsonSerialize();
        $propertiesExtra = $dataParent['properties_extra'];
        $controls = $dataParent['controls'];

        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;

        $element = [$name => [
            "type" => "grid",
            "grid_dimensions" => $this->gridDimensions,
            "maximum_grid_items" => $this->maximumGridItems,
            "grid_dimension_binding" => $this->gridDimensionBinding,
            "grid_rescaling_type" => $this->gridRescalingType,
            "grid_fill_direction" => $this->gridFillDirection,
            "grid_item_template" => $this->gridItemTemplate,
            "precached_grid_item_count" => $this->precachedGridItemCount,
        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }

    public function getGridDimensions(): array
    {
        return $this->gridDimensions;
    }

    public function setGridDimensions(array $gridDimensions): Grid
    {
        $this->gridDimensions = $gridDimensions;
        return $this;
    }

    public function getMaximumGridItems(): int
    {
        return $this->maximumGridItems;
    }

    public function setMaximumGridItems(int $maximumGridItems): Grid
    {
        $this->maximumGridItems = $maximumGridItems;
        return $this;
    }

    public function getGridDimensionBinding(): string
    {
        return $this->gridDimensionBinding;
    }

    public function setGridDimensionBinding(string $gridDimensionBinding): Grid
    {
        $this->gridDimensionBinding = $gridDimensionBinding;
        return $this;
    }

    public function getGridRescalingType(): string
    {
        return $this->gridRescalingType;
    }

    public function setGridRescalingType(string $gridRescalingType): Grid
    {
        $this->gridRescalingType = $gridRescalingType;
        return $this;
    }

    public function getGridFillDirection(): string
    {
        return $this->gridFillDirection;
    }

    public function setGridFillDirection(string $gridFillDirection): Grid
    {
        $this->gridFillDirection = $gridFillDirection;
        return $this;
    }

    public function getGridItemTemplate(): string
    {
        return $this->gridItemTemplate;
    }

    public function setGridItemTemplate(string $gridItemTemplate): Grid
    {
        $this->gridItemTemplate = $gridItemTemplate;
        return $this;
    }

    public function getPrecachedGridItemCount(): int
    {
        return $this->precachedGridItemCount;
    }

    public function setPrecachedGridItemCount(int $precachedGridItemCount): Grid
    {
        $this->precachedGridItemCount = $precachedGridItemCount;
        return $this;
    }
}
