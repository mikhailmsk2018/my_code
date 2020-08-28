<?

$arUser= [];$arAR=[];
            
            foreach($ar_usluga as $k => $v)
            {
            
            	foreach($v as $k1 => $v1){
            		if($v1['PROPERTY_TIP_USLUGI_VALUE']){
            			$name_usluga_sql = CIBlockElement::GetList(array('SORT'=>'ASC'),array('IBLOCK_ID'=>'81',  'ID'=>$v1['PROPERTY_TIP_USLUGI_VALUE']),false,false,array('ID','NAME'));  
            			$name_usluga = $name_usluga_sql->Fetch();
            		}else{$name_usluga['NAME']="Все типы";}
            
            		//echo "<pre>";
            		//print_r($v1['PROPERTY_ZDANIYA_VALUE']);
            		//$arAR[$k][$name_usluga['NAME']]['zdanie'][]=$v1['PROPERTY_ZDANIYA_VALUE'];
            		$arAR[$k][$name_usluga['NAME']]['zdanie'][$v1['PROPERTY_ZDANIYA_VALUE']]=1;
            		$arAR[$k][$name_usluga['NAME']]['dannie']=$v1;
            		$arAR[$k][$name_usluga['NAME']]['dannie']['name_uzlugi']=$name_usluga['NAME'];
            
            
            $qazxsw=CIblockElement::GetList(array(), array('IBLOCK_ID'=>47, 'ID'=>$v1['PROPERTY_ZDANIYA_VALUE']),false, false,  array('ID','NAME'));
            $sql111=$qazxsw->fetch(); //print_r($sql111);
            if($v1['PROPERTY_ZDANIYA_VALUE']){
            $arAR[$k][$name_usluga['NAME']]['name_zdaniyz'][$v1['PROPERTY_ZDANIYA_VALUE']]=$sql111['NAME'];
            }else{unset($arAR[$k][$name_usluga['NAME']]['name_zdaniyz']);}
            
            
            $user_sql = CUser::GetByID($v1['PROPERTY_OTVETSTVENNYE_VALUE']);
            $user_name = $user_sql->fetch();

            $arAR[$k][$name_usluga['NAME']]['otvetstvennye'][$v1['PROPERTY_OTVETSTVENNYE_VALUE']]=$user_name['NAME']." ". $user_name['LAST_NAME'];
            
            		if($v1['PROPERTY_ZDANIYA_VALUE']){
            $arAR[$k][$name_usluga['NAME']]['zdanie'][$v1['PROPERTY_ZDANIYA_VALUE']]=$v1['PROPERTY_ZDANIYA_VALUE'];
            //$arAR[$k][$name_usluga['NAME']]['zdanie'][$v1['PROPERTY_ZDANIYA_VALUE']]=$user_name['NAME']." ". $user_name['LAST_NAME'];
            		}else{unset($arAR[$k][$name_usluga['NAME']]['zdanie'][$v1['PROPERTY_ZDANIYA_VALUE']]);}
            
            $jksql=CIblockElement::GetList(array(), array('IBLOCK_ID'=>71, 'NAME'=>$kod['PROPERTY_RAION_VALUE']),false, false,  array('ID','NAME'));
            $sql=$jksql->fetch();
            		$arAR[$k][$name_usluga['NAME']]['JK']=$sql['NAME'];
            		$arAR[$k][$name_usluga['NAME']]['dannie']['name_jk']=$sql['NAME'];
            	}
            }
            
            
           $imya_uslug=array();
            foreach($arAR as $k3 => $v3){
                     
                     foreach($v3 as $k4 => $v4)
                     {
                            //print_r($v3[$k4]['dannie']['name_uzlugi']);
                        if(!in_array($v3[$k4]['dannie']['name_uzlugi'],$imya_uslug))
                        {
                            $imya_uslug[]=$v3[$k4]['dannie']['name_uzlugi'];
                        }
                     }
                    
                     
                      
                     if($v3[$_POST['type']]['dannie']['name_uzlugi'] == $_POST['type'])
                     {
                            foreach($v3[$_POST['type']]['otvetstvennye'] as $k4 => $v4)
                            {
                                foreach($v3[$_POST['type']]['name_zdaniyz'] as $k7 => $v7){
                                   // echo $k7;
                                    //echo '<br />';
                                    //echo $v7;
                                    
                                      //$kod['NAME']   =      'Л292';                                    
                                    if($v7==$kod['NAME']){
                                        print_r($v4);  echo '<br />';
                                        
                                    }
                                }
                                
                                
                            }
                     }
                     else
                     {
                         foreach($v3['Все типы']['otvetstvennye'] as $k4 => $v4)
                            {
                                $vse_tipi_user=$v4;
                            }  
                     }
                     
                    //print_r($v3[$_POST['type']]['dannie']['name_uzlugi']);
                    //print_r($v3['Все типы']['dannie']['name_uzlugi']);
           }
            

            
             if(!in_array($_POST['type'], $imya_uslug))
              {
                            echo $vse_tipi_user;
              }

