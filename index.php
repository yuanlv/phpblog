<?php
/**
 * 从百度新闻中查询关键字，显示搜索结果
 */
include_once("./simple_html_dom.php");

$err = "没有搜到内容，换个词试试吧";

function getNews($keyword){
	$url = "http://news.baidu.com/ns?word=".$keyword."&tn=news&from=news&cl=2&rn=20&ct=1&oq=yuer&f=3&rsp=1";
	$curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$news = curl_exec($curl);
    
	curl_close($curl);
    return getTop1($news);
}

/*
 * 抽取第一个搜索结果
 *<div class="result" id="1"> ... </div>
 */
function getTop1($content){
	$html = new simple_html_dom();
    $html->load($content);

    $div = $html->find('div[id=1]', 0);

    $ret =  $div->plaintext;
    $ret = str_replace("&nbsp;", " ", $ret);
    // $title = $div->children(0)->children(0)->innertext;
    // $title = str_replace("<em>", "", $title);
    // $title = str_replace("</em>", "", $title);
    // echo $title;

    // $from = $div->children(1)->children(1)->children(0);
    // $from = str_replace("&nbsp;", "", $from);
    // echo $from;

    // $summer = $div->children(1)->children(1)->children(1);
    // echo $summer;

    $html->clear();

    return $ret;
}

function getBaiduNewsUrl($keyword){
    $url = "http://news.baidu.com/ns?word=".$keyword."&tn=news&from=news&cl=2&rn=20&ct=1&oq=yuer&f=3&rsp=1";
    return $url;    
}

function getSogouWXUrl($keyword){
    $url = "http://weixin.sogou.com/weixin?query=".$keyword."&fr=sgsearch&ie=utf8&type=2&w=01019900&sut=2642&sst0=1442733020976&lkt=4%2C1442733019274%2C1442733019531";
    return $url;
}

function test(){
    echo getSogouWXUrl("docker");
}

//echo test();
// echo "get news...<br/>";
// echo getNews($_GET['keyword']);
//echo getNews("docker");

/**
  * wechat php test
  */

//define your token
define("TOKEN", "test");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
//$wechatObj->valid();


class wechatCallbackapiTest
{
    /*public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }*/

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
                
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $RX_TYPE = trim($postObj->MsgType);

                switch($RX_TYPE)
                {
                    case "text":
                        $resultStr = $this->handleTextRetImage($postObj);
                        break;
                    case "event":
                        $resultStr = $this->handleEvent($postObj);
                        break;
                    default:
                        $resultStr = "Unknow msg type: ".$RX_TYPE;
                        break;
                }
                echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    public function handleText($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";             
        if(!empty( $keyword ))
        {
            $msgType = "text";
            $contentStr = getNews($keyword);

            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }else{
            echo "随便搜点什么吧";
        }
    }

    public function handleTextRetImage($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>1</ArticleCount>
                        <Articles>
                            <item>
                            <Title><![CDATA[%s]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                        </Articles>
                    </xml>";

        if(!empty( $keyword ))
        {
            $msgType = "news";
            $title = $keword;
            $desc1 = "点击查看百度新闻搜索结果";
            $picUrl1 = "http://api18.yunpan.360.cn/intf.php?method=File.getThumbByNid&qid=23820336&nid=14427314186187642&size=800_600&devtype=web&v=1.0.1&rtick=14427314189263&sign=f332f39ad8cdc1e26bd802b5cfedfcea&";
            $url1 = getBaiduNewsUrl($keywword);
            //"http://yuanlv-docker-phpblog.daoapp.io/weixin_sogou.php?keywword=".$keywword;      
            $resultStr = sprintf($textTpl, $fromUsername, "yuernote", $time, $msgType, 
                                 $title, $desc1, $picUrl1, $url1);
            echo $resultStr;
        }else{
            echo "随便搜点什么吧";
        }
    }

    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【育儿笔记】"."\n"."微信号：yuernote"."\n"."";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }
    
    public function responseText($object, $content, $flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $resultStr;
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];    
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

?>
