<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>电影列表</title>
	<link rel="stylesheet" href="public/bs/css/bootstrap.min.css">
	<script src="public/bs/js/jquery.min.js"></script>
	<script src="public/bs/js/bootstrap.min.js"></script>
	<script src="public/bs/js/holder.min.js"></script>
	<script src="public/bs/js/application.js"></script>

	<style type="text/css">
		.moves img{width: 200px;}
		.moves th{width: 150px;}
	</style>
</head>
<body>
	<div class="container">
		<h3 class="text-center"><a href="">今日放映</a></h3>
		<hr>
		<br>
		<div class="bs-example">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
          <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
          <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>

        </ol>
        <div class="carousel-inner">
          <div class="item active">
            <img src="public/a.jpg" style="min-width:100%" alt="First slide">
            <div class="carousel-caption">第一个轮播图</div>
          </div>
          <div class="item">
            <img src="public/b.jpg" style="min-width:100%" alt="Second slide">
            <div class="carousel-caption">第二个轮播图</div>

          </div>
          <div class="item ">
            <img src="public/c.jpg" style="min-width:100%" alt="Third slide">
            <div class="carousel-caption">第三个轮播图</div>

          </div>
           <div class="item ">
            <img src="public/d.jpg" style="min-width:100%" alt="Third slide">
            <div class="carousel-caption">第四个轮播图</div>

          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
    </div>
		<table class="table table-bordered table-hover table-striped table-condensed">
			<tr>
				<th>影片</th>
				<th>影片名称</th>
				<th>导演</th>
				<th>主演</th>
				<th>放映信息</th>
				<th>时长</th>
				<th>票价</th>
				<th>操作</th>
			</tr>
			<?php
			//导入Model类
			include "./class/Model.class.php";
			//实例化 
			$mod=new Model();
			//准备sql语句 =》获取电影列表
			$data=$mod->get("select * from movie");
			// echo "<pre>";
			// var_dump($data);die;
			foreach($data as $row){
			 ?>
			<tr class="moves">
				<th><img src="<?php echo './public'.$row['picurl'] ?>"></th>
				<th><?php echo $row['m_name'] ?></th>
				<th><?php echo $row['m_director'] ?></th>
				<th><?php echo $row['actor'] ?></th>
				<th style="width:250px"><?php echo mb_substr($row['content'],0,50)."..." ?></th>
				<th style="width:100px"><?php echo $row['m_time'] ?></th>
				<th style="width:100px"><?php echo $row['m_price'] ?></th>
				<th style="width:100px"><a href="./mvinfo.php?m_id=<?php echo $row['id'] ?>" class="btn btn-success">查看详情</a></th>
			</tr>	
			<?php } ?>		
		</table>
	</div>
</body>
</html>