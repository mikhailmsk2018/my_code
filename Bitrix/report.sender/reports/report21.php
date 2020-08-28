<?
$report_data=array();
$tempdata=array();


$PropToValue = GetListProp();
//$TypeToName = GetBlockElements('60','NAME');

/*if($arResult['REPORT']['FIELD_ID']) $dop_field=" AND uts.".$arResult['REPORT']['FIELD_ID']."='".$arResult['REPORT']['FIELD_VALUE']."'";
else*/ $dop_field='';

if(isset($_GET['DATE_CREATE_FROM'])) $arResult['REPORT']['PERIOD']['from']=$_GET['DATE_CREATE_FROM'].' 00:00:00';
if(isset($_GET['DATE_CREATE_TO'])) $arResult['REPORT']['PERIOD']['to']=$_GET['DATE_CREATE_TO'].' 23:59:59';

$strSql = "
SELECT 
		d.ID, d.DATE_CREATE, d.CATEGORY_ID,
		uts.UF_CRM_1494399115 as RAION,
d.STAGE_ID,
uts.UF_CRM_1501668833
	FROM 
		b_crm_deal as d, 
		b_uts_crm_deal as uts
	WHERE 
		d.ID=uts.VALUE_ID
		AND d.DATE_CREATE >='".$arResult['REPORT']['PERIOD']['from']."'
		AND d.DATE_CREATE <='".$arResult['REPORT']['PERIOD']['to']."'
		AND d.CATEGORY_ID IN (7,8)
AND d.STAGE_SEMANTIC_ID IN ('P', 'S')
	";
			
$res = $DB->Query($strSql, false, $err_mess.__LINE__);
$k=0;

/* Array ( 
[ID] => 380413 
[DATE_CREATE] => 2019-08-01 07:05:25 
[CATEGORY_ID] => 8 
[RAION] => 220 
[STAGE_ID] => C8:WON 
[UF_CRM_1501668833] => a:1:{i:0;i:289;} 
) */

if($arResult['REPORT']['PERIOD_DAY']<90){
	$month=substr($arResult['REPORT']['PERIOD']['from'],5,2);
}else{
	$month=array();
}

// $report_data['data'][raion][type]['all'/'lose']++
while($wtemp=$res->Fetch()){	
	if($wtemp['UF_CRM_1501668833']){
		$types=unserialize($wtemp['UF_CRM_1501668833']);		//пример: Array ( [0] => 289 ) 
				foreach($types as $a => $b){		
					$tip_uslugi = $PropToValue[$b];	 
										//уловие для статусов-стадий
								if($wtemp['STAGE_ID'] == 'C8:WON' ||  $wtemp['STAGE_ID'] == 'C8:FINAL_INVOICE'){
									$report_data['data'][$PropToValue[$wtemp['RAION']]][$tip_uslugi]['all']++;
									$report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['all']++;		
								}                                                                                   
								else{
									$report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['lose']++;	 // в этот массив сохраняем все остальные заявки т.е. кроме двух статусов
									$report_data['data'][$PropToValue[$wtemp['RAION']]]['vsego']['all']++;	
									$report_data['data'][$PropToValue[$wtemp['RAION']]][$tip_uslugi]['lose']++;											
								}	
										//тип услуги, название
								if( !in_array($PropToValue[$b], $report_data['usluga'])) {											
									$report_data['yslugi'][$b]=$PropToValue[$b];	
								}
					$report_data['usluga']['tip']=$PropToValue[$b]; //все типы услуг с дублями					
				}//закрываем foreach
	}// if закрываем
		
	// считаем процент: =(int1*100%)/int2
	$procent = number_format(($report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['lose'] * 100) / $report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['all']);
	if($procent != 'inf' || $procent != 0){  
		$report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['procent'] = $procent . '%';
	}else{
		$report_data['total']['key'][$PropToValue[$wtemp['RAION']]]['procent'] = " ";
	}
	
}//завершение цикла
sort($report_data['yslugi']);
//echo '<pre>'; 
//print_r($report_data['total']);
$arResult['EXCELTYPE']='file';
?>