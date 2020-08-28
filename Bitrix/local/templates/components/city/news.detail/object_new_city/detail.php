<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule("iblock");
$APPLICATION->AddChainItem("ooo", "/");
$APPLICATION->AddChainItem("Объекты", "/realty/");

$arFilter = Array('IBLOCK_ID'=>8, "CODE"=>$_REQUEST['SECTION_CODE']);
$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
if($ar_result = $db_list->GetNext()){
    $APPLICATION->SetTitle($ar_result['NAME']); 
}

?>
<div class="pad-t-30">
      <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","breadcrumb",Array(
              "START_FROM" => "1", 
              "PATH" => "", 
          )
      );?>
</div>
<? if($_GET['a']==1){$objects='object_new_city';}else{$objects = 'objects';}?>
<div class="section pad-t-30">   
    <?$APPLICATION->IncludeComponent("bitrix:news.detail","object",Array(
            "CODE" => $ar_result['CODE'],
            "CATEGORY_NAME" => $ar_result['NAME'],
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "USE_SHARE" => "Y",
            "SHARE_HIDE" => "N",
            "SHARE_TEMPLATE" => "",
            "SHARE_HANDLERS" => array("delicious"),
            "SHARE_SHORTEN_URL_LOGIN" => "",
            "SHARE_SHORTEN_URL_KEY" => "",
            "AJAX_MODE" => "Y",
            "IBLOCK_TYPE" => "realty",
            "IBLOCK_ID" => "44",
            "ELEMENT_ID" => $_REQUEST["ELEMENT_CODE"],
            "ELEMENT_CODE" => "",
            "CHECK_DATES" => "Y",
            "FIELD_CODE" => Array("ID"),
            "PROPERTY_CODE" => Array("DESCRIPTION"),
            "IBLOCK_URL" => "news.php?ID=#IBLOCK_ID#\"",
            "DETAIL_URL" => "",
            "SET_TITLE" => "Y",
            "SET_CANONICAL_URL" => "Y",
            "SET_BROWSER_TITLE" => "Y",
            "BROWSER_TITLE" => "-",
            "SET_META_KEYWORDS" => "Y",
            "META_KEYWORDS" => "-",
            "SET_META_DESCRIPTION" => "Y",
            "META_DESCRIPTION" => "-",
            "SET_STATUS_404" => "Y",
            "SET_LAST_MODIFIED" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "ADD_ELEMENT_CHAIN" => "N",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "USE_PERMISSIONS" => "N",
            "GROUP_PERMISSIONS" => Array("1"),
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "Y",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Страница",
            "PAGER_TEMPLATE" => "",
            "PAGER_SHOW_ALL" => "Y",
            "PAGER_BASE_LINK_ENABLE" => "Y",
            "SHOW_404" => "Y",
            "MESSAGE_404" => "",
            "STRICT_SECTION_CHECK" => "Y",
            "PAGER_BASE_LINK" => "",
            "PAGER_PARAMS_NAME" => "arrPager",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N"
        )
    );?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>