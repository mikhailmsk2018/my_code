<?

global $DB;
CModule::IncludeModule('bizproc');
CModule::IncludeModule('crm');
$vid_sql = CIblockElement::GetList(array(), array('IBLOCK_ID' => IntVal(95), 'PROPERTY_ZDANIE' => '766677',  'PROPERTY_STATUS_VALUE'=>'В ОРК'), false, true, array('ID','PROPERTY_STATUS'));
$arRes=array();echo "<pre>";
while($arsql = $vid_sql->fetch()){
	$ar[]=$arsql['ID'];


	########запустить бп##########
$arErrorsTmp = array();
		CBPDocument::StartWorkflow(
		255,
		array("lists","BizprocDocument", $arsql['ID']),
		array(),
		$arErrorsTmp
		);
}




die;
$c=implode(',',$ar);
echo "<pre>";
$sql='SELECT ID FROM b_bp_workflow_instance WHERE DOCUMENT_ID IN ('.$c.') LIMIT 1111';
$result_sql = $DB->Query($sql, false, $err_mess.__LINE__);

while($str_result = $result_sql->fetch() )
{
	$xxx[]=$str_result['ID'];


$stopWorkflowId = $str_result['ID'];
	#######остановить выполнение бизнес процесса############
$arState = CBPStateService::GetWorkflowState($stopWorkflowId);

CBPDocument::TerminateWorkflow(
      $stopWorkflowId,
	  $arState["DOCUMENT_ID"],
      $arErrorsTmp
   );

   if (count($arErrorsTmp) > 0)
   {
      foreach ($arErrorsTmp as $e)
         $errorMessage .= $e["message"].". ";
   }


}




$arErrorsTmp = array();
		CBPDocument::StartWorkflow(
		255,
		array("lists","BizprocDocument", $arsql['ID']),
		array(),
		$arErrorsTmp
		);



print_r($ar);

die;
$c=implode(',',$ar);
echo "<pre>";
$sql='SELECT ID FROM b_bp_workflow_instance WHERE DOCUMENT_ID IN ('.$c.') LIMIT 11';
$result_sql = $DB->Query($sql, false, $err_mess.__LINE__);

die;
while($str_result = $result_sql->fetch() )
{
	$xxx[]=$str_result;

}
print_r ($ar);
	//$stopWorkflowId = $str_result['ID'];

	//$arState = CBPStateService::GetWorkflowState($stopWorkflowId);
	//print_r ($arState);


	/*if (count($arState) > 0)
{
   CBPDocument::TerminateWorkflow(
      $stopWorkflowId,
	  $arState["DOCUMENT_ID"],
      $arErrorsTmp
   );

   if (count($arErrorsTmp) > 0)
   {
      foreach ($arErrorsTmp as $e)
         $errorMessage .= $e["message"].". ";
   }
}

*/


print_r ($x);
die;
$stopWorkflowId = '5e61fca7d75b17.11806604';

$arState = CBPStateService::GetWorkflowState($stopWorkflowId);
print_r ($arState);


if (count($arState) > 0)
{
   CBPDocument::TerminateWorkflow(
      $stopWorkflowId,
	  $arState["DOCUMENT_ID"],
      $arErrorsTmp
   );

   if (count($arErrorsTmp) > 0)
   {
      foreach ($arErrorsTmp as $e)
         $errorMessage .= $e["message"].". ";
   }
}

$arErrorsTmp = array();
		CBPDocument::StartWorkflow(
		255,
		array("crm","BizprocDocument", 1012158),
		array(),
		$arErrorsTmp
		);
		
		
_________
if('{=A98444_97693_36516_37205:PROPERTY_code3}' != "") {//проверка поля новый код здания
    $code3='{=A98444_97693_36516_37205:PROPERTY_code3}';
}else{
    $code3='{=A98444_97693_36516_37205:NAME}';
}

