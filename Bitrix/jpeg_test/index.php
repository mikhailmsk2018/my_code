<?php
    if (! extension_loaded('gd')) { // Проверяем установку библиотеки GD
        echo 'GD не установлено. Обратитесь к администратору вашего сайта!';
        exit;
    }

    $sOrigImg = "pic1.jpg";
    $sWmImg = "watermark.png";
	
	// Установка переменной окружения для GD
putenv('GDFONTPATH=' . realpath('.'));



    // Тип содержимого
header('Content-Type: image/png');

// Создание изображения
$im = imagecreatetruecolor(400, 30);

// Создание цветов
$white = imagecolorallocate($sOrigImg, 255, 255, 255);
$grey = imagecolorallocate($sOrigImg, 128, 128, 128);
$black = imagecolorallocate($sOrigImg, 0, 0, 0);
imagefilledrectangle($sOrigImg, 0, 0, 399, 29, $white);

// Текст надписи
$text = 'Тест...';
// Замена пути к шрифту на пользовательский
//$font = 'arial.ttf';
$font = 'SomeFont';

// Тень
 

// Текст
imagettftext($sOrigImg, 20, 0, 10, 20, $black, $font, $text);

imagepng($sOrigImg);
imagedestroy(sOrigImg);
?>