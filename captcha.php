<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 28.07.2017
 * Time: 14:29
 */


$captchaCode = substr(md5(rand(0, 999999)), 0, 6);
$font = "../font/HoboStd.otf";
$_SESSION["captchaCode"] = $captchaCode;

$captchaImage = imagecreate(140, 65);
$white = ImageColorAllocate($captchaImage, rand(0, 255), rand(0, 255), rand(0, 255));
$blue = ImageColorAllocate($captchaImage, rand(0, 255), rand(0, 255), rand(0, 255));

imagefill($captchaImage, 4, 5, $blue);
imagettftext($captchaImage, 15, rand(-15, 15), 20, 40, $white, $font, $captchaCode);

header("Content-type: image/png");
imagepng($captchaImage);
imagedestroy($captchaImage);

?>