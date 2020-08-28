<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require '/home/bitrix/vendor/autoload.php';

$COMPANY_IBLOCK_ID=39; // компании
$id = $_GET['element_id'];// айди элемента бп "Открытие лицевого счета" пример: 962569
$iblock_id = 95;// Бизнес процесс "Открытие лицевого счета" 
$iblock_id_shablon = 96; // Бизнес процесс "Шаблон ДУ"

if($id){ // проверка айди элемента     
    CModule::IncludeModule('iblock');
    CModule::IncludeModule('crm');
    //echo "<pre>";
    
    //Бизнес процесс "Открытие лицевого счета" 
    $select=array('CREATED_BY', 'CREATED_DATE', 'ID', 'PROPERTY_ORGANIZATSIYA', 'PROPERTY_ZDANIE', 'PROPERTY_FIZ_LITSO', 'PROPERTY_VID_POMESHCHENIYA', 'PROPERTY_NOMER_LITSEVOGO_SCHETA', 'PROPERTY_NOMER_POMESHCHENIYA', 'PROPERTY_PLOSHCHAD', 'PROPERTY_PODEZD', 'PROPERTY_DATA_OTKRYTIYA', 'PROPERTY_VID_DOKUMENTA', 'PROPERTY_DATA_VYDACHI_DOKUMENTA', 'PROPERTY_SERIYA_DOKUMENTA', 'PROPERTY_NOMER_DOKUMENTA', 'PROPERTY_KEM_VYDAN_DOKUMENT', 'PROPERTY_TELEFON', 'PROPERTY_ELEKTRONNAYA_POCHTA', 'PROPERTY_PRIKREPITE_FAYL', 'PROPERTY_DOKUMENT_DLYA_PECHATI');
    $sql_avtor = CIblockElement::getlist(array(), array('IBLOCK_ID'=>$iblock_id, 'ID'=>$id), false, false, $select);
    $res_avtor = $sql_avtor->fetch();
    //print_r($res_avtor); 
    $user_sql= CUser:: getById($res_avtor['CREATED_BY']);
    $user = $user_sql->fetch();
    
    //все о контакте, паспортные данные, фио  
    $rsUser = CcrmContact::getlist(array(), array('ID'=>$res_avtor['PROPERTY_FIZ_LITSO_VALUE'], 'CHECK_PERMISSIONS' => 'N'), array());
    $crm_contact = $rsUser->GetNext();    
    
    //через функцию из инита получаем поле "Пол" которое в типе список, 140- айди поля из таблицы b_user_field, варианты списка лежат в таблице b_user_field_enum
    $contactField = GetListProp('140');
      
    //вытаскиеваю здание  47-здания
    $res_org = CIBlockElement::GetProperty(47, $res_avtor['PROPERTY_ZDANIE_VALUE'], array("sort" => "asc"), array());
    while($adr = $res_org->getnext())
    {
        $adres[$adr['ID']] = $adr;
    }
    
   
     
    //склонение фио автора
    $fio_avtora = $user['LAST_NAME'].' '.$user['NAME'].' '.$user['SECOND_NAME'];
    require_once $_SERVER['DOCUMENT_ROOT'].'/crm/deal/Library/NCLNameCaseRu.php';// Подключаем русскую библиотеку
    $nc = new NCLNameCaseRu();
    $sklonenie_fio = $nc->q($fio_avtora);  
    //вытаскиваем все о компании:
    $ar_organizaciya = array();// массив в который запишу все данные по организации из двух запросов
    $sql_org1 = CIblockElement::getlist(array(),array('IBLOCK_ID'=>$COMPANY_IBLOCK_ID, 'ID'=>$res_avtor['PROPERTY_ORGANIZATSIYA_VALUE']),false,false,array('ID','PROPERTY_*'));
    $ob  = $sql_org1->getnext();  
    $sql_org2 = CIBlockElement::GetByID($ob['ID']);
    $ob2 = $sql_org2->getnext();
    $ar_organizaciya['PROPERTY']= $ob;
    $ar_organizaciya['FIELDS']  = $ob2;
    $company['company_name_full']=str_replace('ООО','Общество с ограниченной ответственностью',$ob2['NAME'].', именуемое в дальнейшем «Управляющая организация», в лице '.$sklonenie_fio[1].','); // Общество с ограниченной ответственностью «СК-Сервис»    
    //////////////Вытаскиваю Вид помещения, здание и шаблон, из бизнес процесса "Шаблоны ДУ"/////////////////////
    $res_org = CIblockElement::getlist(array(), array('IBLOCK_ID'=>$iblock_id_shablon, 'PROPERTY_ZDANIE'=>$res_avtor['PROPERTY_ZDANIE_VALUE'], 'PROPERTY_VID_POMESHCHENIYA'=>$res_avtor['PROPERTY_VID_POMESHCHENIYA_VALUE']),false,false,array('ID', 'PROPERTY_ZDANIE', 'PROPERTY_VID_POMESHCHENIYA', 'PROPERTY_SHABLON'));
    while($shablon = $res_org->getnext()){
        $result_shablon = $shablon;
    }
    //////////////////////////////////////////////
    //проверка вида помещения из двух БП(95 и 96)
    if($res_avtor['PROPERTY_VID_POMESHCHENIYA_VALUE'] == $result_shablon['PROPERTY_VID_POMESHCHENIYA_VALUE']){
        $dogovor_shablon = Cfile::getPath($result_shablon['PROPERTY_SHABLON_VALUE']);  // путь к файлу БП Шаблон ДУ -  /upload/iblock/f4a/шаблон_д_у.docx    
        //file_force_download($file);
    }else{
        echo 'К виду помещения не загружен шаблон';
    }
    //echo '<pre>';
    //echo $dogovor_shablon;
    //print_r($res_avtor);
    
    //echo '<hr>';
    //print_r($result_shablon);
    /*
    клиент______
    Автор:                 avtor
    Дата создания заявки:  data_begin
    ФИО:                   klient
    Дата рождения:         pasport_dr
    Серия паспорта:        pasport_seriya  
    Номер паспорта:        pasport_nomer
    Дата выдачи паспорта:  pasport_data
    Кем выдан:             pasport_kem
    Код органа:            pasport_organ
    Телефон:               telefon
    Почта:                 pochta
    Адрес:                 adres_klient
    $_GET[element_id]      element_id
    Площадь                plozhad
    Доверенность           doverennost
    Место рождения         mesto_rozdeniya
    Пол                    pol
    
    здание_______
    Улица:                 ulica
    Номер помещения:       zdanie_nomer
    
    организация________
    Название              company_name
    Физ. адрес            company_adres
    ОГРН                  company_ogrn
    ИНН                   company_inn
    КПП                   company_kpp
    Р/c                   company_rasschet
    Банк                  company_bank
    БИК                   company_bik
    к/с                   company_korschet
    */  
    
    
    //подставляю месяц 
    $date_begin = str_replace('.','-',$res_avtor['CREATED_DATE']);
    //дата создания
    $rus_months = array(1=>'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
    $newDatetime = new Datetime($date_begin);
    $month = $newDatetime->format('n');
    //$day = new DateTime ($date_begin);
    $day  = $newDatetime->format('d');
    $yers = $newDatetime->format('Y');
    $data_rus = $day.' '.$rus_months[$month].' '.$yers;
    //если поле доверенность есть(заполнено) в USER то выводим номер/значение если поле не заполнено то подчеркивания выводим в phphword  
    if($user['UF_DOV_NUMBER']!="")
        $doverennost = 'Доверенности №'.$user['UF_DOV_NUMBER'].' от '.$user['UF_DOV_DATE'];
    else
        $doverennost = "________________";
    //место рождения      
    if($crm_contact['UF_CRM_1584086882']!=""){
        $mesto_rozdeniya = $crm_contact['UF_CRM_1584086882'];
    }else{
        $mesto_rozdeniya = "____________________";
    }
    //пол контакта
    if($crm_contact['UF_CRM_1491570688']!=""){
        $pol = $contactField[$crm_contact['UF_CRM_1491570688']];
    }else{
        $pol = "___________";
    }
    
    if($dogovor_shablon)//проверка наличия шаблона файла в БП 96
    {
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER['DOCUMENT_ROOT'].$dogovor_shablon);//home/bitrix/www/bizproc/docs/du_22_10_2019.docx
    //клиентские переменные
    $templateProcessor->setValue('avtor',           $user['LAST_NAME'].' '.$user['NAME'].' '.$user['SECOND_NAME']);
    $templateProcessor->setValue('data_begin',      $data_rus); //дата договора
    $templateProcessor->setValue('klient', ' '.     $crm_contact['LAST_NAME'].' '.$crm_contact['NAME'].' '.$crm_contact['SECOND_NAME']);
    $templateProcessor->setValue('pasport_dr',      $crm_contact['UF_CRM_1522930531']);
    $templateProcessor->setValue('pasport_seriya',  $crm_contact['UF_CRM_1491570914']);
    $templateProcessor->setValue('pasport_nomer',   $crm_contact['UF_CRM_1491570629']);
    $templateProcessor->setValue('pasport_data',    $crm_contact['UF_CRM_1491570458']);
    $templateProcessor->setValue('pasport_kem',     $crm_contact['UF_CRM_1491570568']);
    $templateProcessor->setValue('pasport_organ',   $crm_contact['UF_CRM_1491570580']);
    $templateProcessor->setValue('telefon',         $res_avtor['PROPERTY_TELEFON_VALUE']);
    $templateProcessor->setValue('pochta',          $res_avtor['PROPERTY_ELEKTRONNAYA_POCHTA_VALUE']);
    $templateProcessor->setValue('adres_klient',    $crm_contact['UF_CRM_1490264375']);
    $templateProcessor->setValue('element_id',      $res_avtor['ID']);
    $templateProcessor->setValue('plozhad',         $res_avtor['PROPERTY_PLOSHCHAD_VALUE']);
    $templateProcessor->setValue('doverennost',     $doverennost);//значение переменной выше
    $templateProcessor->setValue('mesto_rozdeniya', $mesto_rozdeniya);
    $templateProcessor->setValue('pol',             $pol);
    //переменные организации
    $templateProcessor->setValue('company_name',     $ar_organizaciya['FIELDS']['NAME']);
    $templateProcessor->setValue('company_adres',    $ar_organizaciya['PROPERTY']['PROPERTY_207']);   
    $templateProcessor->setValue('company_ogrn',     $ar_organizaciya['PROPERTY']['PROPERTY_347']);
    $templateProcessor->setValue('company_inn',      $ar_organizaciya['PROPERTY']['PROPERTY_209']);
    $templateProcessor->setValue('company_kpp',      $ar_organizaciya['PROPERTY']['PROPERTY_210']);
    $templateProcessor->setValue('company_rasschet', $ar_organizaciya['PROPERTY']['PROPERTY_213']);
    $templateProcessor->setValue('company_bank',     $ar_organizaciya['PROPERTY']['PROPERTY_211']);
    $templateProcessor->setValue('company_bik',      $ar_organizaciya['PROPERTY']['PROPERTY_212']);
    $templateProcessor->setValue('company_korschet', $ar_organizaciya['PROPERTY']['PROPERTY_214']);
    //здания
    $templateProcessor->setValue('ulica',            $adres[233]['VALUE']);
    $templateProcessor->setValue('zdanie_nomer',     $res_avtor['PROPERTY_NOMER_POMESHCHENIYA_VALUE']);
    $templateProcessor->setValue('ooo',              $company['company_name_full']); //строка ооо
    
    $templateProcessor->saveAs('/home/bitrix/www/bizproc/docs/tmp/template_full.docx'); //имя заполненного шаблона для сохранения  template_full2.docx
    
    $file='/home/bitrix/www/bizproc/docs/tmp/template_full.docx';
    }//if
}//if($id)   




file_force_download($file);

function file_force_download($file) {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    unlink($file);
    exit;
  }
}


//require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
?>