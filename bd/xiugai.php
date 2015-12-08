<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>
		修改权限
	</title>
	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
</head>
<body>

<?php
require_once '../sql.php';

$uid = $_GET['uid'];
if(isset($_POST["submit"]))
{
	$type = $_POST["type"];
	$sql = "UPDATE `user_bangding` SET `type` = '$type' WHERE `uid` ='$uid'";
	$res = _update_data($sql);
}
?>

<div class="container">
	<form action="http://wglpt.sinaapp.com/bd/xiugai.php" method="post">
		<h2 class="form-signin-heading">请修改权限</h2>
		<div class="form-group">
			<label>工号</label>
			<input name="id" type="text" class="form-control" value="<?php echo $uid ?>" placeholder="<?php echo $uid ?>" />
		</div>
		<div class="form-group">
			<label>权限</label>
			<select name="type" class="form-control">
				<option value="0">普通</option>
				<option value="1">高级</option>
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
