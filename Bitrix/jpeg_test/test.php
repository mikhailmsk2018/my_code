<?php
$font_path = "gilsanub.ttf"; // Font file
$font_size = 30; // in pixcels
$water_mark_text_2 = "Test_1"; // Watermark Text

function watermark_text($oldimage_name, $new_image_name){
global $font_path, $font_size, $water_mark_text_2;
list($owidth,$oheight) = getimagesize($oldimage_name);
$width = $height = 300;
$image = imagecreatetruecolor($width, $height);
$image_src = imagecreatefromjpeg($oldimage_name);
imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
$blue = imagecolorallocate($image, 79, 166, 185);
imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
imagejpeg($image, $new_image_name, 100);
imagedestroy($image);
unlink($oldimage_name);
return true;
}
echo watermark_text('q','w');
?>