________________

CModule::IncludeModule("iblock");
Global $DB, $USER;
$kod = Array
(
    'ID' => 20910,
    'NAME' => 'Л292',
    'PROPERTY_JK_VALUE' => 379778,
    'PROPERTY_RAION_VALUE' => 'Шуваловский',
    'RAION_DEAL_ID' => 217
);
//print_r($kod);
	//GetKodFromLs -здания, получить из ЛС name и id здания                           
//$kod=GetKodFromLs($_POST['ls']); 
		$_POST['type']=array('Электрика', 'Клининг'); 
//print_r($_POST['type']);
        $ib=new \CIBlockElement;      
        $jksql=CIblockElement::GetList(array(), array('IBLOCK_ID'=>71, 'NAME'=>$kod['PROPERTY_RAION_VALUE']),false, false,  array('ID','NAME'));//инфоблок 71 - ЖК  
        $sql=$jksql->fetch();

        $name_usluga_sql = CIBlockElement::GetList(array('SORT'=>'ASC'),array('IBLOCK_ID'=>'81', 'NAME'=>$_POST['type']),false,false,array('ID','NAME')); //iblock 81 - Тип услуги CRM
//$name_usluga = $name_usluga_sql->Fetch();  //print_r($name_usluga['ID']); //833510 
$ispolniteli=[];  $prior = 0;
while($name_usluga1 = $name_usluga_sql->fetch()){

$name_usluga[]=$name_usluga1;
}
foreach($name_usluga as $k8 => $v8){
$temp = [];
	//echo "<pre>------";print_r($v8['ID']);echo "--------<pre>";
        $arSelect = CIBlockElement::GetList(array('ID'=>'ASC'),array('IBLOCK_ID'=>80,  'PROPERTY_zhk'=>$sql['ID']),false,false,false);//iblock 80 - Привязка Типов услуг к ЖК //array('ID', 'NAME','PROPERTY_otvetstvennye', 'PROPERTY_tip_uslugi'));

        while( $str_usluga = $arSelect->GetNextElement() )
        {   
            $arProps = $str_usluga->GetProperties();
			//echo '<pre>';
			//print_r($arProps['tip_uslugi']['VALUE']);
				if($arProps['zdaniya']['VALUE'] && in_array($kod['ID'],$arProps['zdaniya']['VALUE'])  && $arProps['tip_uslugi']['VALUE'] && $v8['ID'] == $arProps['tip_uslugi']['VALUE'])
				{
				  $prior=2;  
				  $temp = $arProps['otvetstvennye']['VALUE'];
				}
				elseif($prior<2 && ($arProps['tip_uslugi']['VALUE']) && ($v8['ID'] == $arProps['tip_uslugi']['VALUE']) )
				{
				  $prior =1;
				  $temp = $arProps['otvetstvennye']['VALUE']; 
				}
				elseif($prior<1 && !($arProps['tip_uslugi']['VALUE']))
				{
				  $temp = $arProps['otvetstvennye']['VALUE']; 
				}


        }

$result_ar = array_merge($ispolniteli,$temp);
print_r($result_ar);
}

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
//print_r($ispolniteli);                          
// $result = $userOtvetstvenie;       
// break;

____________________

