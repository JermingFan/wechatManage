<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        用户编辑
    </title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
</head>
<body>
<table class="table table-hover">
    <tr>
        <th>工号</th>
        <th>姓名</th>
        <th>状态</th>
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

    $sql = "SELECT * FROM `user_info`";
    $res = _select_data($sql);
    while ($rows = mysql_fetch_array($res))
    {
        if ($rows['state'] == 1)
        {
            $state = '在职';
        }
        else
        {
            $state = '离职';
        }
        ?>

        <tr>
            <td><?php echo $rows['uid'] ?></td>
            <td><?php echo $rows['name'] ?></td>
            <td><?php echo $state ?></td>
            <td><a href="http://wglpt.sinaapp.com/yh/yhcz.php?id=<?php echo $rows['id'] ?>&uid=<?php echo $rows['uid'] ?>">编辑</a></td>        </tr>

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
