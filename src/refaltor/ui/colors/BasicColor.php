<?php

namespace refaltor\ui\colors;

class BasicColor
{
    const DEFAULT = [1.0, 1.0, 1.0];

    public static function black(): array {
        return [0.0, 0.0, 0.0];
    }

    public static function rgb(float $r, float $g, float $b): array {
        return [$r, $g, $b];
    }

    public static function white(): array {
        return [1.0, 1.0, 1.0];
    }

    public static function red(): array {
        return [1.0, 0.0, 0.0];
    }

    public static function green(): array {
        return [0.0, 1.0, 0.0];
    }

    public static function blue(): array {
        return [0.0, 0.0, 1.0];
    }

    public static function yellow(): array {
        return [1.0, 1.0, 0.0];
    }

    public static function cyan(): array {
        return [0.0, 1.0, 1.0];
    }

    public static function magenta(): array {
        return [1.0, 0.0, 1.0];
    }

    public static function randomColor(): array {
        $red = rand(0, 100) / 100.0;
        $green = rand(0, 100) / 100.0;
        $blue = rand(0, 100) / 100.0;

        return [$red, $green, $blue];
    }

    public static function randomShadeOfGray(): array {
        $shade = rand(0, 100) / 100.0;
        return [$shade, $shade, $shade];
    }

    public static function randomPastelColor(): array {
        $red = (rand(150, 255) / 255.0);
        $green = (rand(150, 255) / 255.0);
        $blue = (rand(150, 255) / 255.0);

        return [$red, $green, $blue];
    }

    public static function complementaryColor(array $color): array {
        $complementary = [1.0 - $color[0], 1.0 - $color[1], 1.0 - $color[2]];
        return $complementary;
    }
}
