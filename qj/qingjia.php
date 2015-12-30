<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        申请请假
    </title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: Fancy
 * Date: 15.12.9
 * Time: 17:22
 */
require_once '../sql.php';

if (!empty($_GET["openid"]))
{
    $fromUsername = $_GET["openid"];
}

if(isset($_POST["submit"]))
{
    qingjia(trim($_POST['fromusername']), trim($_POST['uid']), trim($_POST['name']), trim($_POST['long']), trim($_POST['info']));
    exit();
}
$sql = "SElECT * FROM `user_info` WHERE `from_user` = '$fromUsername'";
$res = _select_data($sql);
$rows = mysql_fetch_array($res);

function qingjia($fromUsername, $name, $uid, $long, $info)
{
    $time = date('Y-m-d', time());
    $endtime = date('Y-m-d', time()+$long);
    $sql = "INSERT INTO `user_qingjia` (`from_user`, `uid`, `name`, `time`, `endtime`, `info`) values ('$fromUsername', '$uid', '$name', '$time', '$endtime', '$info')";
    $res = _insert_data($sql);
    if($res == 1)
    {
        echo "请假成功 ↖点击此处返回";
    }
    else
    {
        echo "请假".$uid."失败<br/>请重试~";
    }

}
?>

<div class="container">
    <form action="http://wglpt.sinaapp.com/qj/qingjia.php" method="post">
        <h2 class="form-signin-heading">请假详情</h2>
        <input name="fromusername" type="hidden" value="<?php echo $rows['from_user'] ?>" />
        <div class="form-group">
            <label>工号</label>
            <input name="uid" type="text" class="form-control" value="<?php echo $rows['uid'] ?>" placeholder="<?php echo $rows['uid'] ?>" />
        </div>
        <div class="form-group">
            <label>姓名</label>
            <input name="name" type="text" class="form-control" value="<?php echo $rows['name'] ?>" placeholder="<?php echo $rows['name'] ?>"/>
        </div>
        <div class="form-group">
            <label>请假时长</label>
            <select name="long" class="form-control">
                <option value="86400">1天</option>
                <option value="172800">2天</option>
                <option value="259200">3天</option>
                <option value="345600">4天</option>
                <option value="432000">5天</option>
            </select>
        </div>
        <div class="form-group">
            <label>请假理由</label>
            <textarea name="info" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="确定" class="btn btn-success btn-block"/>
        </div>
    </form>
</div>
<footer class="footer">
    <div class="container">
        <label>Copyright ©2015<br/>Powered By 范哲铭 & 毕设</label>
    </div>
</footer>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
