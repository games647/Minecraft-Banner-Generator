<?php

namespace MinecraftBanner;

class MinecraftBanner
{

    const COLOR_CHAR = "§";
    const COLORS = [
        '0' => [0, 0, 0], //Black
        '1' => [0, 0, 170], //Dark Blue
        '2' => [0, 170, 0], //Dark Green
        '3' => [0, 170, 170], //Dark Aqua
        '4' => [170, 0, 0], //Dark Red
        '5' => [170, 0, 170], //Dark Purple
        '6' => [255, 170, 0], //Gold
        '7' => [170, 170, 170], //Gray
        '8' => [85, 85, 85], //Dark Gray
        '9' => [85, 85, 255], //Blue
        'a' => [85, 255, 85], //Green
        'b' => [85, 255, 255], //Aqua
        'c' => [255, 85, 85], //Red
        'd' => [255, 85, 85], //Light Purple
        'e' => [255, 255, 85], //Yellow
        'f' => [255, 255, 255], //White
    ];

    const TEXTURE_SIZE = 32;
    const FONT_FILE = __DIR__ . '/minecraft.ttf';

    const DEFAULT_BACKGROUND = NULL;
    const CLOUDS_BACKGROUND = "0";
    const LILLY_PADS_BACKGROUND = "1";
    const HILLS_BACKGROUND = "2";
    const WATERFALL_BACKGROUND = "3";
    const CANYON_BACKGROUND = "4";
    const GRASSLAND_BACKGROUND = "5";
    const GRASSLAND_CANYON_BACKGROUND = "6";
    const SWAMP_BACKGROUND = "7";
    const LAKE_BACKGROUND = "8";
    const SWAMP2_BACKGROUND = "9";
    const LILLY_PADS_SWAMP_BACKGROUND = "10";

    public static function getBackgroundCanvas($width, $height, $background)
    {
        $canvas = imagecreatetruecolor($width, $height);
        if ($background == NULL) {
            $background = imagecreatefrompng(__DIR__ . '/img/texture.png');
        } else if (file_exists(__DIR__ . '/img/backgrounds/' . $background . '.png')) {
            $background = imagecreatefrompng(__DIR__ . '/img/backgrounds/' . $background . '.png');
        } else {
            if (stristr($background, "http://") || stristr($background, "https://") || file_exists($background)) {
                $info = pathinfo($background);
                $ext = $info['extension'];

                switch ($ext) {
                    case "png":
                        $background = imagecreatefrompng($background);
                        break;
                    case "jpg":
                        $background = imagecreatefromjpeg($background);
                        break;
                    case "gif":
                        $background = imagecreatefromgif($background);
                        break;
                    default:
                        $background = imagecreatefrompng(__DIR__ . '/img/texture.png');
                }
            } else {
                $background = imagecreatefrompng(__DIR__ . '/img/texture.png');
            }
        }

        if (imagesx($background) == self::TEXTURE_SIZE) {
            for ($yPos = 0; $yPos <= ($height / self::TEXTURE_SIZE); $yPos++) {
                for ($xPos = 0; $xPos <= ($width / self::TEXTURE_SIZE); $xPos++) {
                    $startX = $xPos * self::TEXTURE_SIZE;
                    $startY = $yPos * self::TEXTURE_SIZE;
                    imagecopyresampled($canvas, $background, $startX, $startY, 0, 0
                            , self::TEXTURE_SIZE, self::TEXTURE_SIZE
                            , self::TEXTURE_SIZE, self::TEXTURE_SIZE);
                }
            }
        } else {
            imagecopyresampled($canvas, $background, 0, 0, 0, 0, $width, $height, $width, $height);
        }

        return $canvas;
    }
}
