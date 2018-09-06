<?php
/**
 * 二维码.
 * User: ccl
 * Date: 2018/6/5
 * Time: 16:56
 */

$midpic = 'http://localhost/github/test/ewm2.php?studio_name=物流员'; //
$url = 'http://m.iwowke.cn/deliver?regjobid=70&regmemberid=73';

$qr = 'http://file.iwowke.cn/img/ewm?url='.urlencode($url).'&middlepic='.$midpic.'&size=20';
echo '<img src="'.$qr.'">';
exit;


if(isset($_POST) && $_POST){
    $studio_id = $_POST['studio_id'];//工作室ID
    $studio_name =$_POST['studio_name']; // 工作室名称
    if(!$studio_id || !$studio_name ){
        exit("params is error");
    }
    $logo_url = "http://localhost/github/test/ewm2.php?studio_name={$studio_name}";//生成工作室logo的访问url地址
    $erweima = "erweima";//所有的二维码保存的路径
    $studio_logo_path = $erweima."/{$studio_id}"; //工作室的图片的路径
    $logo = $studio_logo_path."/studio_logo_{$studio_id}.png"; //工作室的logo文件名字

    $errorCorrectionLevel = 'H';//容错级别
    $matrixPointSize = 10;//生成图片大小
    $QR = $studio_logo_path."/studio_qrcode.png";//已经生成的原始二维码图
    $studio_new_qr = $studio_logo_path."/studio_new_qr.png" ; //新的二维码 ， logo和原始的二维码结合起来组成的
    $value = 'http://m.iwowke.cn/deliver?regjobid=70&regmemberid=73'; //二维码内容
    $errorCorrectionLevel = 'H';//容错级别
    $matrixPointSize = 10;//生成图片大小
    include 'common_function.php';

    if(!file_exists($erweima."/{$studio_id}")){
        mkdir($erweima."/{$studio_id}");
    }


    include 'extension/phpqrcode.php';

    QRcode::png($value, $QR, $errorCorrectionLevel, $matrixPointSize, 2);
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    var_dump($logo);exit;
    $QR_width = imagesx($QR);//二维码图片宽度
    $QR_height = imagesy($QR);//二维码图片高度
    $logo_width = imagesx($logo);//logo图片宽度
    $logo_height = imagesy($logo);//logo图片高度
    $logo_qr_width = $QR_width / 2;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    //重新组合图片并调整大小
    imagecopyresampled($QR, $logo, $from_width, $from_width+36, 0, 0, $logo_qr_width,
        $logo_qr_height, $logo_width, $logo_height); //可以调整logo的位置
    //输出图片

    header("Content-type: image/png");

    ImagePng($QR);

}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<form action="" method="post" name="">
    工作室ID：<input name="studio_id">
	<br />
	工作室名称:<input type="text" name="studio_name">
	<br />
	<input type="submit" name="" value="生成二维码">
</form>