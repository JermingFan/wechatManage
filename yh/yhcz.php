<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        状态修改
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

if (isset($_POST["submit"]))
{
    $state = $_POST["state"];
    $id = $_POST['id'];
    $sql = "UPDATE `user_info` SET `state` = '$state' WHERE `id` = '$id'";
    $res = _update_data($sql);
    if ($res == 1)
    {
        echo "修改状态成功 ↖点击此处返回";
    }
    else
    {
        echo "修改".$uid."失败<br/>请重新修改~";
    }
    exit();
}

$getuid = $_GET['uid'];
$sql = "SELECT * FROM `user_info` WHERE `uid` = '$getuid'";
$res = _select_data($sql);
$rows = mysql_fetch_array($res);

?>

<div class="container">
    <form action="http://wglpt.sinaapp.com/rw/rwcz.php" method="post">
        <h2 class="form-signin-heading">请修改用户状态</h2>
        <div class="form-group">
            <label>工号</label>
            <input name="id" type="text" class="form-control" value="<?php echo $rows['id'] ?>" placeholder="<?php echo $rows['id'] ?>" />
        </div>
        <div class="form-group">
            <label>姓名</label>
            <input name="name" type="text" class="form-control" value="<?php echo $rows['name'] ?>" placeholder="<?php echo $rows['name'] ?>" />
        </div>
        <div class="form-group">
            <label>状态</label>
            <select name="state" class="form-control">
                <option value="1" <?php if (1 == $rows['state']) echo 'selected' ?>>在职</option>
                <option value="0" <?php if (0 == $rows['state']) echo 'selected' ?>>离职</option>
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
