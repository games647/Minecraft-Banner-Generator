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
    * Custom background
* Player banners
Displays:
    * Player Head image
    * Displays player name
* No branding
* No Magic values
* Free

## ToDo
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
require __DIR__ . '/PATH_TO_LIB_FOLDER/ServerBanner.php';

use \MinecraftBanner\ServerBanner;
use \MinecraftBanner\MinecraftBanner;

[...]

//tell the browser that we will send the raw image without HTML
header('Content-type: image/png');

$banner = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt");
imagepng($banner);
```
### Backgrounds
You can use 11 build in Backgrounds or Images as files or URLs
```PHP
$favicon = imagecreatefrompng("server_favicon.png");
$image = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon, "MinecraftBanner::[DEFAULT_BACKGROUND, CLOUDS_BACKGROUND, LILLY_PADS_BACKGROUND, HILLS_BACKGROUND, WATERFALL_BACKGROUND, CANYON_BACKGROUND, GRASSLAND_BACKGROUND, GRASSLAND_CANYON_BACKGROUND, SWAMP_BACKGROUND, LAKE_BACKGROUND, SWAMP2_BACKGROUND, LILLY_PADS_SWAMP_BACKGROUND]");
```


#### CLOUDS_BACKGROUND
![CLOUDS_BACKGROUND](http://i.imgur.com/jMij4xr.png)
#### LILLY_PADS_BACKGROUND
![LILLY_PADS_BACKGROUND](http://i.imgur.com/6GqUw42.png)
#### HILLS_BACKGROUND
![HILLS_BACKGROUND](http://i.imgur.com/zRwAOyp.png)
#### WATERFALL_BACKGROUND
![WATERFALL_BACKGROUND](http://i.imgur.com/HFx6V3q.png)
#### CANYON_BACKGROUND
![CANYON_BACKGROUND](http://i.imgur.com/LHxdbma.png)
#### GRASSLAND_BACKGROUND
![GRASSLAND_BACKGROUND](http://i.imgur.com/oHktIme.png)
#### GRASSLAND_CANYON_BACKGROUND
![GRASSLAND_CANYON_BACKGROUND](http://i.imgur.com/1wmqIQN.png)
#### SWAMP_BACKGROUND
![SWAMP_BACKGROUND](http://i.imgur.com/xdDXDkZ.png)
#### LAKE_BACKGROUND
![LAKE_BACKGROUND](http://i.imgur.com/eEZzdVm.png)
#### SWAMP2_BACKGROUND
![SWAMP2_BACKGROUND](http://i.imgur.com/i90Qitm.png)
#### LILLY_PADS_SWAMP_BACKGROUND
![LILLY_PADS_SWAMP_BACKGROUND](http://i.imgur.com/Rad3CwW.png)

### Scaling
![Scaling](http://i.imgur.com/pxaM0t1.png)

## Examples

```PHP
$favicon = imagecreatefrompng("server_favicon.png");
$image = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon);
```
![Minecraft banner](http://i.imgur.com/LtdXV6t.png)

---

```PHP

$favicon = imagecreatefrompng("notch_head.png");
$image = PlayerBanner::player("Notch", $favicon);
```
![Minecraft banner](http://i.imgur.com/2yZGQck.png)

---

```PHP
$favicon = imagecreatefrompng("server_favicon.png");
$image = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon, MinecraftBanner::LILLY_PADS_BACKGROUND);
```

![Minecraft banner](http://i.imgur.com/Hk1Um86.png)

---

```PHP
$favicon = imagecreatefrompng("notch_head.png");
$image = PlayerBanner::player("Notch", $favicon, MinecraftBanner::LILLY_PADS_BACKGROUND);
```
![Minecraft banner](http://i.imgur.com/sU5tPc8.png)
