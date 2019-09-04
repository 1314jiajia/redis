<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>选择场次</title>
	<link rel="stylesheet" href="public/bs/css/bootstrap.min.css">

	<style type="text/css">
		.moves img{width: 200px;}
		.moves th{width: 150px;}
		#movie{margin: 0 auto;}
		#m_pic{width: 1000px;}
		#m_info{width: 1000px;text-align:left;color: #777;}
		#m_info p span{font-size:18px;color:#333;}
	</style>
</head>
 <body>
 	<div class="container">
	
		<h3 class="text-center"><a href="" >详情介绍</a></h3>
		<?php
			//导入Model类
			include "./class/Model.class.php";
			//实例化 
			$mod=new Model();
			//执行sql
			$data=$mod->get("select * from movie where id={$_GET['m_id']}")[0]; 
			// echo "<pre>";
			// var_dump($data);die;
		 ?>
		<div id="movie">
			<div id="m_pic"><img src="<?php echo './public'.$data['picurl'] ?>"></div>
			<div id="m_info">
				<p>影片名称:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_name'] ?></span></p>
				<p>影片类型:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_type'] ?></span></p>
				<p>影片地区:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['country_area'] ?></span></p>
				<p>影片时长:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_time'] ?></span></p>
				<p>影片导演:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['m_director'] ?></span></p>
				<p>影片主演:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['actor'] ?></span></p>
				<p>影片剧情:&nbsp;&nbsp;&nbsp;<span ><?php echo $data['content'] ?></span></p>
			</div>
			<h3 class="text-center"><a href="" >场次列表</a></h3>
			<hr>
			<br>
			<table class="table table-bordered table-hover table-striped table-condensed">
				<tr>
				
					<th>放映厅</th>
					<th>开场时间</th>
					<th>结束时间</th>
					<th>票价</th>
					<th>座位数</th>
					<th>已售</th>
					<th>操作</th>
				</tr>
				<?php
				//获取当前电影场次
				$data = $mod->get("select * from relss where m_id={$_GET['m_id']}"); 
				// echo "<pre>";
				// var_dump($data);die;
				foreach($data as $row){

					$redis = new Redis();
					//连接redis
					$redis->connect("localhost",6379);
			
					//获取当前场次出售的座位个数
					$num=count($redis->smembers('movie_buy217:'.$row['id']));
				 ?>
				<tr class="moves">
					<th><?php echo $row['h_name'] ?></th>
					<th><?php echo $row['start_time'] ?></th>
					<th><?php echo $row['end_time'] ?></th>
					<th><?php echo $row['m_price'] ?></th>
					<th><?php echo $row['seating'] ?></th>
					<th><?php echo $num ?></th>
					<th style="width:100px"><a href
						="./select.php?rid=<?php echo $row['id'] ?>&h_id=<?php echo $row['h_id'] ?>">去选座</a></th>
				</tr>
				<?php } ?>			
			</table>
		</div>
	</div>
	<div style="width: 100%;height: 100px;"></div>
 </body>
 </html>