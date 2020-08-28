<?
$sql_ooo=CIBlockElement::Getlist(array('ID'=>'ASC'),array('IBLOCK_ID'=>IntVal(39), 'ID'=>'{=Document:PROPERTY_ORGANIZATSIYA}'), false, true, array('PROPERTY_209'));
$sql=$sql_ooo->fetch();

$sql_222=CIBlockElement::Getlist(array('ID'=>'ASC'),array('IBLOCK_ID'=>IntVal(47), 'ID'=>'{=Document:PROPERTY_ZDANIE}'), false, true, array('NAME'));
$sql2=$sql_222->fetch();

$user_sql = CCrmContact::GetList(array('ID' => 'DESC'),array('ID'=>'{=Document:PROPERTY_FIZ_LITSO}'), array('NAME', 'LAST_NAME', 'SECOND_NAME', 'UF_CRM_1522930531', 'UF_CRM_1491570914', 'UF_CRM_1491570629', 'UF_CRM_1491570458', 'UF_CRM_1491570568', 'UF_CRM_1491570580'));
$user=$user_sql->fetch();
$fio = $user['LAST_NAME'].' '.$user['NAME']. " " . $user['SECOND_NAME'];

$vid_sql = CIblockElement::GetList(array(), array('IBLOCK_ID' => IntVal(98), 'ID' =>  '{=Document:PROPERTY_VID_POMESHCHENIYA}'), false, true, array('NAME'));
$vidPomescheniya = $vid_sql->fetch();

$arForma = [];
$arForma['organizatsiya'] = $sql['PROPERTY_209_VALUE'];  //Организация
$arForma['zdanie'] = $sql2['NAME']; //Здание
$arForma['fiz_litso'] = $fio; // Клиент
$arForma['vid_pomeshcheniya'] = $vidPomescheniya['NAME']; // Вид помещения
$arForma['nomer_pomeshcheniya'] = '{=Document:PROPERTY_NOMER_POMESHCHENIYA}'; // Номер помещения
$arForma['ploshchad'] = '{=Document:PROPERTY_PLOSHCHAD}';// Площадь для начисления
$arForma['podezd'] = '{=Document:PROPERTY_PODEZD}';// Подъезд
$arForma['data_otkrytiya'] = '{=Document:PROPERTY_DATA_OTKRYTIYA}';
$arForma['vid_dokumenta'] = '{=Document:PROPERTY_VID_DOKUMENTA}';
$arForma['data_vydachi_dokumenta'] = '{=Document:PROPERTY_DATA_VYDACHI_DOKUMENTA}';
$arForma['seriya_dokumenta'] =  '{=Document:PROPERTY_SERIYA_DOKUMENTA}';
$arForma['nomer_dokumenta'] = '{=Document:PROPERTY_NOMER_DOKUMENTA}';
$arForma['kem_vidan']     =          '{=Document:PROPERTY_KEM_VYDAN_DOKUMENT}';  
$arForma['telefon'] = '{=Document:PROPERTY_TELEFON}';
$arForma['email']  =  '{=Document:PROPERTY_ELEKTRONNAYA_POCHTA}';

global $USER;

$data=array(
	'orginn'=>'{=A2426_15577_32225_39430:PROPERTY_company_inn}',
	'dateopen'=> '{=Document:PROPERTY_DATA_OTKRYTIYA}',
	'adress'=>array(
					'zdkod'=>'{=A98444_97693_36516_37205:NAME}',
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
	'avtor'=>$USER->GetFullName(),
);

#$this->SetVariable('arResult', json_encode($data));

$url =  'http://dev01.test.ru/ik_buh_copy20190407_4/Bitrix/open/';	#dev

function SendPOST2($url,$data) {
		$httpClient = new \Bitrix\Main\Web\HttpClient();
		$sendArray=$data;
		$httpClient->setCharset('UTF-8');
		$response = $httpClient->post($url,json_encode($sendArray));
		
		return $response;
};


$avtorizaciya=false;//без авторизации 
$json=1; 
$files=array(); // для файла 
$res=SendPOST($url,$data,$files,$json,$avtorizaciya);
$arJson=json_decode($res, true);
$this->SetVariable('adres', $arJson);

if($res == false){$mesError='Ошибка на стороне 1С';}
$this->SetVariable('mesError', $mesError);

//переменные ошибок для оповещения
if($arJson['numdoc'] != "") $this->SetVariable('numdoc', 'Номер лицевого счета: '.$arJson['numdoc']);
if($arJson['error'] != "")  $this->SetVariable('error',  'Ошибка: '.$arJson['error']);
if($arJson['status'] == 1) $this->SetVariable('status',  'Лицевой счет создан успешно!');
?>