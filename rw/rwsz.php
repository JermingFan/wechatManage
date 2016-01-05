<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        任务分配
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

$sql = "SELECT * FROM `user_info`";
$res = _select_data($sql);

?>

<div class="container">
    <form action="http://wglpt.sinaapp.com/rw/rwsz.php" method="post">
        <h2 class="form-signin-heading">请分配任务</h2>
        <div class="form-group">
            <label>任务名称</label>
            <input name="name" type="text" class="form-control" placeholder="输入任务名称..." />
        </div>
        <div class="form-group">
            <label>描述</label>
            <textarea name="desc" class="form-control" rows="5" placeholder="Enter ..."></textarea>
        </div>
        <div class="form-group">
            <label>执行人</label>
            <select name="long" class="form-control">
                <?php while($rows = mysql_fetch_array($res))
                {
                    ?>
                    <option value="<?php $rows['uid'] ?>"><?php echo $rows['uid'].'——'.$rows['name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>任务时间</label>
            <select name="long" class="form-control">
                <option value="86400">1天</option>
                <option value="172800">2天</option>
                <option value="259200">3天</option>
                <option value="345600">4天</option>
                <option value="432000">5天</option>
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