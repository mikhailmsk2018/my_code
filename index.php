
<div class="form-inline col-md-10 col-xs-12">
  <span><strong>Выберите курьера:</strong> </span>
  
    <div class="form-group">  
            <select class="form-control hui" id="id" name="id" onchange="kurier();">
            [!gcr!]  
            </select>
    </div>
  
  

<div class="row">
  <div class="col-md-12 col-xs-12" id="result"></div>
</div>
  
<div class="form-inline col-md-12 col-xs-12">
    <div class="form-group">
    <a href="#" class="btn btn-danger btn-lg" onclick="kurier2();" id="open2">Вернуть заказы на склад</a>        
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




<?php
//$user_id = $modx->getLoginUserID();
//if($id == "2222" || $id == "2641" || $id == "2656" || $id == "2657" || $id == "3" || $user_id == "1283"){
  
    if($_POST != "")
    {
      $data = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1", date('Y-m-d'));
      $sql = "SELECT order_id, status, delivery_date, courier_id, inner_n, id FROM ORDERS WHERE delivery_date = '".$data."' AND courier_id = '".$_POST['id']."' AND status = 'На доставке'";
      $q=$modx->db->query($sql);
        while($row=mysql_fetch_assoc($q)){
          $rows[]=$row;
        }
    }else{
    echo "Не выбран курьер!";  
    }
    if ($rows != "")
    {
      foreach($rows as $k => $v)
      {
      $sql2 = "UPDATE ORDERS SET status = 'На складе' WHERE order_id = '".$v['order_id']."' LIMIT 1";
      $modx->db->query($sql2);
      $sql22 = "insert into logs (o_id, what, new_val) values ('".$v['order_id']."',  'Статус', 'Логист вернул на склад')";
      $modx->db->query($sql22);
      }
    }
    
    
    
    
    $table= '<table class="table table-bordered table-condensed" border="2">
            <thead>
            <tr>
              <th>#</th>
              <th class=thtablem>Номер заказа</th>
              <th class="thtablem">Дата доставки</th>
              <th class="thtablem">Статус</th>
              <th class="thtablem">Курьер</th>
            </tr>
            </thead>
          <tbody>';
    
    //print_r($rows);
    
    
    $data = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1", date('Y-m-d'));
    $sql3 = "SELECT order_id, status, delivery_date, courier_id, inner_n, id FROM ORDERS WHERE delivery_date = '".$data."' AND courier_id = '".$_POST['id']."' AND status = 'На складе'";
    $q3=$modx->db->query($sql3);
      while($row2=mysql_fetch_assoc($q3)){
        $rows2[]=$row2;
      }
    if ($rows2 != "")
    {
      $i = 0;
        foreach($rows2 as $k => $v)
        {
          $i++;
                $table .= '<tr>
                <td>'.$i.'</td>
                <td>'.$v['order_id'].'
                <br />
                </td>
                <td >'.$v['delivery_date'].'</td>
                <td><strong>'.$v['status'].'</strong></td>
                <td>'.$v['courier_id'].'</td>
                </tr>
                <div></div>
                ';
        }
    
    echo $table;
    }
    else
    {
      echo "<br /><br /><strong>Нет заказов</strong></div>";
    }
  
}
else
{
  echo "<span  style='color:#FF0000'>Доступ ограничен</span>";
die;
}

?>



<?php
//print_r($_POST);


if($_POST['text'] == '' ){
	$where .= "<strong>Ввведите текст сообщения!</strong>";
}else{
	$where .= "Ваша заявка принята";
}


echo $where;
//подключался к опенсервер
$db_host = 'localhost';
$db_user = 'root'; // логин
$db_password = ''; // пароль
$db_name = 'test4'; // имя базы данных
$link = mysqli_connect($db_host,$db_user,$db_password,$db_name);
$res = mysqli_query($link,"INSERT INTO usernames (text) VALUES ('".$_POST['text']."')")
or die("ERROR: ".mysqli_error($link));	
?>



