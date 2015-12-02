<?php
header("Content-type: text/html; charset=utf-8");
define("ACCESS_TOKEN", "UAGfmDPD8PbV264AU2zR3NLKPyQ-D6ffc2NxDjqO09SoNacaKzZorlJHU3Ne-4GXbp1RM-jQi6ZyHK3WK-E-CfO9L0f0gQYMGcneal5Q9t8RCOaAGABMY");


//创建菜单
function createMenu($data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
		return curl_error($ch);
	}

	curl_close($ch);
	return $tmpInfo;

}

//获取菜单
function getMenu(){
	return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
}

//删除菜单
function deleteMenu(){
	return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
}

$data = '{
	"button":[
	{
		"type":"click",
		"name":"首页",
		"key":"home"
	},
	{
		"type":"click",
		"name":"首页",
		"key":"home"
	},
	{
		"name":"菜单",
		"sub_button":[
		{
			"type":"click",
			"name":"hello word",
			"key":"V1001_HELLO_WORLD"
		},
		{
			"type":"click",
			"name":"赞一下我们",
			"key":"V1001_GOOD"
		}]
	}]
}';

echo createMenu($data);