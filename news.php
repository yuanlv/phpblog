<?php

/**
 * 从百度新闻中查询关键字，显示搜索结果
 */
function getNews($keyword){
	$url = "http://news.baidu.com/ns?word=".$keyword."&tn=news&from=news&cl=2&rn=20&ct=1&oq=yuer&f=3&rsp=1";
	print_r($url);
	$curl = curl_init($url);
	$news = curl_exec($curl);
	curl_close($curl);

	return $news[0];
}

?>