<html>
<head>
    <title>Второе задание</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
	<link rel="stylesheet" href="css/bootstrap.css" >
	
	
</head>
    <body>
	<div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Два выпадающих списка</div>     
                    </div>     
                    <div style="padding-top:30px" class="panel-body" >
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
						
						
						

<form class="form-inline" method="GET" id="MyForm"   action="get.php">
	<div class="form-group">			
		<select  class="form-control color" name="color"  id="color" onchange="show();">
				<option value="">Выбирите:</option>
				<option value="1">Черный</option>
				<option value="2">Белый</option>
				<option value="3">Красный</option>
		</select>
	</div>

<hr><br />

	<div class="form-group">
		<select class="form-control color" name="color2" onchange="show();" name="color2" id="color2">
				<option value="">Выбирите:</option>
				<option value="1">Мужские</option>
				<option value="2">Женские</option>
				<option value="3">Детские</option>
		</select>
	</div>
</form>
	</div>	
	</div>
	</div>
	</div>
	</div>


<div class="row">
	<div style="padding-left:230px" id="result"></div>
</div>
	           
		
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>     
	<script src="js/bootstrap.min.js"></script>	
<script type="text/javascript">
	
	function show(){
		var data = $('#MyForm').serialize();
		var data1 = $('#color').serialize();
		var data2 = $('#color2').serialize();
		document.getElementById('MyForm');
		$.ajax({
			type: "GET",
			url: "get.php",
			data: data,
			success: function(msg){
				document.getElementById('MyForm');
				$('#result').html(msg);
			}
		});		
	}
	
</script>
		

    </body>
</html>




<?php
//print_r($_GET);

if($_GET['color']!="" && $_GET['color2']!="")
{
	$val = "<b>Можно выбрать лишь один список! </b>";
}
else{
	if($_GET['color'] == 1){
		$val .= "<b>Выбран цвет: Черный </b>";
	}elseif($_GET['color'] == '2'){
		$val .= "<b>Выбран цвет:  Белый </b>";
	}elseif($_GET['color'] == 3){
		$val .= '<b>Выбран цвет:  Красный </b>';
	}else{
	$val = "";
	}

	if($_GET['color2'] == 1){
		$val .= " <b>Для кого: мужские</b>";
	}elseif($_GET['color2'] == '2'){
		$val .= " <b>Для кого:  женские</b>";
	}elseif($_GET['color2'] == 3){
		$val .= '<b>Для кого:  детские</b>';
	}else{
	$val .= "";
	}
}

echo $val ;
?>



	

<?php
#print_r($_POST);
 SELECT o.order_id, cli.client_id, cli.manager_id, cli.client_name, mu.fullname,  o.delivery_date
FROM  CLIENTS as cli 
LEFT JOIN  ORDERS as o ON cli.client_id = o.client_id
LEFT JOIN modx_web_user_attributes as mu  ON mu.internalKey = cli.manager_id
WHERE
 (cli.manager_id = '1421' OR cli.manager_id = '1424' OR cli.manager_id = '949')
AND o.client_id = '".$v['client_id']."'
ORDER BY o.order_id
LIMIT 1 
  
  
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


/*
$data = " AND date2 BETWEEN '2015-01-05' AND '" . preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/", "\\3-\\2-\\1", $_POST['date1']) . "'";
if ($_POST['parent_company'] == '1') {
    $com = " AND parent_company = '1'";
} elseif ($_POST['parent_company'] == '2') {
    $com = " AND parent_company = '2'";
} elseif ($_POST['parent_company'] == '4') {
    $com = " AND parent_company = '4'";
} else {
    $com = "";
}

if ($_POST['np_date'] == '0') {
    $np_date = " AND c.vi4et = '0'";
} elseif ($_POST['np_date'] == '1') {
    $np_date = " AND c.vi4et = '1'";
} elseif ($_POST['np_date'] == '2') {
    $np_date = " AND c.vi4et = '2'";
} else {
    $np_date = "";
}*/

