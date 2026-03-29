<?php

namespace refaltor\ui\components;

class Animation implements \JsonSerializable
{
    private string $name;
    private string $animType = "alpha";
    private float $duration = 1.0;
    private $from = null;
    private $to = null;
    private string $easing = "linear";
    private float $delay = 0.0;
    private string $next = "";
    private bool $destroyAtEnd = false;
    private bool $playEvent = false;
    private string $endEvent = "";
    private string $startEvent = "";
    private string $resetEvent = "";
    private bool $reversible = false;
    private float $fps = 60.0;
    private array $frames = [];
    private int $frameCount = 0;
    private float $frameStep = 0.0;
    private bool $resettable = false;
    private float $scaleFromStartingAlpha = 0.0;
    private bool $activated = true;
    private string $initialUv = "";

    const TYPE_ALPHA = "alpha";
    const TYPE_OFFSET = "offset";
    const TYPE_SIZE = "size";
    const TYPE_FLIP_BOOK = "flip_book";
    const TYPE_UV = "uv";
    const TYPE_COLOR = "color";
    const TYPE_WAIT = "wait";
    const TYPE_ASEPRITE_FLIP_BOOK = "aseprite_flip_book";
    const TYPE_CLIP = "clip";

    const EASING_LINEAR = "linear";
    const EASING_SPRING = "spring";
    const EASING_IN_QUAD = "in_quad";
    const EASING_OUT_QUAD = "out_quad";
    const EASING_IN_OUT_QUAD = "in_out_quad";
    const EASING_IN_CUBIC = "in_cubic";
    const EASING_OUT_CUBIC = "out_cubic";
    const EASING_IN_OUT_CUBIC = "in_out_cubic";
    const EASING_IN_QUART = "in_quart";
    const EASING_OUT_QUART = "out_quart";
    const EASING_IN_OUT_QUART = "in_out_quart";
    const EASING_IN_QUINT = "in_quint";
    const EASING_OUT_QUINT = "out_quint";
    const EASING_IN_OUT_QUINT = "in_out_quint";
    const EASING_IN_SINE = "in_sine";
    const EASING_OUT_SINE = "out_sine";
    const EASING_IN_OUT_SINE = "in_out_sine";
    const EASING_IN_EXPO = "in_expo";
    const EASING_OUT_EXPO = "out_expo";
    const EASING_IN_OUT_EXPO = "in_out_expo";
    const EASING_IN_CIRC = "in_circ";
    const EASING_OUT_CIRC = "out_circ";
    const EASING_IN_OUT_CIRC = "in_out_circ";
    const EASING_IN_BOUNCE = "in_bounce";
    const EASING_OUT_BOUNCE = "out_bounce";
    const EASING_IN_OUT_BOUNCE = "in_out_bounce";
    const EASING_IN_BACK = "in_back";
    const EASING_OUT_BACK = "out_back";
    const EASING_IN_OUT_BACK = "in_out_back";
    const EASING_IN_ELASTIC = "in_elastic";
    const EASING_OUT_ELASTIC = "out_elastic";
    const EASING_IN_OUT_ELASTIC = "in_out_elastic";

    public function __construct(string $name, string $animType = self::TYPE_ALPHA)
    {
        $this->name = $name;
        $this->animType = $animType;
    }

    public static function create(string $name, string $animType = self::TYPE_ALPHA): self
    {
        return new self($name, $animType);
    }

    public static function fadeIn(string $name, float $duration = 0.5): self
    {
        return (new self($name, self::TYPE_ALPHA))
            ->setFrom(0.0)
            ->setTo(1.0)
            ->setDuration($duration);
    }

    public static function fadeOut(string $name, float $duration = 0.5): self
    {
        return (new self($name, self::TYPE_ALPHA))
            ->setFrom(1.0)
            ->setTo(0.0)
            ->setDuration($duration);
    }

    public static function slideIn(string $name, array $from, float $duration = 0.3, string $easing = self::EASING_OUT_QUAD): self
    {
        return (new self($name, self::TYPE_OFFSET))
            ->setFrom($from)
            ->setTo([0, 0])
            ->setDuration($duration)
            ->setEasing($easing);
    }

    public static function pulse(string $name, array $sizeFrom, array $sizeTo, float $duration = 0.5): self
    {
        return (new self($name, self::TYPE_SIZE))
            ->setFrom($sizeFrom)
            ->setTo($sizeTo)
            ->setDuration($duration)
            ->setEasing(self::EASING_IN_OUT_SINE);
    }

    public function setAnimType(string $type): self
    {
        $this->animType = $type;
        return $this;
    }

    public function setDuration(float $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function setFrom($from): self
    {
        $this->from = $from;
        return $this;
    }

    public function setTo($to): self
    {
        $this->to = $to;
        return $this;
    }

    public function setEasing(string $easing): self
    {
        $this->easing = $easing;
        return $this;
    }

    public function setDelay(float $delay): self
    {
        $this->delay = $delay;
        return $this;
    }

    public function setNext(string $next): self
    {
        $this->next = $next;
        return $this;
    }

    public function setDestroyAtEnd(bool $destroy): self
    {
        $this->destroyAtEnd = $destroy;
        return $this;
    }

    public function setEndEvent(string $event): self
    {
        $this->endEvent = $event;
        return $this;
    }

    public function setStartEvent(string $event): self
    {
        $this->startEvent = $event;
        return $this;
    }

    public function setResetEvent(string $event): self
    {
        $this->resetEvent = $event;
        return $this;
    }

    public function setReversible(bool $reversible): self
    {
        $this->reversible = $reversible;
        return $this;
    }

    public function setFps(float $fps): self
    {
        $this->fps = $fps;
        return $this;
    }

    public function setFrames(array $frames): self
    {
        $this->frames = $frames;
        return $this;
    }

    public function setFrameCount(int $count): self
    {
        $this->frameCount = $count;
        return $this;
    }

    public function setFrameStep(float $step): self
    {
        $this->frameStep = $step;
        return $this;
    }

    public function setResettable(bool $resettable): self
    {
        $this->resettable = $resettable;
        return $this;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        $data = [
            "anim_type" => $this->animType,
            "duration" => $this->duration,
            "easing" => $this->easing,
        ];

        if ($this->from !== null) $data["from"] = $this->from;
        if ($this->to !== null) $data["to"] = $this->to;
        if ($this->delay > 0) $data["delay"] = $this->delay;
        if ($this->next !== '') $data["next"] = $this->next;
        if ($this->destroyAtEnd) $data["destroy_at_end"] = $this->name;
        if ($this->endEvent !== '') $data["end_event"] = $this->endEvent;
        if ($this->startEvent !== '') $data["start_event"] = $this->startEvent;
        if ($this->resetEvent !== '') $data["reset_event"] = $this->resetEvent;
        if ($this->reversible) $data["reversible"] = true;
        if ($this->resettable) $data["resettable"] = true;
        if (!$this->activated) $data["activated"] = false;

        if ($this->animType === self::TYPE_FLIP_BOOK || $this->animType === self::TYPE_ASEPRITE_FLIP_BOOK) {
            $data["fps"] = $this->fps;
            if (!empty($this->frames)) $data["frames"] = $this->frames;
            if ($this->frameCount > 0) $data["frame_count"] = $this->frameCount;
            if ($this->frameStep > 0) $data["frame_step"] = $this->frameStep;
            if ($this->initialUv !== '') $data["initial_uv"] = $this->initialUv;
        }

        return [$this->name => $data];
    }
}
