<?php

require __DIR__ . '/../src/MinecraftBanner.php';

use \MinecraftBanner\MinecraftBanner;

//tell the browser that we will send the raw image without HTML
header('Content-type: image/png');

$favicon = imagecreatefrompng("notch_head.png");
$image = MinecraftBanner::player("Notch", $favicon);

//$favicon = imagecreatefrompng("server_favicon.png");
//$image = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon);
imagepng($image);