$data=array(
	'orginn'=>'{=A2426_15577_32225_39430:PROPERTY_company_inn}',
	'dateopen'=> '{=Document:PROPERTY_DATA_OTKRYTIYA}',
	'adress'=>array(
					'zdkod'=>$code3,
					'vidp'=>'{=A79356_36483_80017_90466:NAME}',
					'nomp'=>'{=Document:PROPERTY_NOMER_POMESHCHENIYA}',
				),
	'otv'=>array(
				'fio'=>'{=A85102_83863_92521_88255:LAST_NAME} {=A85102_83863_92521_88255:NAME} {=A85102_83863_92521_88255:SECOND_NAME}',
				'dr'=>'{=A85102_83863_92521_88255:UF_CRM_1522930531}',
				'pol'=>'',
				"pasport"=>array(
        						"doks"=> '{=A85102_83863_92521_88255:UF_CRM_1491570914}',
        						"dokn"=> '{=A85102_83863_92521_88255:UF_CRM_1491570629}',
        						"dokd"=> '{=A85102_83863_92521_88255:UF_CRM_1491570458}',
        						"dokv"=> '{=A85102_83863_92521_88255:UF_CRM_1491570568}',
        						"dokp"=> '{=A85102_83863_92521_88255:UF_CRM_1491570580}',
						      ),
				),
	"email"=> '{=Document:PROPERTY_ELEKTRONNAYA_POCHTA}',
	"tel"  => '{=Document:PROPERTY_TELEFON}',
	'osn'=> array(
            	   'osnv' => '{=Document:PROPERTY_VID_DOKUMENTA}',
            	   'osns' => '{=Document:PROPERTY_SERIYA_DOKUMENTA}',
            	   'osnn' => '{=Document:PROPERTY_NOMER_DOKUMENTA}',
            	   'osnd' => '{=Document:PROPERTY_DATA_VYDACHI_DOKUMENTA}',
                ),
	'avtor'=>'{=Document:CREATED_BY_PRINTABLE}',
);



$this->SetVariable('data',$data);



$url =  'http://aps01.test.org/buh/hs/Bitrix/open/'; 
$url2 ='http://dev01.test.org/buh_copy20200_4/hs/Bitrix/open/'; // тестовый
$avtorizaciya=false;//без авторизации 
$json=1; 
$files=array(); // для файла 
$res=SendPOST($url,$data);//к 1с с авторизацией

if($res == false){
    $mesError='Ошибка сервера, попробуйте изменить лицевой счет позднее или обратитесь в техническую поддержку';
    $this->SetVariable('mesError', $mesError);//ошибка при если не работает 1с, для оповещения
}else{
    $arJson=json_decode($res, true);//декодируем результат от 1С
    if($arJson['error'] != ""){
        $mesError='Ошибка: '.$arJson['error'];
        $this->SetVariable('mesError', $mesError); // ошибка от 1С для оповещения РАО и Автора
    }
    //переменные ошибок для оповещения
    if($arJson['numdoc'] != "") {
        $this->SetVariable('numdoc', 'Номер лицевого счета: '.$arJson['numdoc']);
        $this->SetVariable('lsResult', $arJson['numdoc']);
    }
    if($arJson['status'] == 1) $this->SetVariable('status',  'Лицевой счет создан успешно!');
}

_________
//Ш393К0003СТ02, Ш393К0008СТ02, С011К0003ЮС02, О040К0007ЮС01 это л/с для тестового сервера (dev)
$data=array('nomls'=>'{=Document:PROPERTY_NOMER_LITSEVOGO_SCHETA}');
$url = 'http://aps01.test.org/Billing_ik_buh/hs/Bitrix/infols/';
//http://dev01.test.org/Billing_ik_buh_copy20200211_4/hs/Bitrix/infols/'; тестовый

$res=SendPOST($url,$data);
$arMy = json_decode($res, true);

