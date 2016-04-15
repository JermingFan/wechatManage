<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        添加用户
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
require_once './sql.php';

if(isset($_POST["submit"]))
{
    bangding(trim($_POST["uid"]), trim($_POST["pwd"]));
    exit();
}

function bangding($uid, $pwd)
{
    $sql = "INSERT INTO `user_bangding` (`uid`, `pwd`) values ('$uid', '$pwd')";
    $res = _insert_data($sql);
    if($res == 1)
    {
        echo "添加成功 ↖点击此处返回";
    }
    else
    {
        echo "添加".$uid."失败";
    }

}
?>


<div class="container">
    <form action="http://wglpt.sinaapp.com/adminAdd.php" method="post">
        <h2 class="form-signin-heading">请添加员工</h2>
        <div class="form-group">
            <label>工号</label>
            <input name="uid" type="text" class="form-control" placeholder="输入工号..." required/>
        </div>
        <div class="form-group">
            <label>密码</label>
            <input name="pwd" type="password" class="form-control" placeholder="输入密码..." required/>
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
