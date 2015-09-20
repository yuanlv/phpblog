<?php

//访问搜狗微信搜素
$keyword = $_GET['keyword'];
$url = "http://weixin.sogou.com/weixin?p=01030402&query=".$keyword."&type=2&ie=utf8";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($curl);
echo $resp;
curl_close($curl);

?>