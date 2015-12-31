<?php
/**
 * Created by PhpStorm.
 * User: Fancy
 * Date: 15.12.9
 * Time: 17:22
 */
require_once './sql.php';
//require_once './yhxx/yhxx.php';

define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr))
        {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $event = $postObj->Event;
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            $imageTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>//消息类型为news（图文）
							<ArticleCount>1</ArticleCount>//图文数量为1（单图文）
							<Articles>
							<item>//第一张图文消息
							<Title><![CDATA[%s]]></Title> //标题
							<Description><![CDATA[%s]]></Description>//描述
							<PicUrl><![CDATA[%s]]></PicUrl>//打开前的图片链接地址
							<Url><![CDATA[%s]]></Url>//点击进入后显示的图片链接地址
							</item>
							</Articles>
							</xml> ";

            if (!empty($event))
            {
                $bookTpl =
                    "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>1</ArticleCount>
                        <Articles>";
//                foreach($a as $id=>$b)
//                {
//                    if($id>$no) break;
//                    else null;
                    $bookTpl.=
                        "<item>
                        <Title>123</Title>
                        <Description><![CDATA[s]]></Description>
                        <PicUrl><![CDATA[]]></PicUrl>
                        <Url><![CDATA[]]></Url>
                        </item>";
//                }
                $bookTpl.=
                    "</Articles>
                        <FuncFlag>1</FunFlag>
                        </xml>";
                $resultStr = sprintf($bookTpl, $fromUsername, $toUsername, $time);
                echo $resultStr;
            }

            $sql = "SELECT flag_id FROM user_flags WHERE from_user = '$fromUsername'";
            $result = _select_data($sql);
            while ($rows = mysql_fetch_array($result))
            {
                $user_flag = $rows[flag_id];
            }
            if (trim($keyword) != $user_flag && is_numeric($keyword))
            {
                $user_flag = '';
                $sql = "DELETE FROM user_flags WHERE from_user = '$fromUsername'";
                _delete_data($sql);
            }
            if (empty($user_flag))
            {
//                用户绑定对应角色
                if ($keyword == '1' || $keyword == '绑定')
                {
                    $sql = "SELECT `uid` FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
                    $result = _select_data($sql);
//                    查找是否已存在信息
                    while ($rows = mysql_fetch_array($result))
                    {
                        $data = $rows['uid'];
                    }

                    if (empty($data))
                    {
                        $msgType = "text";
                        $contentStr = '<a href="http://wglpt.sinaapp.com/bd/bangding.php?openid=' . $fromUsername . '">点击绑定角色~</a>';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = "用户".$data."已存在\n请重新绑定~";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }

                }

//                用户修改权限
                if ($keyword == '2' || $keyword == '修改权限')
                {
                    $sql = "SELECT * FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
                    $res = _select_data($sql);
                    while ($rows = mysql_fetch_array($res))
                    {
                        $data = $rows['type'];
                    }
                    if ($data == 1)
                    {
                        $msgType = "text";
                        $contentStr = '<a href="http://wglpt.sinaapp.com/bd/quanxian.php?openid=' . $fromUsername . '">点击进入修改权限~</a>';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = "暂无权限！\n请联系管理员";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }

//                用户解除绑定
                if ($keyword == '3' || $keyword == '解绑' || $keyword == '解除绑定')
                {
                    $sql = "SELECT * FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
                    $res = _select_data($sql);
                    while ($rows = mysql_fetch_array($res))
                    {
                        $data = $rows['uid'];
                    }

                    if(!empty($data))
                    {
                        $sql1 = "DELETE FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
                        $res1 = _delete_data($sql1);

                        if($res1 == 1)
                        {
                            $msgType = "text";
                            $contentStr = '解绑工号成功~';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }
                        else
                        {
                            $msgType = "text";
                            $contentStr = '解绑工号失败！';
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }

                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = '未绑定工号！';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }

//                用户签到
                if ($keyword == '4' || $keyword == '签到')
                {
//                    后续逻辑增加未签到
//                    每天定时corn清空表
                    $sql = "SELECT `from_user` FROM `user_qiandao` WHERE `from_user` = '$fromUsername'";
                    $result = _select_data($sql);
//                    查找是否已存在信息
                    while ($rows = mysql_fetch_array($result))
                    {
                        $data = $rows['from_user'];
                    }

                    if (empty($data))
                    {
//                        签到时间为9点，8点开始
                        $time = strtotime("9:00:00") - time();
                        if ($time > 0 && $time < 3600)
                        {
                            $sql = "INSERT INTO `user_qiandao` (`from_user`) values ('$fromUsername')";
                            $res = _insert_data($sql);
                            if ($res == 1)
                            {
                                $msgType = "text";
                                $contentStr = "签到成功~";
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                            }
                            else
                            {
                                $msgType = "text";
                                $contentStr = "签到失败\n请重新签到！";
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                            }

                        }
                        elseif ($time > 3600)
                        {
                            $msgType = "text";
                            $contentStr = "还没到签到时间！";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }
                        else
                        {
//                            添加迟到状态
                            $qtime = date("H:i:s");
                            $sql = "INSERT INTO `user_qiandao` (`from_user`, `late`, `time`) values ('$fromUsername', '1', '$qtime')";
                            $res = _insert_data($sql);
//                            之后要修改绩效的代码*****************
                            if ($res == 1)
                            {
                                $msgType = "text";
                                $contentStr = "签到成功\n已迟到！";
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                            }
                            else
                            {
                                $msgType = "text";
                                $contentStr = "签到失败\n请重新签到！";
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                            }
                        }

                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = "你已签到！";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }

                }

//				查看签到
                if ($keyword == '5' || $keyword == '查看签到')
                {
                    $sql = "SELECT q.`late`, q.`time`, i.`uid`, i.`name` FROM `user_qiandao` q, `user_info` i WHERE q.`from_user` = i.`from_user`";
                    $res = _select_data($sql);
                    $v = '';
                    while ($rows = mysql_fetch_array($res))
                    {
                        if ($rows['late'] == '1')
                        {
                            $late = '迟到';
                        }
                        else
                        {
                            $late = '正常';
                        }
                        $v .= $rows['uid'] . ' ---- ' . $rows['name'] . ' ---- ' . $late. ' ---- ' . $rows['time'] . "\n";

                        $title = "工号---姓名---状态---时间";
                        $PicUrl = "";
                        $Description = $v;
                        $Url = "";
                        $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $title, $Description, $PicUrl, $Url);
                        echo $resultStr;
                    }

                }

//                用户信息
                if ($keyword == '6' || $keyword == '信息' || $keyword == '查看信息')
                {
//                    先检查用户是否在职
                    $sql = "SELECT `state` FROM `user_info` WHERE `from_user` = '$fromUsername'";
                    $res = _select_data($sql);
                    $rows = mysql_fetch_array($res);
                    if ($rows['state'] == 1)
                    {
//                        开始读取用户列表
                        $sql = "SELECT * FROM `user_info`";
                        $res = _select_data($sql);
                        $v = '';
                        while ($rows = mysql_fetch_array($res))
                        {
                            if ($rows['state'] == 1)
                            {
                                $state = '在职';
                            }
                            else
                            {
                                $state = '其他';
                            }
                            $v .= $rows['uid'] . ' ---- ' . $rows['name'] . ' ---- ' . $rows['job'] . ' ---- ' . $state . "\n";
                        }

                        $title = "工号---姓名---职务---状态";
                        $PicUrl = "";
                        $Description = $v;
                        $Url = "http://wglpt.sinaapp.com/yh/yhlb.php";
                        $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $title, $Description, $PicUrl, $Url);
                        echo $resultStr;
                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = '对不起，你没有权限！';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }

//                请假申请
                if ($keyword == '7' || $keyword == '请假')
                {
                    $msgType = "text";
                    $contentStr = '<a href="http://wglpt.sinaapp.com/qj/qingjia.php?openid=' . $fromUsername . '">点击申请请假~</a>';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

//                请假审核
                if ($keyword == '8' || $keyword == '审核请假' || $keyword == '请假审核')
                {
                    $msgType = "text";
                    $contentStr = '<a href="http://wglpt.sinaapp.com/qj/qjlb.php?openid=' . $fromUsername . '">点击进行请假审核~</a>';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

//                请假结果
                if ($keyword == '9' || $keyword == '结果' || $keyword == '请假结果')
                {
//					先检查用户是否在职
                    $sql = "SELECT `state` FROM `user_info` WHERE `from_user` = '$fromUsername'";
                    $res = _select_data($sql);
                    $rows = mysql_fetch_array($res);
                    if ($rows['state'] == 1)
                    {
//						开始读取用户列表
                        $sql = "SELECT * FROM `user_qingjia`";
                        $res = _select_data($sql);
                        $v = '';
                        while ($rows = mysql_fetch_array($res))
                        {
                            if ($rows['pass'] == 1)
                            {
                                $pass = '通过';
                            }
                            else
                            {
                                $pass = '未通过';
                            }
                            $v .= $rows['id'] . ' ---- ' . $rows['name'] . ' ---- [ ' . $rows['time'] . ' ~ ' . $rows['endtime'] . ' ] ---- ' . $pass . "\n";
                        }

                        $title = "请假序号---姓名---[ 开始时间 ~ 结束时间 ]---状态";
                        $PicUrl = "";
                        $Description = $v;
                        $Url = "";
                        $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $title, $Description, $PicUrl, $Url);
                        echo $resultStr;
                    }
                    else
                    {
                        $msgType = "text";
                        $contentStr = '对不起，你没有权限！';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }

//                请假审核
                if ($keyword == '10' || $keyword == '任务分配' || $keyword == '任务设置')
                {
                    $msgType = "text";
                    $contentStr = '<a href="http://wglpt.sinaapp.com/rw/rwsz.php?openid=' . $fromUsername . '">点击进行任务分配~</a>';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }
            else
            {
                echo "Input something...";
            }
        }
        else
        {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
//        you must define TOKEN by yourself
        if (!defined("TOKEN"))
        {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>