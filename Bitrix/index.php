<?
CModule::IncludeModule("iblock");
$arFilter = array
(
'IBLOCK_ID'=>80,  
'ACTIVE' => 'Y',  
array("LOGIC" => "AND", 
	array('IBLOCK_ID'=>80), 
	array('PROPERTY_zhk'=>379778),
	array('!PROPERTY_tip_uslugi'=>false)
	)
);

$arSelect = CIBlockElement::GetList(array('ID'=>'ASC'), $arFilter, false,false,array('ID', 'NAME',"PROPERTY_zhk",'PROPERTY_tip_uslugi'));//iblock 80 - Привязка Типов услуг к ЖК //array('ID', 'NAME','PROPERTY_otvetstvennye', 'PROPERTY_tip_uslugi'));

        while( $str_usluga = $arSelect->GetNextElement() )
        {   
            $arProps = $str_usluga->GetProperties();
			$fieldmy= $str_usluga->GetFields();
			$a[]=$fieldmy;
}
echo '<pre>';
			print_r($a);
////////////////


/*беру здания в цикле разбираю, в цикле вытаскиваю айди элементов инфоблока жк, и обновляю по одному пользовательскому полю(без property)
задача: обновить-заполнить одно пользовательское поле данными из другого поля привязанного к элементам.*/
CModule::IncludeModule("iblock");
$IBLOCK_ID = 47;
$SEARCH_FIELD_NAME = 'SEARCH_ID';
$els = CIBlockElement::GetList(
    array("SORT"=>"ASC"),
    array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y"),
    false,
    false,
	array('ID','IBLOCK_ID','NAME', 'PROPERTY_raion', 'PROPERTY_jk')
);

//$jksql = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>71, 'ACTIVE'=>'Y'),false, false, array('ID','NAME',));

$i=0;
while ($s = $els->Fetch()) {
	$jksql = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>71, 'ACTIVE'=>'Y'),false, false, array('ID','NAME',));
	while($ar_jk = $jksql->GetNext() )
	{
		if($ar_jk['NAME']==$s['PROPERTY_RAION_VALUE']){
			$ok = CIBlockElement::SetPropertyValuesEx(
				$s['ID'],
				false,
				array('jk' => $ar_jk['ID'])
			);
		}
	}
	$ar[]=$s;
++$i;
}
/**/
//////////////////////////////
//вытащить номера телефонов или имейлов компаний:

SELECT DISTINCT pochta.VALUE, com.TITLE, com.ID, pochta.ENTITY_ID FROM `b_crm_dp_comm_mcd` as pochta 
RIGHT JOIN  `b_crm_company` as com ON pochta.ENTITY_ID = com.ID
WHERE pochta.ENTITY_TYPE_ID = '4' AND pochta.TYPE = 'EMAIL'
ORDER BY com.ID ASC LIMIT 350   


//запросом получаю все компании с заполненными Л/С
global $DB;
CModule::IncludeModule('bizproc');
CModule::IncludeModule('crm');

$sql = "SELECT crm.TITLE, uts.UF_CRM_1501237695, uts.VALUE_ID
FROM `b_uts_crm_company` as uts
LEFT JOIN `b_crm_company` as crm
ON uts.VALUE_ID = crm.ID 
WHERE uts.UF_CRM_1501237695 IS NOT NULL";  
$result_sql = $DB->Query($sql, false, $err_mess.__LINE__);
echo '<pre>';
while($str_result = $result_sql->fetch() )
{
	//$ar_vse_depart[$str_result['VALUE_ID']] = unserialize($str_result['UF_CRM_1501237695']);
	//$ar_vse_depart[] = unserialize($str_result['UF_CRM_1501237695']);
	if(count(unserialize($str_result['UF_CRM_1501237695']))>0){
		$ar_vse_depart[$str_result['VALUE_ID']] = unserialize($str_result['UF_CRM_1501237695']);
	}

}
//echo '<pre>' . print_r($ar_vse_depart, true).'</pre>';

//
$sql = "SELECT section_id, depart FROM b_staffs_access WHERE section_id='226'";  
$result_sql = $DB->Query($sql, false, $err_mess.__LINE__);
while($str_result = $result_sql->fetch() ){
	$ar_vse_depart[] = $str_result['depart'];
}
//echo '<pre>' . print_r($ar_vse_depart, true).'</pre>';

if(array_search('950',$ar_vse_depart)){
	echo 'ok';
}

print_r(array_search('950',$ar_vse_depart));
//

