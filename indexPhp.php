<?
/*$user_id = $modx->getLoginUserID();
if($user_id == "2222" || $user_id == "5312" || $user_id == "1676" ){*/

if($_POST){
	$data = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1", date('Y-m-d'));
	$sql = "SELECT order_id, status, delivery_date, id, inner_n, id FROM ORDER WHERE delivery = '".$data."' AND id = '".$_POST['id']."' AND status = 'доставляется'";
	$q=$modx->db->query($sql);
	while($row=mysql_fetch_assoc($q)){
		$rows[]=$row;
	}
}else{
	echo "Не выбран курьер!";  
}

if ($rows){
	foreach($rows as $k => $v){
		$sql2 = "UPDATE ORDER SET status = 'nа складе' WHERE order = '".$v['order_id']."' LIMIT 1";
		$modx->db->query($sql2);
		$sql22 = "insert into logs (o_id, what, new_val) values ('".$v['order_id']."',  'Статус', 'вернул на склад')";
		$modx->db->query($sql22);
	}
}

$table= '<table class="table table-bordered table-condensed" border="2">
<thead><tr><th>#</th>
<th class=thtablem>Номер заказа</th>
<th class="thtablem">Дата доставки</th>
<th class="thtablem">Статус</th>
<th class="thtablem">Курьер</th>
</tr></thead><tbody>';
#print_r($rows);

$data = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1", date('Y-m-d'));
$sql3 = "SELECT order_id, status, delivery_date, courier_id, inner_n, id FROM ORDERS WHERE delivery_date = '".$data."' AND courier_id = '".$_POST['id']."' AND status = 'На складе'";
$q3=$modx->db->query($sql3);
while($row2=mysql_fetch_assoc($q3)){
	$rows2[]=$row2;
}
if ($rows2 != ""){
	$i = 0;
	foreach($rows2 as $k => $v){
		$i++;
		$table .= '<tr>
		<td>'.$i.'</td>
		<td>'.$v['order_id'].'<br /></td>
		<td >'.$v['delivery_date'].'</td>
		<td><strong>'.$v['status'].'</strong></td>
		<td>'.$v['courier_id'].'</td>
		</tr><div></div>';
	}
	echo $table;
}else{
	echo "<span  style='color:#FF0000'>Доступ ограничен</span>";
	die;
}
?>

<?php
#print_r($_POST);
if (!$_POST['date1']) {
	return 'выберите дату';
}

$enddata = DateTime::createFromFormat('d.m.Y', $_POST['date1'])->format('Y-m-d');
//$data = " AND date2 BETWEEN '2015-01-05' AND '$enddata'";

$com="";
if ($_POST['parent_company']) {
	$com .= "AND parent_company = '".$_POST['parent_company']."'";
} 
$np_date="";
if ($_POST['np_date']) {
	$np_date = " AND c.vi4et = '".$_POST['np_date']."'";
}

$sql_2 = "SELECT bb.vi4et, bb.is_off, bb.name, SUM(bb.itog_ks) AS suma, 
SUM(bb.debt_acted) AS debt_acted, SUM(bb.debt_late) AS debt_late 
FROM(
SELECT c.vi4et, c.is_off, p.name, b.itog_ks, c.pay_date AS pd,DATE_ADD( date(b.date2), INTERVAL CONVERT(c.pay_date, char)+3 DAY) ASdebt_date, IF(ba.b_act_id IS NOT NULL, b.itog_ks, 0) AS debt_acte,IF(DATE_ADD( ba.date, INTERVAL (CONVERT(c.pay_date, char)+3) DAY) <= date('$enddata'), IF(ba.b_act_id IS NOT NULL, b.itog_ks, 0), 0) AS debt_late FROM BILL b LEFT JOIN BILL_ACT ba ON b.act_id = ba.b_act_id LEFT JOIN CLIENTS c ON b.client_id = c.client_id LEFT JOIN parent_compan	y as p ON c.parent_company = p.id WHERE (b.check_status = 'Счет не оплачен'  AND b.vi4et_status_date IS NULL) AND c.client_id NOT IN (2, 238, 1356, 65, 274) AND c.active = '1' AND date2 BETWEEN '2015-01-05' AND '$enddata'$com $np_date)bb 
GROUP BY bb.client_id";

