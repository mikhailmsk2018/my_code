<?
	 /*Функция добавления водяного знака на исходное изображение*/
	function AddWaterMark($source_image_path, $result_image_path)
	{
		// Получаем ширину, высоту и тип исходного изображения
		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
		// Если по каким, то причинам неопределн тип, нам не стоит выполнять какие-либо действия с водяным знаком, по скольку это не картинка вовсе
		 if ($source_image_type === NULL) {
			return false;
		 }
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
	function ImageUpload($temp_path, $temp_name)
	{
		 // Получаем параметры изображения
		 list($temp_width, $temp_height, $temp_type) = getimagesize($temp_path);	 
		 // Если тип определить не получилось, то возвращаем FALSE
		 if ($temp_type === NULL) {
			return false;
		 }
		 // Если тип загружаемого файла не GIF, JPEG, PNG
		 switch ($temp_type) {
			 case 1:
				break;
			 case 2:
				break;
			 case 3:
				break;
			 default:
				return false;
		 }
		 // Конечные пути для сохранения
		 $upload_image_path = UPLOADED_IMAGE_DESTINATION . $temp_name;
		 $watermark_image_path = WATERMARK_IMAGE_DESTINATION . preg_replace('/\\.[^\\.]+$/', '.jpg', $temp_name);
		 // Загружаем исходное изображение 
		 move_uploaded_file($temp_path, $_SERVER['DOCUMENT_ROOT'].$upload_image_path);
		 // Создаем копию изображения и добавляем водяной знак
		 $result = AddWaterMark($_SERVER['DOCUMENT_ROOT'].$upload_image_path, $_SERVER['DOCUMENT_ROOT'].$watermark_image_path);
		 // В случае, если все прошло упешно, возвращаем путь к файлу с ЦВЗ
		 if ($result === false) {
			return false;
		 } else {
			return array($upload_image_path, $watermark_image_path);
		 }
	}
?>