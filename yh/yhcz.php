<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>管理员登录</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php
if(isset($_POST["submit"]))
{
    bangding(urlencode($_POST["id"]), urlencode($_POST["pwd"]));
}
function bangding($id, $pwd)
{
    require_once './sql.php';
    $sql = "SELECT password FROM admin WHERE id = '$id'";
    $result = _select_data($sql);
    $rows = mysql_fetch_array($result);
    $password= $rows['password'];
    if ($password == $pwd && $pwd != null)
    {
//echo '<script> location.replace("xuanke.php?stu='.$user.'"); </script>';
        echo '<script> location.replace("./bd/quanxian.php"); </script>';
    }
    else
    {
        echo '<script>alert("密码错误，请重新输入！");</script>';
    }
}
?>

<div class="container">

    <form class="form-signin" action = "" method = "post">
        <h2 class="form-signin-heading">管理员登录</h2>
        <label for="inputEmail" class="sr-only">帐号...</label>
        <input type="text" id="input" name="id" class="form-control" placeholder="帐号..." required autofocus>
        <label for="inputPassword" class="sr-only">密码...</label>
        <input type="password" id="inputPassword" name="pwd" class="form-control" placeholder="密码..." required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> 记住我
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" name = "submit" type="submit">登录</button>
    </form>

</div> <!-- /container -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>