$q2 = $modx->db->query($sql_2);

while ($row2 = mysql_fetch_assoc($q2)) {
	$tet[] = $row2;
}
$i = 1;

foreach ($tet as $k => $v) {
	if ($v['vi4et'] == "0") {
		$type2 = "Оплата за вычетом";
	} elseif ($v['vi4et'] == "1") {
		$type2 = "Оплата 100%";
	} elseif ($v['vi4et'] == "2") {
		$type2 = "Оплата без вычета без НП";
	} else {
		$type2 = "Нет данных";
	}

	if ($v['suma'] != '0.00') {
		$list .= "<tr>
		<td>" . $i . "</td>
		<td>" . $v['name'] . "</td>
		<td>Договор №".$v['cli_ag_dog']." от ".$v['cli_ag_dog_date']."</td>
		<td><span style='width:20px;'>" . $type2 . "</span></td>
		<td>" . number_format($v['suma'], 2, '.', '&nbsp;') . "</td>
		<td>" . number_format($v['debt_late'], 2, '.', '&nbsp;') . "</td><td>";

		// показываем чекбокс для оповещения клиентов о просрочке, только для тех у кого она ненулевая
		if ($v['debt_late']>0) {
			$list.="<input type=checkbox name='client_id[]' id='client_id[]' class=chk value='".$v['client_id']."' >";
		}
		$list.=  "</td></tr>";
	}#if
	$i++;
	$summaitogo += $v['suma'];
}#foreach

$list .= "<tr>
<td colspan='8'><strong>Итого</strong></td>
<td style='width:60px;'><strong>" . number_format($summaitogo, 2, '.', '&nbsp;') . "</strong></td>
<td><strong>" . number_format($itogsummadz, 2, '.', '&nbsp;') . "</strong></td>  
<td><strong>" . number_format($itogsummaprosrochka, 2, '.', '&nbsp;') . "</strong></td>  
<td></td>
</tr>";
echo $list;
?>



<!-- HTML -->
<div class="form-inline col-md-10 col-xs-12">
<span>Выберите дату: </span>
<div class="input-daterange input-group control-group form-group " id="datepicker">

<input type="text" class="form-control ddate" name="data" id="data" />
</div>
<div class="form-group">
<a href="#" class="btn btn-primary" onclick="show();" id="open" >Показать</a>
<select class="form-control ddate" id="status" name="status" onchange="show();">
<option value="0">Статус</option>
<option value="5">Доставлена</option>
<option value="4">На доставке</option>
<option value="8">Отмена</option>
</select>
</div>

<div class="row">
<div class="col-md-12 col-xs-12" id="result"></div>
</div>

<script>
function show(){
	var data = $('.ddate').serialize();
	$.ajax({
	type: "POST",
	url: "/[~115~]",
	data: data,
	success: function(msg){
	$('#result').html(msg);
	}
	});    
}

$(document).ready(function(){
	$('.input-daterange').datepicker({
	format: "dd.mm.yyyy",
	language: "ru"
	});
});
</script>
<!-- HTML -->


<?php
//var_dump($_POST);
if ($_POST['data'] == ""){
return ':(';
}

//var_dump($_POST['status']);
if ($_POST['status'] != 0){
	if ($_POST['status'] == 4){
		$where .= " AND o.status = 'На доставке'";
	}
	elseif($_POST['status'] == 5){
		$where .= " AND o.status IN (5)";
	}
	elseif($_POST['status'] == 8){
		$where .= " AND o.status IN (8)";
	}else{
		$where = "";
	}
}

