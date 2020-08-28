<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$month=substr($arResult['REPORT']['PERIOD']['from'],5,2);
$year=substr($arResult['REPORT']['PERIOD']['from'],0,4);
$month_arr0 = array("01"=>"Январь","02"=>"Февраль","03"=>"Март","04"=>"Апрель","05"=>"Май", "06"=>"Июнь", "07"=>"Июль","08"=>"Август","09"=>"Сентябрь","10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");
$week=array('0'=>'Вс','1'=>'Пн','2'=>'Вт','3'=>'Ср','4'=>'Чт','5'=>'Пт','6'=>'Сб');
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$itogo=array();
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>">
	<style>
		.number0 {mso-number-format:0;}
		.number2 {mso-number-format:Fixed;}
		table {
			border-collapse: collapse;
			color:#000000;
		}
		table td {
			font-size:11pt;
			padding: 3px;
		}
		table.bordered {
			border: 1pt solid #000;
			color:#000000;
			margin-top:30px;
			width:100%;
		}
		table.bordered td {
			font-size:12pt;
			border: 1pt solid #000;
			border-collapse: collapse;
			padding: 8px 20px;
			
		}
		
		.strong {
			font-weight:bold;
		}
		.center {
			vertical-align:middle;
			text-align:center;
		}
		.strong_center {
			font-weight:bold;
			vertical-align:middle;
			text-align:center;
		}
		table.bordered td.fcol {
			border-top:0px;
			border-bottom:0px;
		}
		table.bordered thead td {
			border-top:0px;
			border-left:0px;
			border-right:0px;
		}
		.title {
			vertical-align:middle;
			text-align:center;
			font-size:10pt;
			font-weight:bold;
		}
		.raion {
			vertical-align:bottom;
			text-align:left;
			font-size:11pt;
			font-weight:bold;
		}


		.item {
			vertical-align:middle;
			text-align:center;
			font-size:11pt;
			border: .5pt solid #000 !important;
		}
		.item-total {
			vertical-align:middle;
			text-align:center;
			font-size:11pt;
			border: .5pt solid #000 !important;
			font-weight:bold;
		}
		.item-left {
			vertical-align:middle;
			text-align:left;
			font-size:11pt;
			border: .5pt solid #000 !important;
		}
		.kod {
			vertical-align:middle;
			text-align:right;
			font-size:11pt;
		}
		
		
	</style>
</head>
<body>

<?php  
//echo '<pre>';
//print_r($arResult['REPORT']['DATA']['total']); 
?>
<table class="bordered" border="0">
	<tbody>
		<tr>
			<td class="title" colspan="28">Типы технических заявок</td>
		</tr>
		
		<tr> <!-- 2-я строка  -->
			<td class="item" rowspan="2"><b>Объект</b></td>
			<? $s=1; foreach($arResult['REPORT']['DATA']['yslugi'] as $key => $value){ 
			echo '<td class=item colspan=2><b>'. $value .'</b></td>';
			$s++; } ?>
			<td class="item" colspan="3"><b>Общие показатели</b></td>
		</tr>
		
		<tr><!-- 3-я строка  -->
			<? for($i=1;$i<(count($arResult['REPORT']['DATA']['yslugi'])*2)+1;$i++){ 
				if($i%2){
					echo "<td class=item>Всего</td>";
				}else{
					echo "<td class=item>не выполнено</td>";
				}
			 } 
			 ?>
			<td class="item"><b>общее кол-во заявок</b></td>
			<td class="item"><b>Не выполненых заявок</b></td>
			<td class="item"><b>%</b></td>
		</tr><!-- 3-я строка конец  -->
					
		<!-- основные строки  -->
		<? $n=0; 	
		foreach($arResult['REPORT']['DATA']['data'] as  $raion => $data) {
		?>
			<tr>
				<td class="raion"><? echo $raion; ?></td>
				<? foreach($arResult['REPORT']['DATA']['yslugi'] as $usluga) { ?>
				<td class="item"> <? if($data[$usluga]['all'] == ""){echo '0';}else{echo $data[$usluga]['all'];} ?>  </td>
				<td class="item"> <? if($data[$usluga]['lose'] == ""){echo '0';}else{echo $data[$usluga]['lose'];} ?> </td>				
				<?}?>
				<!-- три последние строки  -->
				<td class="item"><? if($arResult['REPORT']['DATA']['total']['key'][$raion]['all'] == ""){echo '0';}else{echo $arResult['REPORT']['DATA']['total']['key'][$raion]['all'];} ?></td>
				<td class="item"><? if($arResult['REPORT']['DATA']['total']['key'][$raion]['lose'] == ""){echo '0';}else{echo $arResult['REPORT']['DATA']['total']['key'][$raion]['lose'];} ?></td>
				<td class="item"><?
if($arResult['REPORT']['DATA']['total']['key'][$raion]['all'] == "" && $arResult['REPORT']['DATA']['total']['key'][$raion]['lose'] != "")
{echo '100%';
}elseif($arResult['REPORT']['DATA']['total']['key'][$raion]['lose'] == "" && $arResult['REPORT']['DATA']['total']['key'][$raion]['all'] != "")
{echo '0%';}else{echo $arResult['REPORT']['DATA']['total']['key'][$raion]['procent'];}			
?></td> 		  
			</tr>
<? $n++; }?>		
	</tbody>
</table>
<table border="0">
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
</table>
<?
//echo '<pre>'.print_r($arResult,true).'</pre>';			
?>
</body>
</html>