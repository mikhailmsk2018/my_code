
  <?php
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
 /*
//Устанавливаем тип содержимого
header("Content-Type: image/png");
 
//Определяем размеры изображения 125px width, 125px height
$image = imagecreate(525, 525);
 
//Выбираем цвет фона
$blue = imagecolorallocate($image, 0, 0, 255);
 
//Устанавливаем еще один цвет – просто чтобы убедиться, что при отображении рисунка фоновым будет именно цвет, установленный первым ()
//Квадрат будет синего, а не красного цвета.
$red = imagecolorallocate($image, 255, 0, 0);
 
//Сохраняем файл в формате png и выводим его
imagepng($image);
 
//Чистим использованную память
imagedestroy($image);
 
*/

?>
<?php


$im =  imagecreatefromjpeg('/home/bitrix/www/pdf/jpeg_test/test_2/watermark/test_1.jpg');//исходный файл
$red = imagecolorallocate($im, 0xFF, 0x00, 0x00);
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
$bg = imagecolorallocate($im, 255, 255, 255);
$textcolor = imagecolorallocate($im, 0, 96, 255);//цвет текста

$im_x = imagesx($im);//горизонталь
$otstup_sprava=($im_x/100)*15;//отступ справа
$im_y = imagesy($im);//Вертикаль
$otstup_snizy=($im_y/100)*10;//отступ снизу

$font = imageloadfont('/home/bitrix/www/pdf/jpeg_test/test_2/watermark/arial.ttf');
$font2 = imageloadfont('/home/bitrix/www/pdf/jpeg_test/test_2/watermark/SomeFont.ttf');
 
$text = iconv('windows-1251', 'UTF-8', "Пора переходить на юникод.");
//imagefttext($im, 13, 0, 105, 55, $black, $font_file, 'PHP Manual');
imagestring($im, 5, $im_x-$otstup_sprava, $im_y-$otstup_snizy, $text, $textcolor);
//imagettftext($im, 20, 0, 0, 0, $textcolor, $font2, 'TESTTEST');


$s="/home/bitrix/www/pdf/jpeg_test/test_2/watermark/res/opasno8.jpeg";

header('Content-Type: image/jpg');
imagejpeg($im, $s);
imagedestroy($im);

//imagepng(imagecreatefromstring(file_get_contents('original.jpg')),"output111.png");



/*
// Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)
$original =  imagecreatefromjpeg('/home/bitrix/www/pdf/jpeg_test/test_2/watermark/pic1.jpg');
$stamp = 	 imagecreatefromgif('/home/bitrix/www/pdf/jpeg_test/test_2/watermark/php.gif');

// Установка полей для штампа и получение высоты/ширины штампа
$otstup_gorizontal = 10;
$otstup_vertikal   = 10;
//размеры штампа(ширина и высота)
$x_shirina = imagesx($stamp);
$y_visota  = imagesy($stamp);


$black = imagecolorallocate($original, 0x00, 0x00, 0x00);
$font_file = '/arial.ttf';



// и ширины фотографии для расчета позиционирования штампа. 
//imagecopy($original, $stamp, imagesx($original) - $x_shirina - $otstup_gorizontal, imagesy($original) - $y_visota - $otstup_vertikal, 0, 0, imagesx($stamp), imagesy($stamp));
$s="/home/bitrix/www/pdf/jpeg_test/test_2/watermark/res/opasno.jpeg";
imagefttext($original, 18, 0, 10, 10, $black, $font_file, 'PHP Manual');
// Вывод и освобождение памяти
header('Content-type: image/png');
imagejpeg($original,$s);
imagedestroy($original);
*/
?>