$data = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1",$_POST['data']);
$sql = "SELECT o.inner_n, o.order_id, o.shk, o.courier_id, o.status, o.delivery_date, o.id, c.cr_fullname FROM ORDERS as o
LEFT JOIN COURIERS as c ON o.courier_id = c.id WHERE o.delivery_date = '".$data."' 
AND (client_id = '215' OR client_id = '1489') AND (o.brand = 'ПАО' OR o.brand = 'КАРТАНАДОМ') ".$where."";

//die;
$sql2 = $modx->db->query($sql);
while($row=mysql_fetch_assoc($sql2)){
$kmd[]=$row;
}
//var_dump($kmd[0]['cr_fullname']);
$table= '<br /><table class="table table-bordered table-condensed" border="2">
<thead><tr><th>#</th>
<th class=thtablem>Номер заказа</th><th>Статус</th>
<th class="thtablem">Дата доставки</th>
<th class="thtablem">shk</th>
<th class=thtablem>ID</th>
</tr></thead><tbody>';

$i = 0;
if($kmd != ""){
	foreach($kmd as $k => $v){
		$i++;
		$table .= '<tr>
		<td>'.$i.'</td>
		<td><a href="#myModal" role="button" class="pvw" onclick="view('.$v['id'].')" data-toggle="modal">'.$v['order_id'].'</a>
		<br /><small>'.$v['inner_n'].'
		</small></td>
		<td >'.$v['status'].'</td>
		<td>'.$v['delivery_date'].'</td>
		<td>'.$v['shk'].'</td>
		<td>'.$v['cr_fullname'].'</td>
		<td>'.$v['courier_id'].'</td>
		</tr>
		<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"></div>
		';
	}
	echo $table;
}else{
	echo "<br />Нет заказов на указанную дату.";
}?>



<?
if($_POST){	
	$postData = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1",$_POST['date']);	
	$sql="SELECT w.*, m.fullname, COUNT(status) as cnt FROM warehouse as w  
	LEFT JOIN modx_web_user_attributes as m ON w.who = m.internalKey WHERE w.`date` = '".$postData."' AND status IN (3) GROUP BY who";
	$q=$modx->db->query($sql); 
	while($row=mysql_fetch_assoc($q)){
		$rows[]=$row;
	}
	if($rows != ""){
		foreach($rows as $k => $v){
			$list .= "<tr>
			<td>".$v['fullname']." [ ".$v['id']." ]</td>
			<td>".$v['cnt']."</td>
			<td></td></tr>";
		}
		echo $list;
	}#if2
}#if1



if($_POST){	
	$postData = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1",$_POST['date']);	
	$sql="SELECT w.*, m.fullname, COUNT(status) as cnt FROM warehouse_issue as w  
	LEFT JOIN modx_web_user_attributes as m
	ON w.who = m.internalKey
	WHERE w.`date` = '".$postData."' AND status IN (3) GROUP BY who ";
	$q=$modx->db->query($sql);
	$c=0;

	$sql2 = "SELECT  COUNT(o.order_id) as zakazi
	FROM warehouse_issue as w LEFT JOIN ORDERS as o ON  (o.courier_id =  w.cr_id AND o.delivery_date = w.date)
	WHERE  w.date = '".$postData."' AND w.status IN (3) GROUP BY w.who";
	$q2=$modx->db->query($sql2);
	$i=0;
	while($array = mysql_fetch_assoc($q2)){
		$rows2[]=$array; 
	}
	while($row=mysql_fetch_assoc($q)){
		$rows[$i]=$row;
		$rows[$i][$i] = $rows2[$i]; 
		$i++;
	}
	if($rows){
		$sch=0;	
		foreach($rows as $k => $v)
		{
			$list .= "<tr>
			<td>".$v['fullname']."</td>
			<td>".$v['cnt']."</td>
			<td>".$v[$sch]['zakazi']."</td>
			</tr>";
			$sch++;
		}
		echo $list;
	}#if
}#if
?>


<?php
print_r($_POST);
$pdata=$_POST;
//print_r($pdata);
$curdate = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1",$pdata['delivery_date']);
$startdate = date('Y-m-d',strtotime($curdate . "-12 month"));
print_r($startdate);
if($pdata['parent_company'] != '' ){
	$where .= " AND c.parent_company = '".$pdata['parent_company']."' ";
}
if($pdata['delivery_date']){
	$where .= " AND b.date2 BETWEEN '".$startdate."' AND '".$curdate."'";
}

