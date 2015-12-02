<?php
require_once '../sql.php';
require_once '../wx_index.php';

function _jiebang($textTpl, $fromUsername, $toUsername, $time)
{
	$sql = "SELECT * FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
	$res = _select_data($sql);
	if(!empty($res))
	{
		$sql = "DELETE FROM `user_bangding` WHERE `from_user` = '$fromUsername'";
		$res = _delete_data($sql);

		if($res == 1)
		{
			$msgType = "text";
			$contentStr = '解绑工号成功~';
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}
		else
		{
			$msgType = "text";
			$contentStr = '解绑工号失败~';
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}

	}
	else
	{
		$msgType = "text";
		$contentStr = '还未绑定工号~';
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		echo $resultStr;
	}
}

?>