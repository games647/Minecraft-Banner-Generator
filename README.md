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
* No branding
* No Magic values
* Free

## ToDo

* Player banner
* Custom background
* Option show or hide the server address
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
$banner = MinecraftBanner::server("example.minecraft.com", "§aHallo §cWelt");
```
![Minecraft banner](http://i.imgur.com/dN6Wsyx.png)