$sql_2 = "
SELECT 
  bb.vi4et, 
  bb.is_off, 
  bb.name, 
  bb.req_inn, 
  bb.req_kpp, 
  bb.client_name, 
  bb.cli_ag_dog, 
  bb.cli_ag_dog_date, 
  bb.client_name_full, 
  bb.client_id, 
  SUM(bb.itog_ks) AS summmmmma, 
  SUM(bb.debt_acted) AS debt_acted, 
  SUM(bb.debt_late) AS debt_late 
FROM (
   SELECT 
     c.vi4et, 
     c.is_off, 
     p.name, 
     c.req_inn, 
     c.req_kpp, 
     c.client_name, 
     c.cli_ag_dog, 
     c.cli_ag_dog_date, 
     c.client_name_full, 
     b.id AS bid, 
     ba.id AS baid, 
     b.client_id, 
     b.date2, 
     ba.date, 
     b.itog_ks, 
     c.pay_date AS pd, 
      DATE_ADD( date(b.date2), INTERVAL CONVERT(c.pay_date, char)+3 DAY) AS debt_date,
      
      IF(ba.b_act_id IS NOT NULL, b.itog_ks, 0) AS debt_acted, 

      IF(DATE_ADD( ba.date, INTERVAL (CONVERT(c.pay_date, char)+3) DAY) <= date('$enddata'), IF(ba.b_act_id IS NOT NULL, b.itog_ks, 0), 0) AS debt_late

      FROM BILLS b  
      LEFT JOIN BILL_ACT ba ON b.act_id = ba.b_act_id
      LEFT JOIN CLIENTS c ON b.client_id = c.client_id
      LEFT JOIN parent_company as p ON c.parent_company = p.id
      WHERE 
        (
          b.check_status = 'Счет не оплачен'  
          AND b.vi4et_status_date IS NULL
        ) 
      AND c.client_id NOT IN (2, 238, 1356, 65, 274)
      AND c.active = '1' 
      AND date2 BETWEEN '2015-01-05' AND '$enddata'
      $com $np_date
    ) bb 
  GROUP BY bb.client_id
";

//echo $sql_2;
$q2 = $modx->db->query($sql_2);
$c = 0;
while ($row2 = mysql_fetch_assoc($q2)) {
    $tetka[] = $row2;
    $c++;
}
$i = 1;

foreach ($tetka as $k => $v) {
    if ($v['vi4et'] == "0") {
        $type2 = "Оплата за вычетом";
    } elseif ($v['vi4et'] == "1") {
        $type2 = "Оплата 100%";
    } elseif ($v['vi4et'] == "2") {
        $type2 = "Оплата без вычета без НП";
    } else {
        $type2 = "Нет данных";
    }


    if ($v['summmmmma'] != '0.00') {
    	$list .= "<tr>
              <td style='width:5px;'>" . $i . "</td>
              <td style='width:40px !important;'>" . $v['name'] . "</td>
              <td style='width:50px;'>" . $v['client_name_full'] . "</td>
              <th style='width:40px !important;'>" . $v['req_inn'] . "</td>
              <td style='width:20px !important;'>" . $v['client_id'] . "</td>
              <td style='width:30px;'>" . $v['client_name'] . "</td>
              <td style='width:40px;'>Договор № " . $v['cli_ag_dog'] . " от " . $v['cli_ag_dog_date'] . "</td>
              
              <td style='width:20px;'><span style='width:20px;'>" . $type2 . "</span></td>
              <td style='width:70px;'>" . number_format($v['summmmmma'], 2, '.', '&nbsp;') . "</td>
              <td style='width:70px;'>" . number_format($v['debt_acted'], 2, '.', '&nbsp;') . "</td>
              <td style='width:70px;'>" . number_format($v['debt_late'], 2, '.', '&nbsp;') . "</td><td>";
    
              // показываем чекбокс для оповещения клиентов о просрочке, только для тех у кого она ненулевая
              if ($v['debt_late']>0) {
                $list.="<input type=checkbox name='client_id[]' id='client_id[]' class=chk value='".$v['client_id']."' >";
              }
              $list.=  "</td></tr>";
              
          
        $i++;
    }

    $summaitogo += $v['summmmmma'];
    $itogsummadz += $v['debt_acted'];
    $itogsummaprosrochka += $v['debt_late'];
}


