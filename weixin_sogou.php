<?php

//访问搜狗微信搜素
$keyword = $_GET['keyword'];
$url = "http://weixin.sogou.com/weixin?p=01030402&query=".$keyword."&type=2&ie=utf8";
$curl = curl_init($url);

$Host = "weixin.sogou.com";
$Accept = "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
$UserAgent = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36";


curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);

$resp = curl_exec($curl);
$resp = str_replace("yuanlv-docker-phpblog.daoapp.io", "weixin.sogou.com", $resp);
echo $resp;
curl_close($curl);

?>