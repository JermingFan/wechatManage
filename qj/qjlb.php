<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        用户列表
    </title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
</head>
<body>
<table class="table table-hover">
    <tr>
        <th>姓名</th>
        <th>工号</th>
        <th>开始时间</th>
        <th>结束时间</th>
        <th>理由</th>
        <th>是否通过</th>
        <th>操作</th>
    </tr>

    <?php
    /**
     * Created by PhpStorm.
     * User: Fancy
     * Date: 15.12.9
     * Time: 17:22
     */
    require_once '../sql.php';

    $fromUsername=$_GET["openid"];
    $sql = "SELECT `name`, `uid`, `time`, `endtime`, `pass`, `info` FROM `user_qingjia`";
    $res = _select_data($sql);
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
        ?>

        <tr>
            <td><?php echo $rows['name'] ?></td>
            <td><?php echo $rows['uid'] ?></td>
            <td><?php echo $rows['time'] ?></td>
            <td><?php echo $rows['endtime'] ?></td>
            <td><?php echo $rows['info'] ?></td>
            <td><?php echo $pass ?></td>
            <td><a href="http://wglpt.sinaapp.com/bd/xiugai.php?uid=<?php echo $rows['uid'] ?>">修改</a></td>
        </tr>

        <?php
    }
    ?>

</table>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