if($res == false){
    $this->SetVariable('infols', 'Ошибка сервера, попробуйте изменить лицевой счет позднее или обратитесь в техническую поддержку');
}elseif($arMy['error'] != ""){
    $this->SetVariable('infols', $arMy['error']);
}else{
    //поле "Пол", подставляем ID тега option
    if($arMy['info']['otv']['pol'] == 'Мужской'){
        $pol = 812;
    }elseif($arMy['info']['otv']['pol']=='Женский'){
        $pol = 813;
    }else{$pol = "";}
    
    $this->SetVariable('dataOpen',  $arMy['info']['dateopen']);// дата открытия лицевого счета
    $this->SetVariable('zdkod',     $arMy['info']['adress']['zdkod']);// код здания
    $this->SetVariable('nomp',      $arMy['info']['adress']['nomp']);// номер помещения
    $this->SetVariable('fio',       $arMy['info']['otv']['fio']); //ФИО
    $this->SetVariable('dr',        $arMy['info']['otv']['dr']);//дата рождения
    $this->SetVariable('pol',       $pol); // пол
    $this->SetVariable('doks',      $arMy['info']['otv']['pasport']['doks']); // серия паспорта
    $this->SetVariable('dokn',      $arMy['info']['otv']['pasport']['dokn']); // номер паспорта
    $this->SetVariable('dokd',      $arMy['info']['otv']['pasport']['dokd']);//дата выдачи паспорта
    $this->SetVariable('dokv',      $arMy['info']['otv']['pasport']['dokv']);//кем выдан паспорта
    $this->SetVariable('dokp',      $arMy['info']['otv']['pasport']['dokp']);//код подразделения паспорта
    $this->SetVariable('email',     $arMy['info']['email']);//адрес электронной почты
    $this->SetVariable('tel',       $arMy['info']['tel']);//телефон       
}


$aarr=json_decode('{=Document:PROPERTY_ARRAY_MY}', true);   //массив текущие данные, который ввел пользователь
//сравниваю значения пользователя с данными из бд
'{=Document:PROPERTY_DATA_ROZHDENIYA}' != $aarr['PROPERTY_DATA_ROZHDENIYA_VALUE']?$dr = '{=Document:PROPERTY_DATA_ROZHDENIYA}':$dr = $aarr['PROPERTY_DATA_ROZHDENIYA_VALUE']; //Дата рождения
'{=Document:PROPERTY_SERIYA_PASPORTA}' != $aarr['PROPERTY_SERIYA_PASPORTA_VALUE']? $pasS = '{=Document:PROPERTY_SERIYA_PASPORTA}': $pasS = $aarr['PROPERTY_SERIYA_PASPORTA_VALUE'];// Серия паспорта
'{=Document:PROPERTY_NOMER_PASPORTA}' != $aarr['PROPERTY_NOMER_PASPORTA_VALUE']?$pasN = '{=Document:PROPERTY_NOMER_PASPORTA}':$pasN = $aarr['PROPERTY_NOMER_PASPORTA_VALUE'];// Номер паспорт
'{=Document:PROPERTY_DATA_VYDACHI_PASPORTA}' != $aarr['PROPERTY_DATA_VYDACHI_PASPORTA_VALUE']?$pasD = '{=Document:PROPERTY_DATA_VYDACHI_PASPORTA}':$pasD = $aarr['PROPERTY_DATA_VYDACHI_PASPORTA_VALUE'];// Дата выдачи паспорта
'{=Document:DETAIL_TEXT}' != $aarr['DETAIL_TEXT']?$pasV = '{=Document:DETAIL_TEXT}':$pasV = $aarr['DETAIL_TEXT'];// кем выдан паспорта
'{=Document:PROPERTY_KOD_PODRAZDELENIYA_PASPORTA}' != $aarr['PROPERTY_KOD_PODRAZDELENIYA_PASPORTA_VALUE']?$pasP = '{=Document:PROPERTY_KOD_PODRAZDELENIYA_PASPORTA}':$pasP = $aarr['PROPERTY_KOD_PODRAZDELENIYA_PASPORTA_VALUE'];//код подразделения паспорта
'{=Document:PROPERTY_EMAIL}' != $aarr['PROPERTY_EMAIL_VALUE']?$pasE = '{=Document:PROPERTY_EMAIL}':$pasE = $aarr['PROPERTY_EMAIL_VALUE'];// адрес электронной почты
'{=Document:PROPERTY_TEL}' != $aarr['PROPERTY_TEL_VALUE']?$pasT = '{=Document:PROPERTY_TEL}':$pasT = $aarr['PROPERTY_TEL_VALUE'];// телефон
//ниже строка даты рождения, ставлю по умолчанию если юзер не заполнил т.к. 1су эта дата нужна 
if('{=Document:PROPERTY_DATA_ROZHDENIYA}'==""){$dr='01.01.0001';}else{$dr='{=Document:PROPERTY_DATA_ROZHDENIYA}';}

