<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        请假审核
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

if(isset($_POST["submit"]))
{
    $pass = $_POST["pass"];
    $id = $_POST['id'];
    $sql = "UPDATE `user_qingjia` SET `pass` = '$pass' WHERE `id` = '$id'";
    $res = _update_data($sql);
    if($res == 1)
    {
        echo "审核成功 ↖点击此处返回";
    }
    else
    {
        echo "审核".$uid."失败<br/>请重新修改~";
    }
    exit();
}

$getid = $_GET['id'];
$sql = "SELECT * FROM `user_qingjia` WHERE `id` = '$getid'";
$res = _select_data($sql);
$rows = mysql_fetch_array($res);

?>

<div class="container">
    <form action="http://wglpt.sinaapp.com/qj/qjsh.php" method="post">
        <h2 class="form-signin-heading">请审核请假</h2>
        <div class="form-group">
            <label>请假序号</label>
            <input name="id" type="text" class="form-control" value="<?php echo $_GET['id'] ?>" placeholder="<?php echo $_GET['id'] ?>" />
        </div>
        <div class="form-group">
            <label>工号</label>
            <input name="uid" type="text" class="form-control" value="<?php echo $_GET['uid'] ?>" placeholder="<?php echo $_GET['uid'] ?>" />
        </div>
        <div class="form-group">
            <label>是否通过</label>
            <select name="pass" class="form-control">
                <option value="0" <?php if (0 == $rows['pass']) echo 'selected' ?>>未通过</option>
                <option value="1" <?php if (1 == $rows['pass']) echo 'selected' ?>>通过</option>
            </select>
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
