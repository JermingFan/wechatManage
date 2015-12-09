<?php
require_once '../sql.php';

function _yhxx()
{
	$sql = "SELECT * FROM `user_info`";
	$res = _select_data($sql);
	$arr = array();
	while ($rows = mysql_fetch_array($res))
	{
		if ($rows['state'] == 1)
		{
			$state = '在职';
		}
		else
		{
			$state = '其他';
		}
		$v=''.'2222222'.'';
	}
	return $v;

}
?>