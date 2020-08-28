<?

// Конфигурационные настройки
$ssilkaNaFile='/home/bitrix/www/pdf/jpeg_test/test_2/watermark/foto2.jpg';
$image = imagecreatefromjpeg($ssilkaNaFile);
$text = 'ТЕСТ ТЕСТ';
$ss='/home/bitrix/www/pdf/jpeg_test/test_2/watermark/arial.ttf';
$size = 18;
$otstupSnizy=(imagesx($image)/100)*20;
$otstup_sprava=imagesy($image)/100*7;

$black = ImageColorAllocate($image, 0, 0, 0); // черный
$white = ImageColorAllocate($image, 255, 255, 255); // белый
$blue =  Imagecolorallocate($image, 0, 96, 255);//синий
//print_r(imagesx($image2)) //ширина
list($shirina,$visota)=getimagesize($ssilkaNaFile);
 
// Печатаем центрированный текст
ImageTTFText($image, $size, 0, $shirina-$otstupSnizy, $visota-$otstup_sprava, $blue, $ss, $text);
$res='/home/bitrix/www/pdf/jpeg_test/test_2/watermark/res/bp_0502_2020.png';
// Посылаем изображение
//header('Content-type: image/png');
ImagePNG($image, $res);
// Удаляем
//ImagePSFreeFont($font);
//ImageDestroy($image);