CModule::IncludeModule('iblock');  
$res=CIblockElement::GetList(array(), 
array('IBLOCK_ID'=>'8',  'SECTION_ID'=>15, 'PROPERTY_162_VALUE'=>'10 лет'),
false,
false,
 array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_162')  
);
if($count=$res->SelectedRowsCount()){
	echo $count, '<br>';
	}

while($ob = $res->GetNextElement())
	{
		 $arFields = $ob->GetFields();
        $arElements[] = $arFields;
	}

echo '<pre>';
print_r($arElements);
echo '</pre>'; 
////////////////	
function GetDealFilter1($arFilter,$cat_id=-1,$userID=0){
CModule::IncludeModule("iblock");
Global $USER; global $DB;
$userID = '1422'; //1392 1519
$result=array(); 
$stack_raion=array();
$arFilterOld=$arFilter;
if(!$userID) $userID=$USER->GetID();
$wtemp=CUser::GetByID($userID);
$arUser = $wtemp->Fetch();
$arGroups = CUser::GetUserGroup($userID);
$arFilterOld=$arFilter;
$result=array();
echo '<pre>';
$arId = $arUser['UF_DEPARTMENT'];
//функия возвращает имена и айди
$id = 71;
$jk = GetBlockElements($id,'NAME'); //получаем массив вида [379783] => значение
$arFilter8 = array( 'IBLOCK_ID'=>5,'ID'=>$arUser['UF_DEPARTMENT'] ); // 5й инфоблок - Подразделения, вытаскиваем привязку к жк в ввиде айди жк
$sql1=CIblockSection::GetList(array(), $arFilter8,false, array('ID','NAME', 'UF_PRIVYAZKA_K_JK'));
$jk_name=[];//имя ЖК  
$i=0; $arAr=[];  $arAr3=[];

while($sql=$sql1->Fetch())
{
	$arAr = $sql['UF_PRIVYAZKA_K_JK'];  // получаем массив имен жк юзера у которых есть привязка
	if(is_array($arAr3) && is_array($arAr)){  // собираем одномерный массив. Массив $arAr клеим к массиву $arAr3 в конец, при первой итерации ар3 пустой
	$arAr3 = array_merge($arAr3, $arAr);
	}

}
//print_r($arAr3);
foreach($arAr3 as $k => $v){
		$ar2[] = $jk[$v];
}
$unique = array_unique($ar2);//уникальные значения

$stringAr = (string)implode('\',\'',$unique);
$strSql = "SELECT ID FROM b_user_field_enum WHERE USER_FIELD_ID='253' AND VALUE IN ('". $stringAr ."')";  // получаем айди для сделок вида [ID] => 221
$res = $DB->Query($strSql, false, $err_mess.__LINE__);
while($enum = $res->fetch())
{
$stack_raion = array_merge($stack_raion, (array)$enum['ID']);
}
//print_r($stack_raion);
$result=$stack_raion;
$dopFilter=array("UF_CRM_1494399115" => $result);    
$arFilter=array_merge($arFilter,$dopFilter);


if(in_array(486,$arUser['UF_DEPARTMENT']) OR in_array(536,$arUser['UF_DEPARTMENT'])) {
	if($cat_id==0) { //cat_id==0 платные услуги
				$dopFilter=array_merge($dopFilter,array("!UF_CRM_1504851625" => false)); 
			}
			else{
				$dopFilter=array_merge($dopFilter,array("!CATEGORY_ID" => 0)); 
			}						
		}
		$arFilter=array_merge($arFilter,$dopFilter);

	if(count($stack_raion)>1 AND isset($arFilterOld['UF_CRM_1494399115']) AND count($arFilterOld['UF_CRM_1494399115'])) {
		$arFilter['UF_CRM_1494399115'] = array_intersect($arFilterOld['UF_CRM_1494399115'], $stack_raion);
	}
	elseif(count($stack_raion)>1) {
		$arFilter['UF_CRM_1494399115']=$stack_raion;
	}

//echo '<pre>';
	//print_r ($arFilter);
	return ($arFilter);
}

print_r (GetDealFilter1($arFilter, 8));

/*------*/
код для запуска бизнес процесса из консоли вручную:
$arErrorsTmp = array();
CBPDocument::StartWorkflow(
      183,
      array("crm","CCrmDocumentCompany", 'COMPANY_580'),
      array(),
      $arErrorsTmp
);
/*------*/

