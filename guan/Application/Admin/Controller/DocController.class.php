<?php
namespace Admin\Controller;
use Think\Controller;
class DocController extends CommonController {	
	
	/*
	  ## upimg
	  ## 图像上传
	*/
	public function upimg(){
	   $path = '/UpLoadFile/image/';
	   //header("Content-type: text/html; charset=utf-8");
	   //dump($_FILES['fm1']);
	   $fileinput = I('get.someKey');
	   $imgarea = I('get.otherKey');
	   //$fileinput1 = I('post.someKey');
	   $isup = '';
	   $upconf = array(
	      "exts" => array('jpg','gif','pdf','rar','zip','png','jpeg'),
		  'rootPath' => './UpLoadFile/image/'
	   );
	   //实例化文件上传类
	   $Upload = new \Think\Upload($upconf);
	   //检验无刷新上传
	   //$verifyToken = md5('unique_salt' . $_POST['timestamp']);
	   if (!empty($_FILES)) {
	      //执行文件上传
		  //die('abc');
		  $isup = $Upload->upload();
		  //dump($isup);
	   }
	   if(!empty($isup)){
		  $path = $path . $isup['the_files']['savepath'] . $isup['the_files']['savename'];
		  $msg = array(
		     'type' => 'ok',
			 'filepath' => $path,
			 'fileinput' => $fileinput,
			 'imgarea' => $imgarea
		  );
	   }else{
	      $msg = array(
		     'type' => 'error',
			 'message' => '文件上传失败'
		  );
	   }
	   echo json_encode($msg);
	   //$this->ajaxReturn($msg);
	}
	
}