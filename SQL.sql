
SELECT order_id, status, deliver_date, courier, iner, id 
FROM ORDERS WHERE deliver_date = '12.08.2020' AND id = '65122' AND status = 'Доставка';
-------------

--запрос выводит менеджера и первый заказ:
SELECT o.order_id, cli.client_id, cli.manager_id, cli.client_name, mu.fullname,  o.delivery_date
FROM  CLIENT as cli 
LEFT JOIN  ORDER as o ON cli.client_id = o.client_id
LEFT JOIN modx_web_user as mu  ON mu.internalKey = cli.manager_id
WHERE (cli.manager_id = '12345' OR cli.manager_id = '12333' OR cli.manager_id = '8888')
AND o.client_id = '6511' ORDER BY o.order_id LIMIT 1;
-------------

select c.c_name from customer с where c.rating > (select avg(c.rating) from customers с where c.c_city='Санкт-Петербург')
and c.c_id in (select o.c_id from orders o where o.o_date between trunc(sysdate,'mm') and sysdate);
-------------

-- Запрос, возвращающий имена 5 лучших продавцов (критерий: количество уникальных заказов) за последний год по покупателям из Москвы, 
-- сделавших не менее 10 заказов, упорядочите список по убыванию:
SELECT  s.salespeople_name,  COUNT(DISTINCT o.orders_id)  as orders,	COUNT(c.customers_id) as cusromer 
FROM Salespeople as s LEFT JOIN Orders as o ON  s.salespeople_id = o.salespeople_id LEFT JOIN Customers as c ON o.customers_id = c.customers_id
WHERE c.customers_city = 'москва'  AND  YEAR(orders_date) = YEAR(curdate())  
GROUP BY s.salespeople_name HAVING  cusromer >= '10' ORDER BY s.salespeople_name DESC LIMIT 5
-------------

SELECT w.*, m.fullname, COUNT(status) as cnt 
FROM warehouse as w  LEFT JOIN modx_web_user_attributes as m ON w.who = m.internalKey WHERE w.`date` = '20.11.2020' AND status IN (3) GROUP BY who	
-------------
	
SELECT w.*, m.fullname, COUNT(status) as cnt FROM warehouse_issue as w  
LEFT JOIN modx_web_user_attributes as m ON w.who = m.internalKey
WHERE w.`date` = '".$postData."' AND status IN (3) GROUP BY who 
-------------	

select b.client_id, b.b_id, b.date2, b.check_status+0 as c_status, c.parent_company, b.itog_cli, b.itog_ks, b.itog_im, c.client_name, c.is_off, c.vi4et,b.b_type, b.b_type+0 as typeoff 
from statno as b LEFT JOIN CLIENTS as c ON b.client_id = c.client_id 
WHERE b.client_id NOT IN (777, 888) AND ((c.vi4et = '0' && b.vi4et_status IN (1)) || (c.vi4et != '0' && b.np_status IN (1) && b.itog_cli != '0.00')) 
order by b.client_id, b.date2
-------------	

SELECT o.inner_n, o.order_id, o.shk, o.courier_id, o.status, o.delivery_date, o.id, c.cr_fullname 
FROM ORDERS as o LEFT JOIN COURIERS as c ON o.courier_id = c.id WHERE o.delivery_date = '2020.01.03' 
AND (client_id = '111' OR client_id = '222') AND (o.brand = 'ПАО' OR o.brand = 'КАРТОЙ');
-------------

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
        ('Сергей', 'Петров', 'Петрович', 'персонаж', '2', DATE(FROM_UNIXTIME(RAND() * 1561608120)), '8');

COMMIT;
-------------

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
        ( 'отдел продаж', '8', 'Евдокия', 'Карчагина', 'Павеловна')
-------------

SELECT  p.surname as familiya, CONCAT_WS('.', LEFT(p.name,1), LEFT(p.surname,1), LEFT(p.middlename,1)) as fio, 
TIMESTAMPDIFF(YEAR, biryhdate, curdate()) as years, d.otdel, d.surname as director
FROM PERSONAL as p LEFT JOIN DEPARTMENT as d ON p.id_o = d.id_o WHERE p.id_user NOT IN (p.dir_id)
ORDER BY p.id_user LIMIT 10;
-------------

SELECT t.*,a.BANKACCOUNTNO,a.LOGINNAME,a.USERNAME,a.ISACTIVE,a.ISDELETED,a.ISAPPROVED,a.OFFICENO,a.REGIONNO  
FROM BA a RIGHT JOIN TRANSACTIONLOG t ON a.BANKACCOUNTNO = t.BANKACCOUNTNO
WHERE a.LOGINNAME IN ('Ivanov-NA@sbrf.ru', 'Gupkin-LA@tb6') 
AND t.TRANSACTIONDATE BETWEEN to_date('15.05.2020','DD.MM.YY') AND to_date('19.06.2020','DD.MM.YY') 
AND (t.AUDITMESSAGE = 'Попытка входа' OR t.AUDITMESSAGE = 'Вход в систему');
-------------

insert into log (id, what, val) values ('".$v['id']."',  'Статус', 'на склад');
-------------

UPDATE ORDERS SET status = 'Статус' WHERE order = '".$v['id']."' LIMIT 1;
-------------

SELECT
    LN.TEXTANSWER||' '||FN.TEXTANSWER||' '||MN.TEXTANSWER "ФИО",
    TN.TEXTANSWER "Номер телефона",
    A.CREATEDATE "Дата создания",
    P.CREATEDATE "Дата предложения",   
    A.PRODUCTTYPE "Тип продукта",
    P.PRODUCTNAME "Название страхового продукта",   
    U.UNDERWRITINGSTATUS "Статус заявления",
    U2.UNDERWRITINGSTATUS "Статус предложения",
    A.DOWNPAYMENTAMOUNT "Страховая премия",   
    B.USERNAME "ФИО сотрудника",
    O.OFFICENAME "ВСП"