//////////////////
две переменные:  функция date_create(получаем дату ввиде объекта) и date_format(форматируем дату, но после получения через датакреате)
$dateEndLocal  = date_create('{=Document:UF_CRM_1576220083}'); //01-12-2019 00:00:00
$date_format     = date_format($dateEndLocal, 'Y-m-d H:i:s' ); //2019-12-01 00:00:00
echo '<pre>';
print_r($date_format);
ниже пример как получить две даты и посчитать между ними разницу
$d1=new DateTime($dateEndLocal);
$d2=new DateTime($date_format);
$d3=$d1->diff($d2);
foreach($d3 as $k=>$v){
$arAr2[$k]=$v;
}
/////////////////


/*для одной строки*/
$arFilter = array(
    'ID' => 15,       // выборка элемента с ИД равным «15»
    'IBLOCK_ID' => 5, // выборка элемента из инфоблока с ИД равным «5»
    'ACTIVE' => 'Y',  // выборка только активных элементов
);

// выборка элемента с полями 'ID','NAME','ACTIVE'
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','NAME','ACTIVE'));

// вывод элемента
while ($element = $res->GetNext()) {
    // $element['NAME'];
    // и другие свойства элемента
}
/**/

CModule::IncludeModule('iblock');              
$arFilter = Array(
							'IBLOCK_ID'=>30,
                            'CATALOG_ID'=>135,//Услуги
                            "SECTION_ID" => 581,
                            'INCLUDE_SUBSECTIONS'=>'Y',
                            'ACTIVE'=>'Y',
                            'SECTION_ACTIVE'=>'Y',
                            'PROPERTY_270'=>'СА049',

);
$arSelect=array('ID', 'IBLOCK_ID',  'NAME','PROPERTY_270');
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>20), $arSelect);

    while($ob = $res->GetNextElement())
	{
        $arFields = $ob->GetFields();
        $arElements[] = $arFields;	
	}

echo '<pre>';
print_r($arElements);
echo '</pre>'; 
//
CModule::IncludeModule('iblock');              
$arSelect = Array("ID", "NAME", 'IBLOCK_SECTION_ID');
$arFilter = Array("IBLOCK_ID"=>'50', "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", 'IBLOCK_SECTION_ID'=>'521');
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>2), false);
	
    while($ob = $res->GetNextElement())
	{
        $arFields = $ob->GetFields();
        $arElements[] = $arFields;	
	}

echo '<pre>';
print_r($arElements);
echo '</pre>'; 
//
CModule::IncludeModule('iblock');              
	$idIblock = '47';
	$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>IntVal($idIblock));

	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>2, "bShowAll"=>'Y', ),  $arSelect);
    $res->NavStart(20);
    echo $res->NavPrint("Столько элементов");
	while($ob = $res->GetNextElement())
	{
		 $arFields = $ob->GetFields();
		 $arElements[] = $arFields;	// элементы
	}
    
echo '<pre>',print_r($arElements),'</pre>';
echo $res->NavPrint("Столько элементов");
//
$idIblock = '71';
	$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>IntVal($idIblock));

	$res = CIBlockElement::GetList(Array(), $arFilter,  $arSelect);

	while($ob = $res->GetNextElement())
	{
		 $arFields = $ob->GetFields();
		 $arElements[] = $arFields;	// элементы
	}

echo '<pre>',print_r($arElements),'</pre>';
//счиатем колво строк-элементов = COUNT
из класса DBResult получает результат из бд по гетлисту и считаем строки
if($count=$res->SelectedRowsCount()>0){
	echo $count;
}
//
CModule::IncludeModule("iblock");
if(count($arResult['PROPERTIES']['HOUSES']['VALUE'])){
    $arSelect = Array("ID", "NAME", "PROPERTY_ADRESS");
	$arFilter = Array("IBLOCK_ID"=>10, "ID"=>$arResult['PROPERTIES']['HOUSES']['VALUE']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->fetch()) {
		$arResult['HOUSES'][] = $ob['PROPERTY_ADRESS_VALUE'].', '.$ob['NAME'];
	}
}

/*нумератор для бп*/
$numerator = \Bitrix\Main\Numerator\Numerator::load(3);
$numNext=$numerator->getNext();
$this->SetVariable('nomer',$numNext);

$org_id=$this->GetVariable('org');
$doc_date='{=Document:PROPERTY_DATA_DOKUMENTA}';

$month=substr($doc_date,3,2).substr($doc_date,6,4);

$org_short= '{=A22848_36667_54477_23923:PROPERTY_KRATKOE_OBOZNACHENIE}';

$num = numerator_next('',0,false,11,$org_id.'_'.$month);
$num.='-'.substr($doc_date,3,2).'/'.substr($doc_date,6,4).'-'.$org_short;
$this->SetVariable('num',$num);