function GetDealFilter_2($arFilter,$cat_id=-1,$userID=0){
	CModule::IncludeModule("iblock");
	Global $USER; global $DB;
	if(!$userID) $userID=$USER->GetID();
	$wtemp=CUser::GetByID($userID);
	$arUser = $wtemp->Fetch();
	$arGroups = CUser::GetUserGroup($userID);
	$arFilterOld=$arFilter;
	$result=array(); 
	$stack_raion=array();
	$jk = GetBlockElements('71','NAME'); //получаем массив вида [379783] => Садовые кварталы
	$arFilter8 = array( 'IBLOCK_ID'=>5,'ID'=>$arUser['UF_DEPARTMENT'] ); // 5й инфоблок - Подразделения, вытаскиваем привязку к жк в ввиде айди жк
	$sql1=CIblockSection::GetList(array(), $arFilter8, false, array('ID','NAME', 'UF_PRIVYAZKA_K_JK'));  
		$arAr=[];  $arAr3=[];  
	while($sql=$sql1->Fetch()){
		$arAr = $sql['UF_PRIVYAZKA_K_JK'];  // получаем массив имен жк юзера у которых есть привязка
		if(is_array($arAr3) && is_array($arAr)){
			$arAr3 = array_merge($arAr3, $arAr);//собираем одномерный массив
		}
	}
	//print_r($arAr3);
	if($arAr3)
    {
		foreach($arAr3 as $k => $v){
			$ar2[] = $jk[$v]; //получаем массив имен жк из функции GetBlockElements
		}
		$unique = array_unique($ar2); //уникальные имена
		
		$stringAr = (string)implode('\',\'',$unique);
		$strSql = "SELECT ID FROM b_user_field_enum WHERE USER_FIELD_ID='253' AND VALUE IN ('". $stringAr ."')";  // получаем айди жк для сделок вида [ID] => 221
		$res = $DB->Query($strSql, false, $err_mess.__LINE__);
		while($enum = $res->fetch()){
			$stack_raion = array_merge($stack_raion, (array)$enum['ID']); // создаем одномерный массив  айди жк для сделок
		}
		$result=$stack_raion;
		$arFilter['UF_CRM_1494399115'] =$result;
		//print_r($arFilter);
    }else{
		$arFilter=[];
    }


	//if(count($result)>0){
	//$dopFilter=array("UF_CRM_1494399115" => $result);  
			//print_r ($arFilter);
	//$arFilter['UF_CRM_1494399115']=array_merge($arFilter['UF_CRM_1494399115'], $dopFilter['UF_CRM_1494399115']);
	//}
	if(in_array(486,$arUser['UF_DEPARTMENT']) OR in_array(536,$arUser['UF_DEPARTMENT'])) {//486-Шуваловский, Татьяна //536-Доминион, Balchug Rezidence, Balchug Viewpoint, 20&20
			if($cat_id==0) { //cat_id==0 платные услуги
				$dopFilter=array_merge($dopFilter,array("!UF_CRM_1504851625" => false)); // Исполнители ЕДС
			}
			else{
				$dopFilter=array_merge($dopFilter,array("!CATEGORY_ID" => 0)); 
			}
	}

	//print_r ($stack_raion);
	//print_r ($arFilterOld);

	if(count($stack_raion)>1 AND isset($arFilterOld['UF_CRM_1494399115']) AND count($arFilterOld['UF_CRM_1494399115'])) 
	{
		$arFilter['UF_CRM_1494399115'] = array_intersect($arFilterOld['UF_CRM_1494399115'], $stack_raion);
	}
	elseif(count($stack_raion)>1) 
	{
		$arFilter['UF_CRM_1494399115']=$stack_raion;
	}
return ($arFilter);
}

$arFilter['UF_CRM_1494399115']=array('1'=>'281', 'tes'=>'333');
echo '<pre>';
print_r (GetDealFilter_2($arFilter, '8', 914));//1053

____________

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

________________


CModule::IncludeModule('iblock');
$sql_bd = CIblockElement::GetList(
	array(),
	array('IBLOCK_ID'=>IntVal(39), 'ACTIVE'=>'Y', 'ID'=>'826780'),
	false,
	array(),
	array('NAME', 'ID')
);

