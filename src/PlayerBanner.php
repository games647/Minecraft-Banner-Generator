<?php

namespace MinecraftBanner;

require_once __DIR__ . "/MinecraftBanner.php";

class PlayerBanner
{

    const PLAYER_WIDTH = 320;
    const PLAYER_HEIGHT = 80;

    const PLAYER_PADDING = 5;
    const AVATAR_SIZE = 64;

    const TEXT_SIZE = 14;

    /**
     *
     * @param string $playername Minecraft player name
     * @param resource $avatar the rendered avatar (for example player head)
     *
     * @param string $background Image Path or Standard Value
     * @return resource the generated banner
     */
    public static function player($playername, $avatar = NULL, $background = NULL)
    {
        $canvas = MinecraftBanner::getBackgroundCanvas(self::PLAYER_WIDTH, self::PLAYER_HEIGHT, $background);

        $head_height = self::AVATAR_SIZE;
        $head_width = self::AVATAR_SIZE;

        $avater_x = self::PLAYER_PADDING;
        $avater_y = self::PLAYER_HEIGHT / 2 - self::AVATAR_SIZE / 2;
        if ($avatar == NULL) {
            $avatar = imagecreatefrompng(__DIR__ . "/img/head.png");
            imagesavealpha($avatar, true);

            imagecopy($canvas, $avatar, $avater_x, $avater_y, 0, 0, $head_width, $head_height);
        } else {
            $head_width = imagesx($avatar);
            $head_height = imagesy($avatar);
            if ($head_width > self::AVATAR_SIZE) {
                $head_width = self::AVATAR_SIZE;
            }

            if ($head_height > self::AVATAR_SIZE) {
                $head_height = self::AVATAR_SIZE;
            }

            $center_x = $avater_x + self::AVATAR_SIZE / 2 - $head_width / 2;
            $center_y = $avater_y + self::AVATAR_SIZE / 2 - $head_height / 2;
            imagecopy($canvas, $avatar, $center_x, $center_y, 0, 0, $head_width, $head_height);
        }

        $box = imagettfbbox(self::TEXT_SIZE, 0, MinecraftBanner::FONT_FILE, $playername);
        $text_width = abs($box[4] - $box[0]);

        $text_color = imagecolorallocate($canvas, 255, 255, 255);
        $remaining = self::PLAYER_WIDTH - self::AVATAR_SIZE - $avater_x - self::PLAYER_PADDING;

        $text_posX = $avater_x + self::AVATAR_SIZE + $remaining / 2 - $text_width / 2;
        $text_posY = $avater_y + self::AVATAR_SIZE / 2 + self::TEXT_SIZE / 2;
        imagettftext($canvas, self::TEXT_SIZE, 0
                , $text_posX, $text_posY, $text_color, MinecraftBanner::FONT_FILE, $playername);

        return $canvas;
    }
}