/*коды сущностей:*/
['crm', 'CCrmDocumentLead', 'LEAD_777']
['crm', 'CCrmDocumentCompany', 'COMPANY_777']
['crm', 'CCrmDocumentContact', 'CONTACT_777']
['crm', 'CCrmDocumentDeal', 'DEAL_777']
['lists', 'BizprocDocument', '777']
['disk', 'Bitrix\Disk\BizProcDocument', '777']
['tasks', 'Bitrix\Tasks\Integration\Bizproc\Document\Task', '777']

/*b_bp_task  таблица для записи элементов БП
Почта контакта CRM  и телефоны контактов находятся в отдельной таблице b_crm_field_multi
b_crm_contact
b_uts_crm_contact доп поля*/

//таблица b_iblock_property с пользовательскими полями, фильтровать можно как по кода так и по айди
//b_crm_field_multi — вывести номера тел и почту контакта:
CModule::IncludeModule('crm');
//все о контакте, паспортные данные, фио  
    $dbResult = CCrmFieldMulti::GetList(
    array('ID' => 'asc'),
    array(
        'ENTITY_ID' => 'CONTACT',
    	'TYPE_ID'=>array('PHONE', 'EMAIL'),
        'ELEMENT_ID' => $res_avtor['PROPERTY_FIZ_LITSO_VALUE'])
     	 );
    While($fields = $dbResult->Fetch())
    $s[$fields['TYPE_ID']]= $fields;


//список полей типа список
    $res_bp = CIBlockElement::GetProperty($iblock_id, $id, array("sort" => "asc"), array());     
    while($res_pro = $res_bp -> getnext()){
    	$arPropertyMy[$res_pro['ID']] = $res_pro;
    }

	
/*ЮЗЕРЫ*/
global $USER;
$filter = Array("GROUP_ID" => '4');
$order_by = array('NAME'=>'ASC');
$arParameters=array('SELECT'=>array('UF_*'),
'NAV_PARAMS'=>array("nPageSize"=>"50"),
'FIELDS'=>array('NAME', 'LAST_NAME'),
);

$myuser=CUser::GetList( ($a="ID"), ($b="ASC"), $filter, $arParameters );
$army=[];
while ($rsUser = $myuser->Fetch()) 
{
	// echo $rsUser["LOGIN"] . " - " . $rsUser["NAME"] . "\n";
	$army[]=$rsUser;
}

print_r($army);	

/*
Array
(
    [0] => Array
        (
            [NAME] => ООО
            [LAST_NAME] => 
            [UF_PASSPORT_DATA] => 
            [UF_OWNERSHIP_NUMBER] => 
            [UF_IM_SEARCH] => 
            [UF_TSZH_EML_CNFRM_RQ] => 0
            [UF_JK] =>             
        )

    [1] => Array
        (
            [NAME] => тест
            [LAST_NAME] => тест
            [UF_PASSPORT_DATA] => 
            [UF_OWNERSHIP_NUMBER] => 
            [UF_IM_SEARCH] => 
            [UF_TSZH_EML_CNFRM_RQ] => 0
            [UF_JK] => 
        )
*/

///////////////////
$userParams = array(
	'SELECT' => array(),
	'NAV_PARAMS' => array(),
	'FIELDS' => array(
		'ID',
		'NAME',
		'LAST_NAME'
					),
);
#implode('|', $ispolniteli)
$sql=CUser::GetList($id='ID', $sort='ASC', array('ID'=>implode('|', $ispolniteli)), $userParams);
while($sqluser = $sql->fetch()){
	echo '<pre>';
	print_r($sqluser);
}
///////////////
function GetUserName($id){
	$user_sql = CUser::GetByID($id);
	$user_name = $user_sql->fetch();
	return  $user_name ['LAST_NAME'];
}; //ФИО
				
/////////////////	
//получаем имена ответственных в виде массива через GetList, в where  подставляем строку полученую через implode из массива
    	$userParams = array(
    		'SELECT' => array(),
    		'NAV_PARAMS' => array(),
    		'FIELDS' => array(
                    			'ID',
                    			'NAME',
                    			'LAST_NAME'  
                             ),
	   );
        $sql=CUser::GetList($id='ID', $sort='ASC', array('ID'=>implode('|',$ispolniteli)), $userParams);
        $i=0;
        while($sqluser = $sql->fetch()){
    		$userOtvetstvenie[$i]['ID'] = $sqluser['ID'];
    		$userOtvetstvenie[$i]['NAME'] = $sqluser['NAME'];  
    		$userOtvetstvenie[$i]['NAME'].= " " . $sqluser['LAST_NAME'];
    		++$i;
	    } 
