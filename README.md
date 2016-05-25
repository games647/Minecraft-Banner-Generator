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
$image = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon, "Standard-Background[0-10]");
```


#### Background 0
![Background 0](http://i.imgur.com/jMij4xr.png)
#### Background 1
![Background 1](http://i.imgur.com/6GqUw42.png)
#### Background 2
![Background 2](http://i.imgur.com/zRwAOyp.png)
#### Background 3
![Background 3](http://i.imgur.com/HFx6V3q.png)
#### Background 4
![Background 4](http://i.imgur.com/LHxdbma.png)
#### Background 5
![Background 5](http://i.imgur.com/oHktIme.png)
#### Background 6
![Background 6](http://i.imgur.com/1wmqIQN.png)
#### Background 7
![Background 7](http://i.imgur.com/xdDXDkZ.png)
#### Background 8
![Background 8](http://i.imgur.com/eEZzdVm.png)
#### Background 9
![Background 9](http://i.imgur.com/i90Qitm.png)
#### Background 10
![Background 10](http://i.imgur.com/Rad3CwW.png)

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
$image = ServerBanner::server("example.minecraft.com", "§aHallo §cWelt", -1, -1, $favicon, MinecraftBanner::CLOUDS_BACKGROUND);
```

![Minecraft banner](http://i.imgur.com/Hk1Um86.png)

---

```PHP
$favicon = imagecreatefrompng("notch_head.png");
$image = PlayerBanner::player("Notch", $favicon, MinecraftBanner::CLOUDS_BACKGROUND);
```
![Minecraft banner](http://i.imgur.com/sU5tPc8.png)