//print_r ($sql_bd['NAME']);
while($huichto=$sql_bd->Fetch()){
	print_r($huichto['NAME']);
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

________________

CModule::IncludeModule('iblock');

//$numeratorId=5;
//$numerator = \Bitrix\Main\Numerator\Numerator::load($numeratorId);

//echo $numerator->previewNextNumber();// - посмотреть следующий номер, без сохранения состояния в нумераторе
//$numerator->getNext(); //- взять следующий номер
//echo $numNext=$numerator->getNext();


$kratkoe_organizaciya = '{=A80467_73208_54710_42619:PROPERTY_KRATKOE_OBOZNACHENIE}';
$numerator_id=5;

//$org_id=$this->GetVariable('org');
//$doc_date='{=Document:PROPERTY_DATA_DOKUMENTA}';
//$month=substr($doc_date,3,2).substr($doc_date,6,4);
//$numNext=$numerator->previewNextNumber($hash);

function numerator_next2($numerator_id=0, $name=null)
{
	CModule::IncludeModule('iblock');
	$numerator_id = 5;//id нумератора доверенности
	$numerator = \Bitrix\Main\Numerator\Numerator::load($numerator_id);	
	$numNext=$numerator->getNext($name);
	return $numNext;
}

$nomer = numerator_next2($numerator_id, $kratkoe_organizaciya);
echo $nomer;

//$num.='-'.substr($doc_date,3,2).'/'.substr($doc_date,6,4).'-'.$org_short;
//$this->SetVariable('num',$num);


CModule::IncludeModule('iblock'); CModule::IncludeModule('crm');
echo "<pre>";


die;
/*$res_bp = CIBlockElement::GetProperty(95, 962569, array("sort" => "asc"), array());     
    while($res_pro = $res_bp -> getnext()){
    	$arPropertyMy[$res_pro['ID']] = $res_pro['CODE'];
    }
echo "<pre>";
print_r($arPropertyMy);*/
/*
$select=array('CREATED_BY', 'CREATED_DATE', 'ID', 'PROPERTY_ORGANIZATSIYA', 'PROPERTY_ZDANIE', 'FIZ_LITSO', 'PROPERTY_VID_POMESHCHENIYA', 'PROPERTY_NOMER_LITSEVOGO_SCHETA', 'PROPERTY_NOMER_POMESHCHENIYA', 'PROPERTY_PLOSHCHAD', 'PROPERTY_PODEZD', 'PROPERTY_DATA_OTKRYTIYA', 'PROPERTY_VID_DOKUMENTA', 'PROPERTY_DATA_VYDACHI_DOKUMENTA', 'PROPERTY_SERIYA_DOKUMENTA', 'PROPERTY_NOMER_DOKUMENTA', 'PROPERTY_KEM_VYDAN_DOKUMENT', 'PROPERTY_TELEFON', 'PROPERTY_ELEKTRONNAYA_POCHTA', 'PROPERTY_PRIKREPITE_FAYL', 'PROPERTY_DOKUMENT_DLYA_PECHATI');
    $sql_avtor = CIblockElement::getlist(array(), array('IBLOCK_ID'=>95, 'ID'=>962569), false, false, $select);
    $res_avtor = $sql_avtor->fetch();
    print_r($res_avtor); 
    $user_sql= CUser:: getById($res_avtor['CREATED_BY']);
    $user = $user_sql->fetch();
*/
//print_r($arPropertyMy);
//die;
$dbResult = CCrmFieldMulti::GetList(
    array('ID' => 'asc'),
    array(
        'ENTITY_ID' => 'CONTACT',
		'TYPE_ID'=>array('PHONE', 'EMAIL'),
        'ELEMENT_ID' => 46585)
		);
While($fields = $dbResult->Fetch())
$s[$fields['TYPE_ID']]= $fields;

$rsUser = CcrmContact::getlist(array(), array('ID'=>46585, 'CHECK_PERMISSIONS' => 'N'), array());
$ob = $rsUser->GetNext();

$ob['FieldMulti']=$s;
echo "<pre>";
print_r($ob);







/*$res_org = CIBlockElement::GetProperty(96, 970416, array("sort" => "asc"), array());
while($shablon = $res_org->getnext())
    {
    	$adres[$shablon['ID']] = $shablon;
    }
echo "<pre>";
print_r($adres);*/
/*
$res_org = CIblockElement::getlist(array(), array('IBLOCK_ID'=>96, 'PROPERTY_590_VALUE'=>935023),false,false,array('ID', 'PROPERTY_590', 'PROPERTY_591', 'PROPERTY_592'));
while($shablon = $res_org->getnext()){
    	$adres[$shablon['ID']] = $shablon;
    }
echo "<pre>";
print_r($adres);
*/
/*
$requisite = new \Bitrix\Crm\EntityRequisite();
		$rs = $requisite->getList(
        [
		  "filter" => 
          [
          "ENTITY_ID" => 826780, 
          "ENTITY_TYPE_ID" => CCrmOwnerType::Company,
		  ]
		]
        );
		while($wtemp=$rs->fetchAll()) {
			$client_company_info=current($wtemp);
			$addresses = Bitrix\Crm\EntityRequisite::getAddresses(826780);
			$client_company_adress=$addresses[6]; // Получаем юр. адрес
			$params = ['filter' => [
			  'ENTITY_ID' => 826780, 
			  'ENTITY_TYPE_ID' => CCrmOwnerType::Requisite
				]
			];
			$client_company_bank = (new \Bitrix\Crm\EntityBankDetail)->getList($params)->fetch();
			print_r ($client_company_bank);


/*$res_org = CIblockElement::getlist(array(), array('IBLOCK_ID'=>47, 'ID'=>962287),false,false,false);
//$res_org = CIBlockElement::GetProperty(47, 962287, array("sort" => "asc"), array());
    while($adr = $res_org->getnext())
    {
    	$adres = $adr['NAME'];
    }
    echo "<pre>";
print_r($adres);
*/
//print_r (GetLsToAdres());


/*$sql_avtor = CIblockElement::getlist(array(), array('IBLOCK_ID'=>'95', 'ID'=>$id), false, false, array('CREATED_BY', 'CREATED_DATE'));
    $res_avtor = $sql_avtor->fetch();

    echo "<pre>";
    print_r($res_avtor); 
*/

//$db_props = CIBlockElement::GetProperty(39, 670463, array("sort" => "asc"), array());
//$db_props = CIBlockElement::GetByID(805930);
//$company_name_res = $company_name->GetNext();
//$company=array('company_name'=>$company_name_res['NAME']);
//$company['company_name_full']=str_replace('ООО','Общество с ограниченной ответственностью',$company['company_name']);
//while($ar_props = $db_props->Fetch()) {
//	if($ar_props['CODE']=='company_nds') $company[$ar_props['CODE']]=$ar_props['VALUE_ENUM'];
//	else $company[$ar_props['CODE']]=$ar_props['VALUE'];
//	}
/*
$ar_organizaciya = array();// массив в который запишу все данные по организации из двух запросов
$sql_org1 = CIblockElement::getlist(array(),array('IBLOCK_ID'=>39, 'ID'=> 805930),false,false,array('PROPERTY_*'));
$sql_org2 = CIBlockElement::GetByID(805930);
$ob  = $sql_org1->getnextelement(); $arFields = $ob->GetFields();
$ob2 = $sql_org2->getnextelement();
$ar_organizaciya['PROPERTY']= $arFields;
$ar_organizaciya['FIELDS']  = $ob2;

echo "<pre>";
print_r($ar_organizaciya);




die;
$sql_org=CIblockElement::GetList(array(), array('IBLOCK_ID' => 39, 'ID'=>20715), false, false, ARRAY('ID', 'PROPERTY_*'));
$organizaciya = $sql_org->GetNext();
echo "<pre>";
print_r($organizaciya);




//die;
$res = CIBlockElement::GetProperty(47,962287, array("sort" => "asc"), array());
while($res_pro = $res->getnext()){
	$arPropertyMy[$res_pro['NAME']] = $res_pro;
}
echo '<pre>'; 
print_r($arPropertyMy);

/*
$sql_zdanie = CiblockElement::GetList(array(),array('IBLOCK_ID'=>'47', 'ID'=>'962287'), false, false, false);
$res_zdanie = $sql_zdanie->fetch();
echo '<pre>'; 
print_r($res_zdanie);
*/





/*$sql_str_contact = "SELECT uts.*, c.* FROM b_uts_crm_contact as uts LEFT JOIN b_crm_contact as c ON uts.VALUE_ID = c.id WHERE uts.VALUE_ID = ". 46585;
    $res_contact = $DB->Query($sql_str_contact, false, $err_mess.__LINE__);
    $contact_hach = $res_contact->GetNext();
echo '<pre>'; 
print_r($contact_hach);

//die;
$res = CIBlockElement::GetProperty(95,962569, array("sort" => "asc"), array());
while($res_pro = $res->getnext()){
	$arPropertyMy[$res_pro['ID']] = $res_pro;
}
echo '<pre>'; 
print_r($arPropertyMy);

die;
$arFilter = Array("IBLOCK_ID"=>95, 'ACTIVE'=>'Y', 'ID'=>826780);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, ARRAY('ID', 'PROPERTY_*'));
    $ob = $res->GetNextElement();  
$arFields = $ob->GetFields(); 
echo '<pre>'; 
print_r($ob);

			*/
#################			
			CModule::IncludeModule("iblock");
$IBLOCK_ID = 47;//здания
$SEARCH_FIELD_NAME = 'SEARCH_ID';
$els = CIBlockElement::GetList(
    array("SORT"=>"ASC"),
    array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y"),
    false,
    false,
	array('ID','IBLOCK_ID','NAME', 'PROPERTY_raion', 'PROPERTY_jk')
);
while($arMy=$els->fetch())
$arMy2[$arMy['ID']]=$arMy;


 
//$jksql = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>71, 'ACTIVE'=>'Y'),false, false, array('ID','NAME',));
die;

$i=0;
while ($s = $els->Fetch()) {
	$jksql = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>71, 'ACTIVE'=>'Y'),false, false, array('ID','NAME',));//жк

	while($ar_jk = $jksql->GetNext() )
{
	if($ar_jk['NAME']==$s['PROPERTY_RAION_VALUE'])
	{
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
echo "<pre>";
print_r($arJK);
echo "</pre>";
###################
?>