FROM APP A
LEFT JOIN QQ LN ON LN.CUSTOMERNO = A.CUSTOMERNO AND LN.QUESTIONNO = 1234
LEFT JOIN QQ FN ON FN.CUSTOMERNO = A.CUSTOMERNO AND FN.QUESTIONNO = 5678
LEFT JOIN QQ MN ON MN.CUSTOMERNO = A.CUSTOMERNO AND MN.QUESTIONNO = 9087
LEFT JOIN QQ TN ON TN.CUSTOMERNO = A.CUSTOMERNO AND TN.QUESTIONNO = 6543
LEFT JOIN BA B ON B.BANKACCOUNTNO = A.BANKACCOUNTNO
LEFT JOIN US U ON U.UNDERWRITINGSTATUSNO = A.UNDERWRITINGSTATUSNO
LEFT JOIN PO P ON P.APPLICATIONNO = A.APPLICATIONNO
LEFT JOIN US U2 ON U2.UNDERWRITINGSTATUSNO = P.UNDERWRITINGSTATUSNO
LEFT JOIN OFFICE O ON O.OFFICENO = B.OFFICENO
WHERE A.CREATEDATE >= to_date('29.05.1012','DD.MM.YYYY')
      AND A.CREATEDATE <= to_date('29.05.1905','DD.MM.YYYY')
      AND B.BANKACCOUNTNO IN (654321,123456)
ORDER BY A.APPLICATIONNO;
-------------

SELECT z.fullname,  z.cr_shortname,  COUNT(z.zone_id) as zone
FROM (SELECT DISTINCT  w.who, w.cr_id, w.date, m.fullname, o.courier_id, c.cr_shortname, o.zone_id
FROM warehouse_issue as w 
LEFT JOIN ORDERS as o ON  (o.courier_id =  w.cr_id AND o.delivery_date = w.date)
LEFT JOIN modx_web_user_attributes m ON w.who = m.internalKey 
LEFT JOIN COURIERS as c  ON o.courier_id = c.id
WHERE  w.date = DATE("2019-01-09")  AND w.status IN (3)
) z
GROUP BY z.fullname,  z.cr_shortname
ORDER BY zone DESC, z.fullname DESC,  z.cr_shortname DESC;
-------------

-- SELECT a.client_id, SUM(a.nal) AS nal, SUM(a.beznal) AS beznal FROM (
select b.client_id, b.b_id, b.date2, b.check_status+0 as c_status, c.parent_company,  
b.itog_cli, b.itog_ks, b.itog_im, c.client_name, c.is_off, c.vi4et,b.b_type, b.b_type+0 as typeoff, b.check_status, IF(c.vi4et, b.itog_cli,0) AS beznal, IF(!c.vi4et, b.itog_cli,0) AS nal
from BILLALL as b LEFT JOIN CLIENT as c ON b.client_id = c.client_id WHERE b.client_id NOT IN (238, 2, 274, 65, 1356, 88) AND b.date2 BETWEEN '2019-01-01' AND '2019-01-13' 
-- AND c.client_id = '2302'
AND ((c.vi4et = '0' && b.vi4et_status IN (1)) || (c.vi4et != '0' && b.np_status IN (1) && b.itog_cli != '0.00')) AND b.date2 BETWEEN '2019-01-04' AND '2019-01-13'
-- ) a GROUP BY a.client_id;
order by b.client_id, b.date2;
-------------

SELECT q.pagent_name, q.req_inn, q.bill_id, 
q.typevi4et, q.pagent_id, q.pvz_id, q.date, q.np, q.anp,  q.aus, q.np_status , q.np_date, 
q.aus_status, q.aus_date, q.anp_status, q.anp_date, q.act_id 
SUM(q.itog)  as itog  
FROM (SELECT ag.pagent_name, ag.req_inn, bill.bill_id, 
ag.typevi4et, bill.pagent_id, bill.pvz_id, bill.date, bill.np, bill.anp, atar,  bill.aus, itog, bill.np_status , bill.np_date, 
bill.aus_status, bill.aus_date, bill.anp_status, bill.anp_date, bill.act_id 
FROM AGP_BILL as bill 
LEFT JOIN PVZD as pvz ON bill.pvz_id = pvz.id
LEFT JOIN AGENT as ag ON pvz.pagent_id = ag.id  
WHERE  anp_status = 'Не оплачен' AND date = '2019-03-10') as q GROUP BY q.itog;
-------------

SELECT  
  bb.is_off,  
  bb.client_name_full, 
  bb.client_id, 
  SUM(bb.itog_ks) AS suma, 
  SUM(bb.debt_acted) AS debt_acted, 
  SUM(bb.debt_late) AS debt_late 
FROM (
   SELECT  
     c.is_off,      
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
      IF(DATE_ADD( ba.date, INTERVAL (CONVERT(c.pay_date, char)+3) DAY) <= date('$enddata'), 
	  IF(ba.b_act_id IS NOT NULL, b.itog_ks, 0), 0) AS debt_late
      FROM BILLS b  
      LEFT JOIN BILL_ACT ba ON b.act_id = ba.b_act_id
      LEFT JOIN CLIENTS c ON b.client_id = c.client_id
      LEFT JOIN parent_company as p ON c.parent_company = p.id
      WHERE 
        (
          b.check_status = 'оплачен'  
          AND b.vi4et_status_date IS NULL
        ) 
      AND c.client_id NOT IN (777)
      AND c.active = '1' 
      AND date2 BETWEEN '2017-02-07'
    ) bb 
GROUP BY bb.client_id;
-------------