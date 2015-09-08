<?php include_once "backend.php"; ?>
<html>
<head>
</head>
<body>
<h1><?php the_title(); ?></h1>


<?php
    echo "init mysql database test";
    $result = init_db();
	echo $result;
?>

</dody>
</html>