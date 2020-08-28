<?php 

class ReportSender { 
    public $periods=array(1=>'День',7=>'Неделя',30=>'Месяц',360=>'Год');
    public $types=array(
		1=>'Продажи менеджеров',
		2=>'Специальности',
		3=>'Специальности 2.0',
		4=>'Отчет по технадзору',
		5=>'Служба сервиса NE', 
		6=>'Исполнители: выполненные заявки', 
		7=>'Исполнители КС - выплаты', 
		8=>'Отчёт по контролю качества' , 
		9=>'Количество заявок по районам/домам',
		10=>'Отчёт по оценкам',
		11=>'Пустые лицевые счета',
		12=>'Отчёт по исполнителям',
		13=>'Общий вечерний отчёт',
		14=>'Сводный отчёт по работе СЭ',
		15=>'Отчёт по специалистам ТЗ',
		16=>'Сводный отчёт СЭ по услугам',
		17=>'Общий отчёт по обращениям',
		18=>'Типология обращений',
		19=>'Контроль качества обращений',
		20=>'Распределение заявок ЕДС по времени',
		21=>'Типы технических заявок'
	);
    
	public function getAccess() {
		global $DB;
		/* Ищем права пользователей */
		$strSql = "SELECT * FROM b_report_items_access ORDER BY user_id,id";
		$res = $DB->Query($strSql, false, $err_mess.__LINE__);
		$result=array();
		while($access_fl=$res->Fetch()) {
			if($access_fl['user_id']) {
				$rsUser = CUser::GetByID($access_fl['user_id']);
				$user_tmp=$rsUser->Fetch();
				$result[$access_fl['user_id']]['user']=$access_fl;
				$result[$access_fl['user_id']]['user']['name']=$user_tmp['LAST_NAME'].' '.$user_tmp['NAME'].' '.$user_tmp['SECOND_NAME'];
				
				if($result[$access_fl['user_id']]['user']['reports']) $result[$access_fl['user_id']]['user']['reports']=implode(',',unserialize($result[$access_fl['user_id']]['user']['reports']));
				else $result[$access_fl['user_id']]['user']['reports']=array();
				
				if($access_fl['depart']) {
					$rsUser = CIBlockSection::GetByID($access_fl['depart']);
					$user_tmp=$rsUser->Fetch();
					$result[$access_fl['user_id']]['user']['depart']=$user_tmp['NAME'];
				}
			}
			else {
				$rsSection = CIBlockSection::GetByID($access_fl['section_id']);
				$section_tmp=$rsSection->Fetch();
				$result[$access_fl['section_id']]['section']=$access_fl;
				$result[$access_fl['section_id']]['section']['name']=$section_tmp['NAME'];
				$result[$access_fl['section_id']]['section']['reports']=implode(',',unserialize($result[$access_fl['section_id']]['section']['reports']));
				
				if($access_fl['depart']) {
					$rsSection = CIBlockSection::GetByID($access_fl['depart']);
					$section_tmp=$rsSection->Fetch();
					$result[$access_fl['section_id']]['section']['depart']=$section_tmp['NAME'];
				}
			}
		}
		return $result;
	}
	public function GetCountUserByDeal($deal_id,$param) {
		global $DB;
		$strSql = "SELECT ".$param." as user FROM b_uts_crm_deal WHERE VALUE_ID='".$deal_id."'";
		$res = $DB->Query($strSql, false, $err_mess.__LINE__);
		$dResult=$res->Fetch();
		$users=unserialize($dResult['user']);
		
		return count($users);
	}

	public function GetNextAgentDate($period,$day) {
		$result='';
		$h_to_send='01';
		$d = new DateTime();
		switch($period) {
			case 1:
				if(date('G')>=9) $d->add(new DateInterval('P1D'));
				$result=$d->format('d.m.Y '.$h_to_send.':00:00');
				break;
			case 7:
				if($day>7) $day=7;
				$minus_day=6+date('N');
				$d->sub(new DateInterval('P'.$minus_day.'D'));
				$d->add(new DateInterval('P6D'));
				$d->add(new DateInterval('P'.($day+7).'D'));

				$result=$d->format('d.m.Y '.$h_to_send.':00:00');
				break;
			case 30:
				if($day<10) $day='0'.$day;
				elseif($day>$d->format('t')) $day=$d->format('t');

				$result=$d->format($day.'.m.Y '.$h_to_send.':00:00');
				break;
			case 360:
				if($day<10) $day='0'.$day;
				elseif($day>$d->format('t')) $day=$d->format('t');

				$result=$d->format($day.'.01.Y '.$h_to_send.':00:00');
				break;
		}
		return $result;
	}
	
	public function GetReportTable($type_id) {
		global $DB;
		$result='<table cellspacing="0" cellpadding="0" class="report-table">';
		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/uni/report.sender/reports/report".$type_id.".php");
		$result.='</table>';
		
		return $result;
	}
	
	// получаем список пользователей
	// show=0(Иванов Иван Иванович), 1(Иванов И.И.)
	public function GetUserName($show=0) {
		$result=array();
		$filter = Array("LAST_NAME" => "_%");
		$rsUsers = CUser::GetList(($by="ID"), ($order="ASC"), $filter, array('FIELDS'=>array('ID','NAME','LAST_NAME','SECOND_NAME'))); // выбираем пользователей
		
		while($wtemp = $rsUsers->Fetch()) {
			$fio=array();
			if($wtemp['LAST_NAME']) $fio[]=$wtemp['LAST_NAME'];
			if($wtemp['NAME']) {
				if($show==1) $fio[]=substr($wtemp['NAME'],0,1).'.';
				else $fio[]=$wtemp['NAME'];
			}
			if($wtemp['SECOND_NAME']) {
				if($show==1)  $fio[]=substr($wtemp['SECOND_NAME'],0,1).'.';
				else $fio[]=$wtemp['SECOND_NAME'];
			}
			
			$result[$wtemp['ID']]=implode(' ',$fio);
			if($show==1) $result[$wtemp['ID']]=str_replace('. ','.',$result[$wtemp['ID']]);
		}
		return $result;
	}
} 

?> 