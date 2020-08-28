<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
if(count($arResult['PROPERTIES']['HOUSES']['VALUE'])){
    $arSelect = Array("ID", "NAME", "PROPERTY_ADRESS");
	$arFilter = Array("IBLOCK_ID"=>10, "ID"=>$arResult['PROPERTIES']['HOUSES']['VALUE']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->fetch()) {
		$arResult['HOUSES'][] = $ob['PROPERTY_ADRESS_VALUE'].', '.$ob['NAME'];
	}
}
//print_r($arResult['HOUSES']);
?>