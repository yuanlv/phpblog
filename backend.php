<?php
	echo "backend.php...";
	$mysql_host = "10.10.26.58";
	$mysql_user = "uMn2eXUumHv9jKio";
	$mysql_passwd = "p7tSwlINkrFcfOsbg";
	$mysql_db = "db_blog";

	
	
	function the_title(){
		$titulo = "docker php blog";
		echo "docker title";
	}

	function init_db(){
		mysql_connect($mysql_host, $mysql_user, $mysql_passwd);
		
		$result = mysql_query("CREATE database " .$mysql_db);
		return $result;
	}
	
	function init(){
		mysql_connect('localhost', 'root', 'macbook');
		mysql_select_db('blog'); 
		$result = mysql_query('SELECT * FROM posts');
		return $result;
	}
	
	function add_new_post($title, $text){
		mysql_connect('localhost', 'root', 'macbook');
		mysql_select_db('blog');
		$result = mysql_query("INSERT INTO posts (title,text) VALUES ('".$title."', '".$text."')");
		echo mysql_error();
		echo "<a href='index.php'>Go to admin</a>";
	}
?>