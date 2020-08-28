<?
	include ("config.php");
	include ("functions.php");
	
	
	$result = ImageUpload($_FILES['userfile']['tmp_name'], $_FILES['userfile']['name']);
	if ($result === false){
		echo 'Загрузка не удалась!';
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Наложение водяного знака на изображения</title>
	</head>
	<body>
		<div id="source_image">
			<div class="title_image">Исходное изображение</div>
			<img src="<?=$result[0]?>" style="max-width: 300px;" />
		</div>
		<div id="watermark_image">
			<div class="title_image">Изображение с водяным знаком</div>
			<img src="<?=$result[1]?>"  style="max-width: 300px;" />
		</div>
	</body>
</html>