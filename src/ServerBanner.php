<?php
namespace MinecraftBanner;

require_once __DIR__ . "/MinecraftBanner.php";

class ServerBanner
{

    const WIDTH = 650;
    const HEIGHT = 80;
    const PADDING = 3;

    const FAVICON_SIZE = 64;

    const TITLE_SIZE = 13;
    const MOTD_SIZE = 12;
    const PLAYERS_SIZE = 14;
    const PING_WIDTH = 36;
    const PING_HEIGHT = 29;

    const PING_WELL = 150;
    const PING_GOOD = 300;
    const PING_WORSE = 400;
    const PING_WORST = 500;

    /**
     *
     * @param string $address the server address
     * @param string $motd message of the day which should be displayed
     * @param int $players not implemented
     * @param int $max_players not implemented
     * @param resource $favicon not implemented
     * @param string $background Image Path or Standard Value
     * @param int $ping not implemented
     * @return resource the rendered banner
     */
    public static function server($address, $motd = "§cOffline Server", $players = -1, $max_players = -1,
            $favicon = NULL, $background = NULL, $ping = 0)
    {
        $canvas = MinecraftBanner::getBackgroundCanvas(self::WIDTH, self::HEIGHT, $background);
        if ($favicon == NULL) {
            $favicon = imagecreatefrompng(__DIR__ . '/img/favicon.png');
        }

        //center the iamge in y-direction and add padding to the left side
        $favicon_posY = (self::HEIGHT - self::FAVICON_SIZE) / 2;
        imagecopy($canvas, $favicon, self::PADDING, $favicon_posY, 0, 0, self::FAVICON_SIZE, self::FAVICON_SIZE);

        $startX = self::PADDING + self::FAVICON_SIZE + self::PADDING;

        $white = imagecolorallocate($canvas, 255, 255, 255);
        $titleY = $favicon_posY + self::PADDING * 2 + self::TITLE_SIZE;
        imagettftext($canvas, self::TITLE_SIZE, 0, $startX, $titleY, $white, MinecraftBanner::FONT_FILE, $address);

        $components = explode(MinecraftBanner::COLOR_CHAR, $motd);
        $nextX = $startX;
        $nextY = 50;
        $last_color = [255, 255, 255];
        foreach ($components as $component) {
            if (empty($component)) {
                continue;
            }

            $color_code = $component[0];
            $colors = MinecraftBanner::COLORS;

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
            $lines = explode("\n", $text);

            imagettftext($canvas, self::MOTD_SIZE, 0, $nextX, $nextY, $color, MinecraftBanner::FONT_FILE, $lines[0]);
            $box = imagettfbbox(self::MOTD_SIZE, 0, MinecraftBanner::FONT_FILE, $text);
            $text_width = abs($box[4] - $box[0]);
            if (count($lines) > 1) {
                $nextX = $startX;
                $nextY += self::PADDING * 2 + self::MOTD_SIZE;

                imagettftext($canvas, self::MOTD_SIZE, 0, $nextX, $nextY, $color, MinecraftBanner::FONT_FILE, $lines[1]);
            } else {
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
        $box = imagettfbbox(self::PLAYERS_SIZE, 0, MinecraftBanner::FONT_FILE, $text);
        $text_width = abs($box[4] - $box[0]);

        //center it based on the ping image
        $posY = $favicon_posY + (self::PING_HEIGHT / 2) + self::PLAYERS_SIZE / 2;
        $posX = $ping_posX - $text_width - self::PADDING / 2;

        imagettftext($canvas, self::PLAYERS_SIZE, 0, $posX, $posY, $white, MinecraftBanner::FONT_FILE, $text);
        return $canvas;
    }
}
