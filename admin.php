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
        <th>权限</th>
        <th>操作</th>
    </tr>

    <?php
    /**
     * Created by PhpStorm.
     * User: Fancy
     * Date: 15.12.9
     * Time: 17:22
     */
    require_once './sql.php';

    $sql = "SELECT i.`name`, i.`uid`, i.`job`, b.`type`, b.`from_user` FROM `user_info` i , `user_bangding` b WHERE i.`uid` = b.`uid`";
    $res = _select_data($sql);
    while ($rows = mysql_fetch_array($res))
    {
        if ($rows['type'] == 0)
        {
            $qx = '普通';
        }
        else
        {
            $qx = '高级';
        }
        ?>

        <tr>
            <td><?php echo $rows['name'] ?></td>
            <td><?php echo $rows['uid'] ?></td>
            <td><?php echo $qx ?></td>
            <td><a href="http://wglpt.sinaapp.com/adminEdit.php?uid=<?php echo $rows['uid'] ?>">修改</a></td>
        </tr>

        <?php
    }
    ?>
    <a href="http://wglpt.sinaapp.com/adminAdd.php" type="submit" class="btn btn-success btn-block">添加</a>

</table>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
