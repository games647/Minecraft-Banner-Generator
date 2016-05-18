<?php

require __DIR__ . '/../src/MinecraftBanner.php';

use \MinecraftBanner\MinecraftBanner;

//tell the browser that we will send the raw image without HTML
header('Content-type: image/png');

$banner = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt");
imagepng($banner);