$data = array(
'nomls' =>'{=Document:PROPERTY_NOMER_LITSEVOGO_SCHETA}',
'otv' => array(
		   'fio' => '{=Document:PROPERTY_KLIENT}', 
		   'dr' => $dr,
		   'pol' => '{=Document:PROPERTY_POL}',
		   'pasport' => array(
				'doks' => '{=Document:PROPERTY_SERIYA_PASPORTA}',
				'dokn' => $pasN,
				'dokd' => $pasD,
				'dokv' => $pasV ,
				'dokp' => $pasP,
				),
			 ),
'email' => $pasE,
'tel' =>      $pasT,
'avtor' => '{=Document:CREATED_BY_PRINTABLE}',
);


$url2 = 'http://dev01.test.org/Billing_ik_buh_copy20200211_4/hs/Bitrix/changels/'; //тестовый
$url  = 'http://aps01.test.org/Billing_ik_buh/hs/Bitrix/changels/'; 
//$httpClient = new \Bitrix\Main\Web\HttpClient();
//$posrAr = $httpClient->post($url, json_encode($data));

$posrAr = SendPost($url, $data);//, array(), 1, false);

if($posrAr == false){
    $error  = 'Ошибка сервера, попробуйте изменить лицевой счет позднее или обратитесь в техническую поддержку';   
    $this->SetVariable('test_2', $error);
}else{
    $status = json_decode($posrAr, true);
    if($status['status'] == 1){$suc = 'Cчет изменен успешно.';}
    if($status['error'] != ""){$error = 'Ошибка: '. $status['error'];}
    if((strpos($posrAr, '1081')) || (strpos($posrAr, '1101'))){$povtor='По данному счету производить правки возможно один раз в день. Сегодня изменения вносились.';}
    
    $this->SetVariable('test_1', $suc);
    $this->SetVariable('test_2', $error);
    $this->SetVariable('test_povtor', $povtor);
}

/*-----------*/
global $DB;
CModule::IncludeModule('bizproc');
CModule::IncludeModule('crm');

$sql = "SELECT crm.ID, uts.UF_CRM_1500291929, uts.UF_CRM_1576068494 FROM b_crm_contact as crm
LEFT JOIN b_uts_crm_contact as uts ON crm.ID = uts.VALUE_ID
WHERE uts.UF_CRM_1500291929 IS NOT NULL AND uts.UF_CRM_1500291929 <> 'a:0:{}' AND uts.UF_CRM_1576068494 IS NULL 
ORDER BY crm.ID LIMIT 5000 OFFSET 13000";  
$result_sql = $DB->Query($sql, false, $err_mess.__LINE__);
echo '<pre>';
while($str_result = $result_sql->fetch() )
{
	//$ar_vse_depart[$str_result['VALUE_ID']] = unserialize($str_result['UF_CRM_1501237695']);
	//$ar_vse_depart[] = unserialize($str_result['UF_CRM_1501237695']);
	//if(count(unserialize($str_result['UF_CRM_1500291929']))>0){
	//$ar_vse_depart[$str_result['ID']] = unserialize($str_result['UF_CRM_1500291929']);
		$ar_vse_depart[$str_result['ID']] = unserialize($str_result['UF_CRM_1500291929']);
		/*
		$arErrorsTmp = array();
		CBPDocument::StartWorkflow(
		233,
		array("crm","CCrmDocumentContact", 'CONTACT_'.$str_result['ID']),
		array(),
		$arErrorsTmp
		);
*/
	//}
}
$i=0;
foreach($ar_vse_depart as $k=>$v){


	//if($i<=100)
	//{
		$arErrorsTmp = array();
		CBPDocument::StartWorkflow(
		233,
		array("crm","CCrmDocumentContact", 'CONTACT_'.$k),
		array(),
		$arErrorsTmp
		);
	//}
++$i;
}

