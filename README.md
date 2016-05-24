# Minecraft Banner Generator

## Description

Minecraft banner generator library.

## Features

* Server banner
Displays:
    * Ping (shows different about how good the ping is)
    * Online players
    * Max players
    * Favicon if available
    * Colorized motd (message of the day)
* Player banners
Displays:
    * Player Head image
    * Displays player name
* No branding
* No Magic values
* Free

## ToDo

* Custom background
* Text style effects (bold, italic, underlined)
* Automatic line wrapping
* Graph of player activity

## Installation

With composer it's just:

    composer require games647/minecraft-banner-generator

For non-composer projects, you can drop the files from the /src folder into a libraries folder and use it with a
require statement at the top of the PHP-File. You can see a example in the example.php file.

## Usage

```PHP
//this is only used if you don't use composer
require __DIR__ . '/PATH_TO_LIB_FOLDER/MinecraftBanner.php';

use \MinecraftBanner\MinecraftBanner;

[...]

//tell the browser that we will send the raw image without HTML
header('Content-type: image/png');

$banner = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt");
imagepng($banner);
```

## Examples

```PHP
$favicon = imagecreatefrompng("server_favicon.png");
$image = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon);
```
![Minecraft banner](http://i.imgur.com/LtdXV6t.png)

```PHP
$favicon = imagecreatefrompng("server_favicon.png");
$image = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon);
```
![Minecraft banner](http://i.imgur.com/E5QpZ8K.png)