$sql = "select b.client_id, b.b_id, b.date2, b.check_status+0 as c_status, c.parent_company, 
b.itog_cli, b.itog_ks, b.itog_im, c.client_name, c.is_off, c.vi4et,b.b_type, b.b_type+0 as typeoff 
from BILLS as b LEFT JOIN CLIENTS as c ON b.client_id = c.client_id 
WHERE b.client_id NOT IN (238, 2, 274, 65, 1356) ".$where."
AND ((c.vi4et = '0' && b.vi4et_status IN (1)) || (c.vi4et != '0' && b.np_status IN (1) && b.itog_cli != '0.00')) 
order by b.client_id, b.date2";
//echo $sql;
$q=$modx->db->query($sql);
while($row=mysql_fetch_assoc($q)){
	$rows[]=$row;
}
//var_dump($rows);

if ($rows == "")
	echo "<tr><td colspan=6><div class='alert alert-success'>По данному клиенту отчёты не формировались</div></td></tr>";

if($bnal != ''){ 
	foreach ($bnal as $key => $val) {
		foreach ($val as $k => $v) {
			if ($v['vi4et'] == '0') {
				if ($v['itog_im'] < '0' && $v['c_status'] == '2') {
				} else {
					$summ[$key] += $v['itog_im'];
					$str[$key] .= ' ' . $v['b_id'];
				}
			} else {
				$summ[$key] += $v['itog_cli'];
				$str[$key] .= ' ' . $v['b_id'];
			}
			$client = $v['client_name'];
			$client_id = $v['client_id'];
		}
		if($summ[$key] > '0'){	
		$table .= '<tr><td>LS'.$client_id.' / <b>' . $client . '</b></td><td>' . $str[$key] . '</td><td align=right>' . number_format($summ[$key], 2, '.', ' ') . '</td> </tr>';
		//$bnalsumm += $summ[$key];	
		}
		//if($summ[$key]){
		$bnalsumm += $summ[$key];	
		//}
	}#foreach

	$table .= '<tr style="border-bottom:2px solid black;"><td colspan =2 align=center>БЕЗ НАЛ</td><td align=right style="border:3px solid black;"><b>' . number_format($bnalsumm, 2, '.', ' ') . '</b></td></tr>';
}#if
echo $table;
?>

<!-- HTML -->
<div class="form-inline col-md-10 col-xs-12">
<span><strong>Выберите:</strong> </span>
<div class="form-group">  
<select class="form-control cour" id="id" name="id" onchange="kurier();">
[!gcr!]  
</select>
</div>

<div class="row">
	<div class="col-md-12 col-xs-12" id="result"></div>
</div>

<div class="form-inline col-md-12 col-xs-12">
	<div class="form-group">
		<a href="#" class="btn btn-danger btn-lg" onclick="kurier2();" id="open2">Вернуть на склад</a>        
	</div>
</div>

<script>
	function kurier(){
		var data = $('.cour').serialize();
		$.ajax({
		type: "POST",
		url: "/[~1220~]",
		data: data,
		success: function(msg){
		$('#result').html(msg);
		}
		});    
	}

	function kurier2(){
		var data = $('.cour').serialize();
		$.ajax({
		type: "POST",
		url: "/[~1221~]",
		data: data,
		success: function(msg){
		$('#result').html(msg);
		}
		});    
	}
</script>
<!-- HTML -->

<?
/*подключение к опенсервер
$db_host = 'localhost';
$db_user = 'root'; // логин
$db_password = ''; // пароль
$db_name = 'test4'; // имя базы данных
$link = mysqli_connect($db_host,$db_user,$db_password,$db_name);
$res = mysqli_query($link,"INSERT INTO usernames (text) VALUES ('".$_POST['text']."')")
or die("ERROR: ".mysqli_error($link));*/
?>