$list .= "<tr>
          <td colspan='8'><strong>Итого</strong></td>
          <td style='width:60px;'><strong>" . number_format($summaitogo, 2, '.', '&nbsp;') . "</strong></td>
          <td><strong>" . number_format($itogsummadz, 2, '.', '&nbsp;') . "</strong></td>  
          <td><strong>" . number_format($itogsummaprosrochka, 2, '.', '&nbsp;') . "</strong></td>  
          <td></td>
    </tr>";
echo $list;
?>




<div class="form-inline col-md-10 col-xs-12">
  <span>Выберите дату: </span>
  <div class="input-daterange input-group control-group form-group " id="datepicker">
      
      <input type="text" class="form-control ddate" name="data" id="data" />
    </div>
    <div class="form-group">
      <a href="#" class="btn btn-primary" onclick="showthisshit();" id="open" >Показать</a>
  <select class="form-control ddate" id="status" name="status" onchange="showthisshit();">
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
    
  
  
  function showthisshit(){
    var data = $('.ddate').serialize();
    $.ajax({
      type: "POST",
      url: "/[~1153~]",
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



<?php
//var_dump($_POST);
if ($_POST['data'] == ""){
  return 'Всё печально :(';
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
while($row=mysql_fetch_assoc($sql2))
{
  $kmd[]=$row;
}
//echo "<pre>";
//var_dump($kmd[0]['cr_fullname']);
$table= '<br /><table class="table table-bordered table-condensed" border="2">
        <thead>
        <tr>
          <th>#</th>
          <th class=thtablem>Номер заказа</th>
          <th>Статус</th>
          <th class="thtablem">Дата доставки</th>
          <th class="thtablem">shk</th>
          <th class="thtablem">Курьер</th>
          <th class=thtablem>ID</th>
        </tr>
        </thead>
      <tbody>';


$i = 0;

if ($kmd != ""){

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
  echo "<br /><br />Нет заказов на указанную дату.";
}
?>



<?php



if($_POST){	
	$postData = preg_replace("/(\d\d).(\d\d).(\d\d\d\d)/","\\3-\\2-\\1",$_POST['date']);	
	
	$sql="SELECT w.*, m.fullname, COUNT(status) as cnt FROM warehouse_issue as w  
	LEFT JOIN modx_web_user_attributes as m
	
	ON w.who = m.internalKey
	
	WHERE w.`date` = '".$postData."' AND status IN (3) GROUP BY who ";
	$q=$modx->db->query($sql);
	$c=0;
	while($row=mysql_fetch_assoc($q)){
		$rows[]=$row;$c++;
	}
	
	if($rows != ""){
		foreach($rows as $k => $v){
			
			//$sql2="SELECT * FROM `warehouse_issue` WHERE o_id = '".$ord['id']."' AND `what` = 'Перенос Нет на складе' ";
			//$q2=$modx->db->query($sql2);
			//$logs2=mysql_fetch_assoc($q2);
			
			$list .= "<tr>
			<td>".$v['fullname']." [ ".$v['id']." ]</td>
			<td>".$v['cnt']."</td>
			<td></td>
		</tr>";
		}
		
		echo $list;
	}
	
}



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
	while($array = mysql_fetch_assoc($q2))
	{
	$rows2[] =	$array; 
	
	}
		while($row=mysql_fetch_assoc($q))
		{
		$rows[$i]=$row;
		$rows[$i][$i] = $rows2[$i]; 
		$i++;
		}
			
		
	
		
	if($rows != ""){
	
		
		
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
	
}
}
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
}else{
	
}

if($pdata['delivery_date']){
	$where .= " AND b.date2 BETWEEN '".$startdate."' AND '".$curdate."'";
}



//$sql="select b.client_id, b.b_id, b.date2, b.check_status+0 as c_status, b.itog_cli, b.itog_ks, b.itog_im, c.client_name, c.is_off, c.vi4et,b.b_type,  b.b_type+0 as typeoff from BILLS as b, CLIENTS as c where b.client_id NOT IN (238, 2, 274, 65) AND b.client_id = c.client_id ".$where." and ((c.vi4et = '0' && b.vi4et_status IN (1)) || (c.vi4et != '0' && b.np_status IN (1) && b.itog_cli != '0.00')) order by b.client_id, b.date2";

$sql = "select b.client_id, b.b_id, b.date2, b.check_status+0 as c_status, c.parent_company, 
b.itog_cli, b.itog_ks, b.itog_im, c.client_name, c.is_off, c.vi4et,b.b_type, b.b_type+0 as typeoff 
from BILLS as b 
LEFT JOIN 
CLIENTS as c 
ON b.client_id = c.client_id 
WHERE b.client_id NOT IN (238, 2, 274, 65, 1356) 
".$where."
AND ((c.vi4et = '0' && b.vi4et_status IN (1)) || (c.vi4et != '0' && b.np_status IN (1) && b.itog_cli != '0.00')) 
order by b.client_id, b.date2";

//echo $sql;

$q=$modx->db->query($sql);
$c=0;
while($row=mysql_fetch_assoc($q))
{
	$rows[]=$row;
	$c++;
}

//var_dump($rows);

if ($rows == ""){echo "<tr><td colspan=6><div class='alert alert-success'>По данному клиенту отчёты не формировались</div></td></tr>";}else {
	$i = 1;
	foreach ($rows as $k => $v) {
		if ($v['typeoff'] == '1') 
		{
			if($v['itog_cli'] != '0' )
			{
				$bnal[$v['client_id']][] = $v;
			}
			//
			if($v['itog_im'] < '0' )
			{
				$bnal[$v['client_id']][] = $v;
			}
			//
		}
		elseif ($v['typeoff'] == '2') 
		{
			
			if($v['itog_cli'] != '0')
			{
				$nal[$v['client_id']][] = $v;
			}
		}
		elseif ($v['typeoff'] == '1') 
		{
			
			if($v['itog_cli'] == '0')
			{
				$bnal[$v['client_id']][] = $v;
			}
		}
		
	}
	
	
	print_r($bnal);
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
			
				
		}
		
	
			$table .= '<tr style="border-bottom:2px solid black;"><td colspan =2 align=center> БЕЗ НАЛ</td><td align=right style="border:3px solid black;"><b>' . number_format($bnalsumm, 2, '.', ' ') . '</b></td></tr>';
		
	}
	
	
	if($nal != ''){
		foreach ($nal as $key => $val) {
			foreach ($val as $k => $v) {
				//if($v['typeoff'] == '2'){
					
					if ($v['vi4et'] == '0') {
						if ($v['itog_im'] < '0' || $v['itog_im'] < '0.00' && $v['c_status'] == '2') {
							//$summ1[$key] += $v['itog_im'];
							//$str1[$key] .= ' ' . $v['b_id'];
						}else{
							
							if($v['itog_im'] > '1')
							{
							$summ1[$key] += $v['itog_im'];
							$str1[$key] .= ' ' . $v['b_id'];
							}	
								
						}
						
					}else{
						$summ1[$key] += $v['itog_cli'];
						$str1[$key] .= ' ' . $v['b_id'];
					}
					$client1 = $v['client_name'];
					$client_id1 = $v['client_id'];
					
				}
				
			if($summ1[$key] != 0){
					$table .= '<tr><td>LS'.$client_id1.' / <b>' . $client1 . ' </b></td><td>' . $str1[$key] . '</td><td align=right>' . number_format($summ1[$key], 2, '.', ' ') . '</td> </tr>';
			
					$bnalsumm1 += $summ1[$key];
				
			}
					
				
			//}
		}
			
		if($bnalsumm1 != '0.00' && $bnalsumm1 != ''){
	
			$table .= '<tr style="border-bottom:3px solid black;"><td colspan =2 align=center> НАЛ</td><td align=right style="border:3px solid black;"><b>'.number_format($bnalsumm1, 2, '.', ' ').'</b></td></tr>';
		}
		
		
	}
	
	//$cipher = $bnalsumm1 + $bnalsumm;
	
	//$table .= '<tr style="border:3px solid black;"><td colspan =3 align=center> <b>'.number_format($cipher, 2, '.', ' ').'</b></td></tr>';
	echo $table;
	
}
?>



