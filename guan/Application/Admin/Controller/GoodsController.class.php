<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
	
	public function updateattr(){
	   $type = I('get.type');
	   $idarr = I('post.idarr');
	   $attrarr = I('post.attrarr');
	   $table = I('post.table');
	   if(empty($table)){
	      $table = 'content';
	   }
	   $data[$type] = 0;
	   //$do = explode();
	   $updateok = 1;
	   $Model = M($table);
	   foreach($idarr as $i=>$ids){
	      if($attrarr[$i] == 0){
		     $data[$type] = 1;
		  }
		  $isok = $Model->where('id='.$ids)->save($data);
		  if($isok === false){
		     $updateok = 0;
		  }
	   }
	   if($updateok){
	      $this->set_ajaxres('ok','更新成功','');
	   }
	   $this->ajaxReturn($this->ajaxres);
	   
	}

}