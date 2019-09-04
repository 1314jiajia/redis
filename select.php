<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>选择座位</title>
	<link rel="stylesheet" href="public/bs/css/bootstrap.min.css">
	<script type="text/javascript" src="public/js/jquery-1.8.3.min.js"></script>
	<style type="text/css">

		#movie{width: 800px;margin: 0 auto;}
		#m_info{width: 349px;float: left;border-right:1px solid #333;}
		#m_order{width: 400px;height: 200px;float: left;margin-left: 50px;}
		p{text-align:left;color: #777;}
		p span{font-size:18px;color:#333;}
		#code{width: 900px;margin: 0 auto;overflow-x: scroll;}
		 .seatCharts{width:35px;height: 35px;border-radius:5px;margin: 2px;float: left;}
		 .available{background-color: #b9dea0;}
		 .selected{background-color: #e6cac4;}
		 .available:hover{background-color: #76b474;}
		 .clear{clear:both;}
		#seat-map{ border-right: 1px dotted #adadad;
				    list-style: outside none none;
				  /*  max-height: 1000px;*/
				    overflow-x: auto;
				    padding: 20px;
				    width: 1200px;}
	</style>
</head>
<body>
	<form action="./order.php" method="post" id="ff">
	<div id="movie">
		<?php
		//导入Model类
			include "./class/Model.class.php";
			//实例化 
			$mod=new Model();
			//获取当前场次数据
			$data=$mod->get("select * from relss where id={$_GET['rid']}")[0];
			// echo "<pre>";
			// var_dump($data); 
		 ?>
		<div id="m_info">
			<p>影片名称:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_name'] ?></span></p>
			<p>放映厅:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['h_name'] ?></span></p>
			<p>影片时长:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_time'] ?></span></p>
			<p>时间:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['start_time']."--".$data['end_time'] ?>
				</span></p>
		</div>
		<div id="m_order">
			<br>
			<br>
			<br>
			<p>手机号:&nbsp;&nbsp;&nbsp;<span ><input type="text" name="phone"><span id="ss"></span></span></p>
			<input type="hidden" name="r_id" value="<?php echo  $_GET['rid']?>">
			<p><span ><input type="submit" class="btn btn-success" value="购买"></span></p>
			<div class="available" style="width: 70px;height: 30px;border-radius:5px;text-align:center;line-height:30px;float:left">可选</div>
			<div class="selected" style="width: 70px;height: 30px;border-radius:5px;text-align:center;line-height:30px;float:left">已售</div>
		</div>
		<div style="clear:both"></div>
		<hr>
	</div>
	<div class="container">
		<?php
		//遍历播放厅的座位
		$data1=$mod->get("select HallLayout from hall where id={$_GET['h_id']}")[0];
		// echo "<pre>";
		// var_dump($data1); 
		// ___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeeeeee__,___eeeeeee__eeeeeeeeeee
		// 如果是_ 代表过道 
		// 如果是e 代表的是每一列
		// 如果是, 代表的换排
		$redis=new Redis();
		//连接redis
		$redis->connect("localhost",6379);
		
		//获取当前场次出售的座位=>数组 1_3 2_5
		$movie217=$redis->smembers('movie_buy217:'.$_GET['rid']);

		 ?>
		<div id="code">
			<div id="seat-map">
				<div class="clear seatCharts">1</div>
				<?php
					//遍历 $k排  $j 列 
					for($k=1,$j=0,$i=0;$i<strlen($data1['HallLayout']);$i++){
						//判断如果是_ 空白过道
						if($data1['HallLayout'][$i]=="_"){
							echo "<div class='seatCharts'></div>";
						//如果是e 获取列
						}elseif($data1['HallLayout'][$i]=="e"){
							//列做加加
							$j++;
							$s=$k."_".$j;
							if(in_array($s,$movie217)){
								echo "<div class='selected seatCharts'>".$j."</div>";
							}else{
								echo "<div class='available seatCharts'><input type='checkbox' name='s_code[]' value='".$s."'>".$j."</div>";
							}
							
						//换排
						}elseif($data1['HallLayout'][$i]==","){
							//排加加
							$k++;
							//列初始化
							$j=0;
							echo "<div class='clear seatCharts'>".$k."</div>";
						}
					} 
				 ?>
			</div>
			
		</div>
	</div>
	</form>
	<div style="width: 100%;height: 100px;clear:both"></div>
</body>

</html>