CREATE TABLE PERSONAL (
id_user int (10) AUTO_INCREMENT,
name varchar(20) NOT NULL,
surname varchar(50) NOT NULL,
middlename varchar(50) NOT NULL,
post varchar (50) NOT NULL,
id_o int (10) NOT NULL,
biryhdate DATE NOT NULL,
dir_id int (10) NOT NULL,
PRIMARY KEY (id_user)
)
 
INSERT INTO  PERSONAL  (name,  surname,  middlename,  post, id_o,  biryhdate,  dir_id)
VALUES( 'Иван', 'Иванов', 'Иванович', 'менеджер', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6'),
( 'Сергей', 'Петров', 'Петрович', 'логист', '2', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '8'),
( 'Пимен', 'Барановский', 'Викентиевич ', 'оператор', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6'),
( 'Кондратий', 'Орехов', 'Игнатиевич', 'водитель', '3', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '10'),
( 'Бронислав', 'Сильвестров', 'Андронович', 'шофер', '2', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '8'),
( 'Розалия', 'Малинина', 'Якововна', 'директор', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6'),
( 'Аскольд', 'Дюков', 'Денисович', 'крановщик', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6'),
( 'Евдокия', 'Карчагина', 'Павеловна', 'директор', '2', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '8'),
( 'Тарас', 'Боголепов', 'Чеславович', 'сторож', '3', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '10'),
( 'Варфоломей', 'Лашкин', 'Иосифович', 'директор', '3', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '10'),
( 'Захар', 'Чистяков', 'Игнатиевич', 'слесарь', '3', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '10'),
( 'Игорь', 'Сидоров', 'Иосифович', 'менеджер', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6'),
( 'Павел', 'Кревицкий', 'Александрович', 'директор', '3', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '10'),
( 'Авраам', 'Бронштейн', 'Давыдович', 'директор', '1', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '6')
 
 
CREATE TABLE DEPARTMENT (
id_o int (10) AUTO_INCREMENT,
otdel varchar(20) NOT NULL,
id_user int (10) NOT NULL,
name varchar(20) NOT NULL,
surname varchar(50) NOT NULL,
middlename varchar(50) NOT NULL,
PRIMARY KEY (id_o),
FOREIGN KEY (id_user) REFERENCES PERSONAL (id_user)
)
 
INSERT INTO  DEPARTMENT (otdel, id_user, name, surname, middlename) 
VALUES( 'отдел логистики', '6',  'Розалия',  'Малинина',  'Якововна'),
( 'отдел продаж', '8', 'Евдокия', 'Карчагина', 'Павеловна'),
( 'колл центр', '10', 'Варфоломей', 'Лашкин', 'Иосифович')
 
 
SELECT  p.surname as familiya, 
CONCAT_WS('.', LEFT(p.name,1), LEFT(p.surname,1), LEFT(p.middlename,1)) as fio, 
TIMESTAMPDIFF(YEAR, biryhdate, curdate()) as years, 
d.otdel, 
d.surname as director
FROM PERSONAL as p LEFT JOIN DEPARTMENT as d ON p.id_o = d.id_o 
WHERE p.id_user NOT IN (p.dir_id)
ORDER BY p.id_user
LIMIT 10
 