<?php

namespace refaltor\ui\components;

class Binding implements \JsonSerializable
{
    private string $bindingType = "global";
    private string $bindingName = "";
    private string $bindingNameOverride = "";
    private string $bindingCollectionName = "";
    private string $bindingCondition = "always";
    private string $sourceControlName = "";
    private string $sourcePropertyName = "";
    private string $targetPropertyName = "";
    private bool $resolveSimdOperations = false;

    const TYPE_GLOBAL = "global";
    const TYPE_VIEW = "view";
    const TYPE_COLLECTION = "collection";
    const TYPE_COLLECTION_DETAILS = "collection_details";
    const TYPE_NONE = "none";

    const CONDITION_ALWAYS = "always";
    const CONDITION_ONCE = "once";
    const CONDITION_VISIBLE = "visible";
    const CONDITION_ALWAYS_WHEN_VISIBLE = "always_when_visible";
    const CONDITION_VISIBILITY_CHANGED = "visibility_changed";
    const CONDITION_NONE = "none";

    public static function global(string $bindingName, string $bindingNameOverride = ""): self
    {
        $binding = new self();
        $binding->bindingType = self::TYPE_GLOBAL;
        $binding->bindingName = $bindingName;
        if ($bindingNameOverride !== '') {
            $binding->bindingNameOverride = $bindingNameOverride;
        }
        return $binding;
    }

    public static function view(string $sourcePropertyName, string $targetPropertyName): self
    {
        $binding = new self();
        $binding->bindingType = self::TYPE_VIEW;
        $binding->sourcePropertyName = $sourcePropertyName;
        $binding->targetPropertyName = $targetPropertyName;
        return $binding;
    }

    public static function collection(string $bindingName, string $collectionName, string $bindingNameOverride = ""): self
    {
        $binding = new self();
        $binding->bindingType = self::TYPE_COLLECTION;
        $binding->bindingName = $bindingName;
        $binding->bindingCollectionName = $collectionName;
        if ($bindingNameOverride !== '') {
            $binding->bindingNameOverride = $bindingNameOverride;
        }
        return $binding;
    }

    public static function collectionDetails(string $collectionName): self
    {
        $binding = new self();
        $binding->bindingType = self::TYPE_COLLECTION_DETAILS;
        $binding->bindingCollectionName = $collectionName;
        return $binding;
    }

    public static function visibility(string $condition): self
    {
        $binding = new self();
        $binding->bindingType = self::TYPE_VIEW;
        $binding->sourcePropertyName = $condition;
        $binding->targetPropertyName = "#visible";
        return $binding;
    }

    public function setBindingType(string $type): self
    {
        $this->bindingType = $type;
        return $this;
    }

    public function setBindingName(string $name): self
    {
        $this->bindingName = $name;
        return $this;
    }

    public function setBindingNameOverride(string $override): self
    {
        $this->bindingNameOverride = $override;
        return $this;
    }

    public function setBindingCollectionName(string $name): self
    {
        $this->bindingCollectionName = $name;
        return $this;
    }

    public function setBindingCondition(string $condition): self
    {
        $this->bindingCondition = $condition;
        return $this;
    }

    public function setSourceControlName(string $name): self
    {
        $this->sourceControlName = $name;
        return $this;
    }

    public function setSourcePropertyName(string $name): self
    {
        $this->sourcePropertyName = $name;
        return $this;
    }

    public function setTargetPropertyName(string $name): self
    {
        $this->targetPropertyName = $name;
        return $this;
    }

    public function setResolveSimdOperations(bool $resolve): self
    {
        $this->resolveSimdOperations = $resolve;
        return $this;
    }

    public function jsonSerialize()
    {
        $data = [
            "binding_type" => $this->bindingType,
        ];

        if ($this->bindingName !== '') $data["binding_name"] = $this->bindingName;
        if ($this->bindingNameOverride !== '') $data["binding_name_override"] = $this->bindingNameOverride;
        if ($this->bindingCollectionName !== '') $data["binding_collection_name"] = $this->bindingCollectionName;
        if ($this->bindingCondition !== 'always') $data["binding_condition"] = $this->bindingCondition;
        if ($this->sourceControlName !== '') $data["source_control_name"] = $this->sourceControlName;
        if ($this->sourcePropertyName !== '') $data["source_property_name"] = $this->sourcePropertyName;
        if ($this->targetPropertyName !== '') $data["target_property_name"] = $this->targetPropertyName;
        if ($this->resolveSimdOperations) $data["resolve_simd_operations"] = true;

        return $data;
    }
}
