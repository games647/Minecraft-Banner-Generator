<?php

namespace MinecraftBanner;

class MinecraftBanner {

    const PLAYER_WIDTH = 320;
    const PLAYER_HEIGHT = 80;

    const PLAYER_PADDING = 5;
    const AVATAR_SIZE = 64;

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
        'f' => [255, 255, 255],  //White
    ];

    const WIDTH = 650;
    const HEIGHT = 80;
    const PADDING = 3;

    const TEXTURE_SIZE = 32;
    const FAVICON_SIZE = 64;

    const FONT_FILE = __DIR__  . '/minecraft.ttf';

    const TITLE_SIZE = 13;
    const MOTD_TEXT_SIZE = 12;
    const PLAYERS_TEXT_SIZE = 14;
    const PING_WIDTH = 36;
    const PING_HEIGHT = 29;

    const PING_WELL = 150;
    const PING_GOOD = 300;
    const PING_WORSE = 400;
    const PING_WORST = 500;

    /**
     *
     * @param string $address the server address
     * @param string $motd message of the day whcih should be displayed
     * @param int $players not implemented
     * @param int $max_players not implemented
     * @param resource $favicon not implemented
     * @param int $ping not implemented
     *
     * @return resource the rendered banner
     */
    public static function server($address, $motd = "§cOffline Server", $players = -1, $max_players = -1, $favicon = NULL, $ping = 0) {
        $canvas = imagecreatetruecolor(self::WIDTH, self::HEIGHT);

        if ($favicon == NULL) {
            $favicon = imagecreatefrompng(__DIR__ . '/img/favicon.png');
        }

        //file the complete background
        $background = imagecreatefrompng(__DIR__ . '/img/texture.png');
        for ($yPos = 0; $yPos <= (self::HEIGHT / self::TEXTURE_SIZE); $yPos++) {
            for ($xPos = 0; $xPos <= (self::WIDTH / self::TEXTURE_SIZE); $xPos++) {
                $startX = $xPos * self::TEXTURE_SIZE;
                $startY = $yPos * self::TEXTURE_SIZE;
                imagecopyresampled($canvas, $background, $startX, $startY, 0, 0
                        , self::TEXTURE_SIZE, self::TEXTURE_SIZE
                        , self::TEXTURE_SIZE, self::TEXTURE_SIZE);
            }
        }

        //center the iamge in y-direction and add padding to the left side
        $favicon_posY = (self::HEIGHT - self::FAVICON_SIZE) / 2;
        imagecopy($canvas, $favicon, self::PADDING, $favicon_posY, 0, 0
                , self::FAVICON_SIZE, self::FAVICON_SIZE);

        $startX = self::PADDING + self::FAVICON_SIZE + self::PADDING;

        $white = imagecolorallocate($canvas, 255, 255, 255);
        $titleY = $favicon_posY + self::PADDING * 2 + self::TITLE_SIZE;
        imagettftext($canvas, self::TITLE_SIZE, 0, $startX, $titleY, $white, self::FONT_FILE, $address);

        $components = explode(self::COLOR_CHAR, $motd);
        $nextX = $startX;
        $nextY = 50;
        $last_color = [255, 255, 255];
        foreach ($components as $component) {
            if (empty($component)) {
                continue;
            }

            $color_code = $component[0];
            $colors = self::COLORS;

            //default to white
            $text = $component;
            if (!empty($color_code)) {
                //try to find the color rgb to the colro code
                if (isset($colors[$color_code])) {
                    $color_rgb = $colors[$color_code];
                    $last_color = $color_rgb;
                }

                $text = substr($component, 1);
            }

            $color = imagecolorallocate($canvas, $last_color[0], $last_color[1], $last_color[2]);
            if (strpos($component, "\n") !== False) {
                $lines = explode("\n", $text);

                imagettftext($canvas, self::MOTD_TEXT_SIZE, 0, $nextX, $nextY, $color, self::FONT_FILE, $lines[0]);

                $box = imagettfbbox(self::MOTD_TEXT_SIZE, 0, self::FONT_FILE, $text);
                $text_width = abs($box[4] - $box[0]);
                $nextX = $startX;
                $nextY += self::PADDING * 2 + self::MOTD_TEXT_SIZE;

                imagettftext($canvas, self::MOTD_TEXT_SIZE, 0, $nextX, $nextY, $color, self::FONT_FILE, $lines[1]);
            } else {
                imagettftext($canvas, self::MOTD_TEXT_SIZE, 0, $nextX, $nextY, $color, self::FONT_FILE, $text);

                $box = imagettfbbox(self::MOTD_TEXT_SIZE, 0, self::FONT_FILE, $text);
                $text_width = abs($box[4] - $box[0]);
                $nextX += $text_width + self::PADDING;
            }
        }

        if ($ping < 0) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/-1.png');
        } else if ($ping > 0 && $ping <= self::PING_WELL) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/5.png');
        } else if ($ping <= self::PING_GOOD) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/4.png');
        } else if ($ping <= self::PING_WORSE) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/3.png');
        } else if ($ping <= self::PING_WORST) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/2.png');
        } else if ($ping >= self::PING_WORST) {
            $image = imagecreatefrompng(__DIR__ . '/img/ping/1.png');
        }

        $ping_posX = self::WIDTH - self::PING_WIDTH - self::PADDING;
        imagecopy($canvas, $image, $ping_posX, $favicon_posY, 0, 0, self::PING_WIDTH, self::PING_HEIGHT);


        $text = $players . ' / ' . $max_players;
        $box = imagettfbbox(self::PLAYERS_TEXT_SIZE, 0, self::FONT_FILE, $text);
        $text_width = abs($box[4] - $box[0]);

        //center it based on the ping image
        $posY = $favicon_posY + (self::PING_HEIGHT / 2) + self::PLAYERS_TEXT_SIZE / 2;
        $posX = $ping_posX - $text_width - self::PADDING / 2;

        imagettftext($canvas, self::PLAYERS_TEXT_SIZE, 0, $posX, $posY, $white, self::FONT_FILE, $text);
        return $canvas;
    }

    /**
     *
     * @param string $playername Minecraft player name
     * @param resource $avatar the rendered avatar (for example player head)
     *
     * @return resource the generated banner
     */
    public static function player($playername, $avatar = NULL) {
        $canvas = imagecreatetruecolor(self::PLAYER_WIDTH, self::PLAYER_HEIGHT);

        //file the complete background
        $background = imagecreatefrompng(__DIR__ . '/img/texture.png');
        for ($yPos = 0; $yPos <= (self::PLAYER_HEIGHT / self::TEXTURE_SIZE); $yPos++) {
            for ($xPos = 0; $xPos <= (self::PLAYER_WIDTH / self::TEXTURE_SIZE); $xPos++) {
                $startX = $xPos * self::TEXTURE_SIZE;
                $startY = $yPos * self::TEXTURE_SIZE;
                imagecopyresampled($canvas, $background, $startX, $startY, 0, 0
                        , self::TEXTURE_SIZE, self::TEXTURE_SIZE
                        , self::TEXTURE_SIZE, self::TEXTURE_SIZE);
            }
        }

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

        $box = imagettfbbox(self::PLAYERS_TEXT_SIZE, 0, self::FONT_FILE, $playername);
        $text_width = abs($box[4] - $box[0]);

        $text_color = imagecolorallocate($canvas, 255, 255, 255);
        $remaining = self::PLAYER_WIDTH - self::AVATAR_SIZE - $avater_x - self::PLAYER_PADDING;

        $text_posX = $avater_x + self::AVATAR_SIZE + $remaining / 2 - $text_width / 2;
        $text_posY = $avater_y + self::AVATAR_SIZE / 2 + self::PLAYERS_TEXT_SIZE / 2;
        imagettftext($canvas, self::PLAYERS_TEXT_SIZE, 0
                , $text_posX, $text_posY, $text_color, self::FONT_FILE, $playername);

        return $canvas;
    }
}
