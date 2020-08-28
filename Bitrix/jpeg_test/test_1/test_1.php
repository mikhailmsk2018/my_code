<?php
//list($temp_width, $temp_height, $temp_type) = getimagesize($_FILES['userfile']['tmp_name']);
//echo "<pre>";
//var_dump(getimagesize($_FILES['userfile']['tmp_name']));
echo "<pre>";
//print_r($_SERVER['DOCUMENT_ROOT']);

define('WATERMARK_OVERLAY_IMAGE', '/pdf/jpeg_test/watermark.png'); // Путь до Вашего ЦВЗ
define('WATERMARK_OUTPUT_QUALITY', 100); // Качество получаемого изображения с ЦВЗ. Помните, что качество напрямую влияет на размер файла.
define('UPLOADED_IMAGE_DESTINATION', '/pdf/jpeg_test/test_1/folder1/'); // Путь к расположению исходных загружаемых изображений
define('WATERMARK_IMAGE_DESTINATION', '/pdf/jpeg_test/test_1/folder2/'); // Путь к изображениям с наложенным ЦВЗ


//echo $_SERVER['DOCUMENT_ROOT'].UPLOADED_IMAGE_DESTINATION;
/*Функция добавления водяного знака на исходное изображение*/
function AddWaterMark($source_image_path, $result_image_path)
{
// Получаем ширину, высоту и тип исходного изображения
list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
// Если по каким, то причинам неопределн тип, нам не стоит выполнять какие-либо действия с водяным знаком, по скольку это не картинка вовсе
//if ($source_image_type === NULL) {
//return false;
//}
// Создаем, так называемый ресурс изображения из исходной картинки в зависимости от типа исходной картинки
switch ($source_image_type) {
case 1: // картинка *.gif
$source_image = imagecreatefromgif($source_image_path);
break;
case 2: // картинка *.jpeg, *.jpg
$source_image = imagecreatefromjpeg($source_image_path);
break;
case 3: // картинка *.png
$source_image = imagecreatefrompng($source_image_path);
break;
default:
return false; // Если картинка другого формата, или не картинка совсем, то опять же не стоит делать, что либо дальше с водяным знаком
}
// Создаем ресурс изображения для нашего водяного знака
$watermark_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].WATERMARK_OVERLAY_IMAGE);
//echo $watermark_image;
// Получаем значения ширины и высоты
$watermark_width = imagesx($watermark_image);
$watermark_height = imagesy($watermark_image);
// Наложение ЦВЗ с прозрачным фоном
imagealphablending($source_image, true);
imagesavealpha($source_image, true);
// Самая важная функция - функция копирования и наложения нашего водяного знака на исходное изображение
imagecopy($source_image, $watermark_image, $source_image_width - $watermark_width, $source_image_height - $watermark_height, 0, 0, $watermark_width, $watermark_height);
 
// Создание и сохранение результирующего изображения с водяным знаком
imagejpeg($source_image, $result_image_path, WATERMARK_OUTPUT_QUALITY);

// Уничтожение всех временных ресурсов
imagedestroy($source_image);
imagedestroy($watermark_image);
}
 
/*Функция загрузки изображения*/
function ImageUpload($file_my, $imya_faila){
	// Получаем параметры изображения
	list($temp_width, $temp_height, $temp_type) = getimagesize($file_my);
	// Конечные пути для сохранения
	$upload_image_path = UPLOADED_IMAGE_DESTINATION . $imya_faila;  //  /pdf/jpeg_test/test_1/folder1/thumb.png
	$watermark_image_path = WATERMARK_IMAGE_DESTINATION . preg_replace('/\\.[^\\.]+$/', '.jpg', $imya_faila);  // /pdf/jpeg_test/test_1/folder2/thumb.jpg
	
	// Загружаем исходное изображение
	//move_uploaded_file($file_my, $_SERVER['DOCUMENT_ROOT'].$upload_image_path);
	
	// Создаем копию изображения и добавляем водяной знак
	$result = AddWaterMark($_SERVER['DOCUMENT_ROOT'].$upload_image_path, $_SERVER['DOCUMENT_ROOT'].$watermark_image_path); //ссылкi
	// В случае, если все прошло упешно, возвращаем путь к файлу с ЦВЗ
	/*if ($result === false) {
	return false;
	} else {
	return array($upload_image_path, $watermark_image_path);
	}*/
}//ImageUpload

//echo ImageUpload($_FILES['userfile']['tmp_name'], $_FILES['userfile']['name']); 
//echo $_FILES['userfile']['tmp_name'];echo '<hr>';///tmp/php_upload/ext_www/bitrix.uniservis.org/phpyJCXMC
//echo $_FILES['userfile']['name'];//thumb.png
//$s= "/pdf/jpeg_test/test_1/simple2.jpg";
//echo $s;


//if (!copy("/pdf/jpeg_test/test_1/simple2.jpg", $s)) {
    //echo " не удалось скопировать $file...\n";
//}

 //move_uploaded_file("/home/bitrix/www/pdf/jpeg_test/pic1.jpg", $s);
 
print_r($result);
$result = ImageUpload($_FILES['userfile']['tmp_name'], $_FILES['userfile']['name']);//ссылку и имя
if ($result === false){
echo 'Загрузка не удалась!';
}else{
	print_r($result);
}


// Создание изображений
$src = imagecreatefromgif('php.gif');
$dest = imagecreatetruecolor(110, 110);


// Копирование
imagecopy($dest, $src, 0, 0, 20, 13, 80, 40);

// Вывод и освобождение памяти
header('Content-Type: image/gif');
imagegif($dest);

imagedestroy($dest);
imagedestroy($src);
?>