echo '<pre>' . print_r($ar_vse_depart, true).'</pre>';

/*_______  _______*/


CModule::IncludeModule('iblock');
$sql_bd = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID'=>IntVal(39), 'ACTIVE'=>'Y', 'ID'=>'826780'),
	false,
	array(),
	array('NAME', 'ID')
);

//print_r ($sql_bd['NAME']);
while($chto=$sql_bd->Fetch()){
	print_r($chto['NAME']);
}


CModule::IncludeModule('iblock');
$arFilter = Array(array( 
        "LOGIC"=>"OR", 
        array("IBLOCK_ID"=>88, '!DETAIL_TEXT'=>'В полицию (составил Румянцев)'), 
        array("IBLOCK_ID"=>82,'!PROPERTY_DOLZHNOST'=>'')

    ));
$arSelect = Array('PROPERTY_DOLZHNOST');
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array());

while($data=$res->Fetch()){
$ar[]=$data;
}
echo '<pre>';
print_r($ar);

/*_______  _______*/

CModule::IncludeModule('iblock'); CModule::IncludeModule('crm'); 
Global $DB, $USER;
$db_enum_list = CIBlockProperty::GetPropertyEnum("POL", Array(), Array("IBLOCK_ID"=>97));
while($ar_enum_list = $db_enum_list->GetNext())
{
  
  echo "<pre>";
  print_r($ar_enum_list);
  echo "</pre>";
  
}

die;
$user_sql = CCrmContact::GetList(array('ID' => 'DESC'),array('ID'=>'46585'), array('NAME', 'LAST_NAME', 'SECOND_NAME', 'UF_CRM_1522930531', 'UF_CRM_1491570914', 'UF_CRM_1491570629', 'UF_CRM_1491570458', 'UF_CRM_1491570568', 'UF_CRM_1491570580'));
$user=$user_sql->fetch();
echo "<pre>";
print_r ($user);

die();
$vid_sql = CIblockElement::GetList(array(), array('IBLOCK_ID' => IntVal(98), 'ID' =>  '988588'), false, true, array('NAME'));
$vidPomescheniya = $vid_sql->fetch();
echo "<pre>";
print_r ($vidPomescheniya);

die();
//$sql_ooo=CIBlockElement::Getlist(array('ID'=>'ASC'),array('IBLOCK_ID'=>IntVal(47), 'ID'=>962287), false, true, array());
//$sql=$sql_ooo->fetch();
$user_sql = CCrmContact::GetList(array('ID' => 'DESC'),array('ID'=>46585), array('NAME', 'LAST_NAME', 'SECOND_NAME'));
$user=$user_sql->fetch();
$fio = $user['LAST_NAME'].' '.$user['NAME']. " " . $user['SECOND_NAME'];

echo "<pre>";
print_r ($fio);


die;
$arFilter = Array("IBLOCK_ID"=>intVal(88), "ID"=>981496);
$arSelect = Array();
$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, array('DATE_CREATE', 'DETAIL_TEXT', 'PROPERTY_SOTRUDNIK', 'PROPERTY_skan_pasporta', 'PROPERTY_data_end', 'PROPERTY_data_begin'));
while($data=$res->Fetch()){
echo "<pre>";
print_r($data);
}


die;
$userParams = array(
    'SELECT' => array('UF_DEPARTMENT'),
	'FIELDS' => array('ID', 'ACTIVE', 'NAME', 'UF_DEPARTMENT', 'LAST_NAME', 'SECOND_NAME', 'FIRST_NAME' ) 
);
$order = array('sort' => 'asc'); $tmp = 'sort';
$rsUser=CUser::GetList($order,$tmp, array('ID'=>'1422'),  $userParams);
$arUser = $rsUser->fetch();
$a = implode(',' , $arUser['UF_DEPARTMENT']);
$d=explode(',',$a);

$sql_otdel = CiblockSection::GetList(array(), array( 'IBLOCK_ID'=>5, 'ID'=>$d ), array(), array()); 
while($otdel = $sql_otdel->fetch()){
$b[]=$otdel['NAME'];
}

echo "<pre>";
print_r($b);
?>