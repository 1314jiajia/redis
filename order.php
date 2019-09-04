<?php
//下单操作
//封装下需要入库的数据
$data['order_code']=time()+rand(1,10000);//订单号 
$data['r_id']=$_POST['r_id'];//场次id 
$data['m_id']=$_POST['r_id'];//场次id 
$data['num']=count($_POST['s_code']);//购买数量
$data['s_code']=implode(",",$_POST['s_code']);//购买座位
$data['phone']=$_POST['phone'];//电话
$data['static']=0;//状态
$data['order_time']=time();//下单时间

$redis=new Redis();
//连接redis
$redis->connect("localhost",6379);

//把当前场次购买的座位存储在redis集合里
foreach($_POST['s_code'] as $key=>$value){
	$redis->sadd('movie_buy217:'.$_POST['r_id'],$value);
}
// echo "<pre>";
// var_dump($data);
$pdo = new PDO("mysql:host = localhost;charset = utf8;dbname = movie","root","");

//准备sql语句 PDO预处理  占位符(? :)绑定的三种方法: 绑定值 绑定变量 绑定数组
$sql = "insert into morder(order_code,r_id,m_id,num,s_code,phone,static,order_time)values(:order_code,:r_id,:m_id,:num,:s_code,:phone,:static,:order_time)";
//返回预处理
$list = $pdo->prepare($sql);
//执行插入（绑定数组）
$list->execute($data);
echo "下单成功";

 ?>