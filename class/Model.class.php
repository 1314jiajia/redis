<?php
/*
  @return 获取所有数据
  @return 链接redis
  @return array()
 */
	
class Model
{

					public $pdo;
					public $redis;
					public $key;

					public function __construct()
					{
						
						$this->redis = new Redis();

						// 连接redis
						$this->redis->connect("localhost",6379);
						
					}


					public function get($sql)
					{
						// 判断
						$this->key = md5($sql);

						// 获取缓存服务器的数据 ,json_decode()字符串转换数组,给true(转成数组)要不然他默认转的是对象,
						$data=json_decode($this->redis->get($this->key),true);

						// 判断
						if(empty($data)){ 

							$this->pdo = new PDO("mysql:host=localhost;port=3307;charset=utf8;dbname=movie","root","");

							//执行sql语句
							$list = $this->pdo->query($sql);
							
							//获取结果集
							$data = $list->fetchAll(PDO::FETCH_ASSOC);
							
							//给redis一份 ,数组转字符串
							$this->redis->set($this->key,json_encode($data));
						}
						

						return $data;
					}
}
 