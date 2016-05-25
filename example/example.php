<?php

//some dependencies here are optional. you may want to run composer install --dev
require __DIR__ . '/../src/MinecraftBanner.php';

use MinecraftBanner\MinecraftBanner;
use MinecraftServerStatus\MinecraftServerStatus;

const SKIN_URL = 'http://s3.amazonaws.com/MinecraftSkins/';

//tell the browser that we will send the raw image without HTML
header('Content-type: image/png');

//====PLAYER BANNER =====
//$head = imagecreatefrompng("notch_head.png");
//$banner = MinecraftBanner::player("Notch", $head);

//====SERVER BANNER =====
//$favicon = imagecreatefrompng("server_favicon.png");
//$banner = MinecraftBanner::server("example.minecraft.com", "§cHello World", 100000, 10000, $favicon, -1);

//====PLAYER BANNER (WITH DOWNLOADING)=====
//$playername = "Notch";
//$rawSkin = getRawSkin($playername);
//require_once __DIR__ . '/../vendor/games647/minecraft-skin-renderer/src/MinecraftSkins.php';
//$head = MinecraftSkins\MinecraftSkins::head($rawSkin);
//$banner = MinecraftBanner::player($playername, $head);

//====PLAYER BANNER combined (WITH DOWNLOADING)=====
//$playername = "Notch";
//$rawSkin = getRawSkin($playername);
//require_once __DIR__ . '/../vendor/games647/minecraft-skin-renderer/src/MinecraftSkins.php';
//$skin = MinecraftSkins\MinecraftSkins::combined($rawSkin, 1);
//$banner = MinecraftBanner::player($playername, $skin);

//====PLAYER BANNER SKIN AS AVATAR (WITH DOWNLOADING)=====
$playername = "Notch";
$rawSkin = getRawSkin($playername);
require_once __DIR__ . '/../vendor/games647/minecraft-skin-renderer/src/MinecraftSkins.php';
$skin = MinecraftSkins\MinecraftSkins::combined($rawSkin, 1);
$banner = MinecraftBanner::player($playername, $skin);

//====SERVER BANNER (WITH DOWNLOADING)=====
//Some random server
//$address = "minecraft70.omgserv.com";
//$banner = serverBanner($address);

//Display the image
imagepng($banner);

function getRawSkin($username) {
    //downloads the skin from mojang servers
    $url = SKIN_URL . $username . '.png';
    return imagecreatefrompng($url);
}

function serverBanner($address, $port = 25565) {
    require '../vendor/autoload.php';

    //usage of optional dependency: https://github.com/FunnyItsElmo/PHP-Minecraft-Server-Status-Query
    $response = MinecraftServerStatus::query($address, $port);
    if (!$response) {
        return MinecraftBanner::server($address);
    } else {
        $ping = $response['ping'];
        $players = $response['players'];
        $max_players = $response['max_players'];
        $motd = $response['description'];

        $favicon = extractImage($response['favicon']);

        return MinecraftBanner::server($address, $motd, $players, $max_players, $favicon, $ping);
    }
}

function extractImage($encoded) {
    $data = $encoded;
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);

    return imagecreatefromstring($data);
}