echo '<pre>';
print_r($result_ar); 
//

Запрос дополнительной информации:
[b]Название задания:[/b]  {=Document:NAME}{{=if({=Document:DETAIL_TEXT}, "
[b]Резолюция:[/b] {=Document:DETAIL_TEXT}", "")}} {{=if({=Document:PROPERTY_SROK_ISPOLNENIYA},"
[b]Срок исполнения:[/b]{=Document:PROPERTY_SROK_ISPOLNENIYA}", "")}}
 {{=if({=Variable:comment_ispolnitelya > printable},"
[b]Информация от исполнителя:[/b][i]{=A61045_455_71039_49359:InfoUser > printable}:[/i] {=Variable:comment_ispolnitelya > printable}","")}} {{=if({=Variable:file_ispolnitel > printable}, "
[b]Файл от исполнителя:[/b] {=Variable:file_ispolnitel > printable}", "")}} {{=if({=Document:PROPERTY_VLOZHENIE_PRINTABLE},"
[b]Файл от постановщика:[/b] [i]{=Document:PROPERTY_VLOZHENIE_PRINTABLE}[/i]", "")}} {{=if({=A78258_88919_16732_40744:Comments > printable},"
[b]Постановщик задания[/b] [i]{=A78258_88919_16732_40744:Comments > printable}[/i]", "")}} {{=if({=A62893_71531_97131_14881:Comments > printable},"
[b]Комментарий автора:[/b] [i]{=A62893_71531_97131_14881:Comments > printable}[/i]","")}}

{{=if({=Variable:otvet_file > printable},"
[b]Файл ответственного[/b]: {=Variable:otvet_file > printable}","")}}


Запрос дополнительной информации:
[b]Название:[/b]
{=Document:NAME}

[b]Резолюция:[/b]
{=Document:DETAIL_TEXT}

[b]Дата создания:[/b]
{=Document:DATE_CREATE}

[b]Список ответственных:[/b]
{=Document:PROPERTY_OTVETSTVENNYE_PRINTABLE}
{{=if({=Document:PROPERTY_SROK_ISPOLNENIYA},"

[b]Срок выполнения:[/b] 
 {=Document:PROPERTY_SROK_ISPOLNENIYA}","")}}
{{=if({=Variable:otvet_info > printable},"

[b]Комментарий от ответственного:[/b]
{=Variable:otvet_info > printable}","")}}
{{=if({=Variable:otvet_file > printable},"

[b]Файл от ответственного:[/b] {=Variable:otvet_file > printable}", "")}}
{{=if({=Document:PROPERTY_VLOZHENIE_PRINTABLE}, "
[b]Файл от постановщика:[/b] {=Document:PROPERTY_VLOZHENIE_PRINTABLE}", "")}}

Утверждение документа:
Выполнено: {=Document:PROPERTY_OTVETSTVENNYE_PRINTABLE}
[b]Название задания: [/b]{=Document:NAME}  {{=if({=Document:DETAIL_TEXT}, "
[b]Резолюция:[/b] {=Document:DETAIL_TEXT}", "")}} {{=if({=Document:PROPERTY_SROK_ISPOLNENIYA},"
[b]Срок исполнения:[/b]{=Document:PROPERTY_SROK_ISPOLNENIYA}", "")}}
 {{=if({=Variable:comment_ispolnitelya > printable},"
[b]Информация от исполнителя:[/b][i]{=A61045_455_71039_49359:InfoUser > printable}:[/i] {=Variable:comment_ispolnitelya > printable}","")}} {{=if({=Variable:file_ispolnitel > printable}, "
[b]Файл от исполнителя:[/b] {=Variable:file_ispolnitel > printable}", "")}} {{=if({=Document:PROPERTY_VLOZHENIE_PRINTABLE},"
[b]Файл от постановщика:[/b] [i]{=Document:PROPERTY_VLOZHENIE_PRINTABLE}[/i]", "")}} {{=if({=A78258_88919_16732_40744:Comments > printable},"
[b]Постановщик задания[/b] [i]{=A78258_88919_16732_40744:Comments > printable}[/i]", "")}} {{=if({=Variable:otvet_info > printable},"
[b]Комментарий ответственного: {=Variable:otvet_info > printable}[/b]", "")}} {{=if({=Variable:otvet_file > printable}),"
[b]Файл ответственного[/b]: {=Variable:otvet_file > printable}",""}}
?>