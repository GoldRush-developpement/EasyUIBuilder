<?php

namespace refaltor\ui\elements;

class Image extends Element implements \JsonSerializable
{
    private string $texture;
    private bool $allowDebugMissingTexture = true;
    private array $uv = [0, 0];
    private array $uvSize = [0, 0];
    private string $textureFileSystem = "InUserPackage";
    private $ninesliceSize;
    private $tiled = false;
    private $tiledScale = [1.0, 1.0];
    private string $clipDirection = "left";
    private float $clipRatio = 0.0;
    private bool $clipPixelPerfect = false;
    private bool $keepRatio = true;
    private bool $bilinear = false;
    private bool $fill = false;
    private $fitToWidth;
    private string $zipFolder = "";
    private bool $grayscale = false;
    private bool $forceTextureReload = false;
    private array $baseSize = [0, 0];

    public function __construct(
        string $name,
        string $texture,
        ?string $extend = null
    )
    {
        $this->name = $name;
        $this->texture = $texture;
        $this->extend = $extend;

        parent::__construct($name, $extend);
    }


    public static function create(string $name, string $texture): self {
        return new self($name, $texture);
    }

    public function getTexture(): string
    {
        return $this->texture;
    }

    public function setTexture(string $texture): Image
    {
        $this->texture = $texture;
        return $this;
    }

    public function isAllowDebugMissingTexture(): bool
    {
        return $this->allowDebugMissingTexture;
    }

    public function setAllowDebugMissingTexture(bool $allowDebugMissingTexture): Image
    {
        $this->allowDebugMissingTexture = $allowDebugMissingTexture;
        return $this;
    }

    public function getUv(): array
    {
        return $this->uv;
    }

    public function setUv(array $uv): Image
    {
        $this->uv = $uv;
        return $this;
    }

    public function getUvSize(): array
    {
        return $this->uvSize;
    }

    public function setUvSize(array $uvSize): Image
    {
        $this->uvSize = $uvSize;
        return $this;
    }

    public function getTextureFileSystem(): string
    {
        return $this->textureFileSystem;
    }

    public function setTextureFileSystem(string $textureFileSystem): Image
    {
        $this->textureFileSystem = $textureFileSystem;
        return $this;
    }

    public function getNinesliceSize()
    {
        return $this->ninesliceSize;
    }

    public function setNinesliceSize($ninesliceSize): Image
    {
        $this->ninesliceSize = $ninesliceSize;
        return $this;
    }

    public function isTiled()
    {
        return $this->tiled;
    }

    public function setTiled($tiled): Image
    {
        $this->tiled = $tiled;
        return $this;
    }

    public function getTiledScale()
    {
        return $this->tiledScale;
    }

    public function setTiledScale($tiledScale): Image
    {
        $this->tiledScale = $tiledScale;
        return $this;
    }

    public function getClipDirection(): string
    {
        return $this->clipDirection;
    }

    public function setClipDirection(string $clipDirection): Image
    {
        $this->clipDirection = $clipDirection;
        return $this;
    }

    public function getClipRatio(): float
    {
        return $this->clipRatio;
    }

    public function setClipRatio(float $clipRatio): Image
    {
        $this->clipRatio = $clipRatio;
        return $this;
    }

    public function isClipPixelPerfect(): bool
    {
        return $this->clipPixelPerfect;
    }

    public function setClipPixelPerfect(bool $clipPixelPerfect): Image
    {
        $this->clipPixelPerfect = $clipPixelPerfect;
        return $this;
    }

    public function isKeepRatio(): bool
    {
        return $this->keepRatio;
    }

    public function setKeepRatio(bool $keepRatio): Image
    {
        $this->keepRatio = $keepRatio;
        return $this;
    }

    public function isBilinear(): bool
    {
        return $this->bilinear;
    }

    public function setBilinear(bool $bilinear): Image
    {
        $this->bilinear = $bilinear;
        return $this;
    }

    public function isFill(): bool
    {
        return $this->fill;
    }

    public function setFill(bool $fill = true): Image
    {
        $this->fill = $fill;
        return $this;
    }

    public function getFitToWidth()
    {
        return $this->fitToWidth;
    }

    public function setFitToWidth($fitToWidth): Image
    {
        $this->fitToWidth = $fitToWidth;
        return $this;
    }

    public function getZipFolder(): string
    {
        return $this->zipFolder;
    }

    public function setZipFolder(string $zipFolder): Image
    {
        $this->zipFolder = $zipFolder;
        return $this;
    }

    public function isGrayscale(): bool
    {
        return $this->grayscale;
    }

    public function setGrayscale(bool $grayscale): Image
    {
        $this->grayscale = $grayscale;
        return $this;
    }

    public function isForceTextureReload(): bool
    {
        return $this->forceTextureReload;
    }

    public function setForceTextureReload(bool $forceTextureReload): Image
    {
        $this->forceTextureReload = $forceTextureReload;
        return $this;
    }

    public function getBaseSize(): array
    {
        return $this->baseSize;
    }

    public function setBaseSize(array $baseSize): Image
    {
        $this->baseSize = $baseSize;
        return $this;
    }



    public function jsonSerialize()
    {
        $dataParent = parent::jsonSerialize();
        $propertiesExtra = $dataParent['properties_extra'];
        $controls = $this->controls;

        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;

        $element = [$name => [
            "type" => "image",
            "texture" => $this->texture,
            "allow_debug_missing_texture" => $this->allowDebugMissingTexture,
            "uv" => $this->uv,
            "uv_size" => $this->uvSize,
            "texture_file_system" => $this->textureFileSystem,
            "nineslice_size" => $this->ninesliceSize,
            "tiled" => $this->tiled,
            "tiled_scale" => $this->tiledScale,
            "clip_direction" => $this->clipDirection,
            "clip_ratio" => $this->clipRatio,
            "clip_pixelperfect" => $this->clipPixelPerfect,
            "keep_ratio" => $this->keepRatio,
            "bilinear" => $this->bilinear,
            "fill" => $this->fill,
            "fit_to_width" => $this->fitToWidth,
            "zip_folder" => $this->zipFolder,
            "grayscale" => $this->grayscale,
            "force_texture_reload" => $this->forceTextureReload,
            "base_size" => $this->baseSize,
        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }
        return $element;
    }
}
