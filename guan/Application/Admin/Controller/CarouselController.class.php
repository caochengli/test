<?php
namespace Admin\Controller;
use Think\Controller;
class CarouselController extends CommonController {
	
	public function index(){
       $rs = $this->getlist();
	   //dump($catearr);
	   $this->assign('list',$rs);
	   $this->display();
    }
	
	/*  getlist 
	 ## 全部幻灯
	 ## @return $rs
	*/
	public function getlist(){
	   $Model = M('carousel');
	   $rs = $Model->field('a.*,b.name')->join('as a LEFT JOIN __CAROUSEL_GROUP__ as b on a.groupid=b.id')->select();
	   if($rs){
	      return $rs;
	   }
	}
	
	/*  group 
	 ## 幻灯位置列表
	 ## @return $rs
	*/
	public function group(){
       $rs = $this->getgroup();
	   //dump($catearr);
	   $this->assign('list',$rs);
	   $this->display();
    }
	
	/*  getgroup 
	 ## 全部幻灯位置 option
	 ## @return $rs
	*/
	public function getgroup(){
	   $Model = M('carousel_group');
	   $rs = $Model->select();
	   if($rs){
	      return $rs;
	   }
	}
	
	/*  add 
	 ## 新增幻灯
	 ## @return empty
	*/
	public function add(){
	   $catearr = $this->getgroup();
	   //dump($catearr);
	   $this->assign('catearr',$catearr);
	   $this->display();
	}
	
	/*  addgroup
	 ## 新增幻灯
	 ## @return empty
	*/
	public function addgroup(){
	   $this->display();
	}
	
	/*  edit 
	 ## 编辑分类
	 ## @return empty
	*/
	public function edit(){
	   $id = I('get.id');
	   if(empty($id)){
	      $this->error('抱歉，参数不完整，操作失败！',U('/Carousel'),5);
	   }
	   
	   $catearr = $this->getgroup();
	   $this->assign('catearr',$catearr);
	   
	   $Model = M('carousel');
	   $rs = $Model->where('id='.$id)->find();
	   $this->assign('rs',$rs);
	   $this->display();
	}
	
	/*  editgroup 
	 ## 编辑幻灯位置
	 ## @return empty
	*/
	public function editgroup(){
	   $id = I('get.id');
	   if(empty($id)){
	      $this->error('抱歉，参数不完整，操作失败！',U('/Carousel/group'),5);
	   }
	   $Model = M('carousel_group');
	   $rs = $Model->where('id='.$id)->find();
	   $this->assign('rs',$rs);
	   $this->display();
	}
	
	/*  insert 
	 ## 写入分类
	 ## @return empty
	*/
	public function insert(){
	   //$this->success('操作失败',U('/Category'),50);
	   $data = I('post.');
	   $Model = M('Carousel');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }
	   $isok = $Model->add($data);
	   if($isok){
		  $output = array('type'=>'ok','content'=>'新增幻灯成功','url'=>U('/Carousel'));
	   }else{
	      $output = array('type'=>'error','content'=>'新增幻灯失败','url'=>U('/Carousel/add'));
	   }
	   $this->ajaxReturn($output);
	}
	
	/*  insert 
	 ## 写入分类
	 ## @return empty
	*/
	public function insertgroup(){
	   //$this->success('操作失败',U('/Category'),50);
	   $data = I('post.');
	   $Model = M('carousel_group');
	   
	   $isok = $Model->add($data);
	   if($isok){
		  $output = array('type'=>'ok','content'=>'新增幻灯位置成功','url'=>U('/Carousel/group'));
	   }else{
	      $output = array('type'=>'error','content'=>'新增幻灯位置失败','url'=>U('/Carousel/addgroup'));
	   }
	   //echo json_encode($output);
	   $this->ajaxReturn($output);
	}
	
	/*  update 
	 ## 更新分类
	 ## @return empty
	*/
	public function update(){
	   $data = I('post.');	   
	   $Model = M('Carousel');
	   //die($data['pagesize']);
	   $mid = (int)$data['doid'];
	   if(empty($mid)){
	      $this->error('抱歉，参数不完整，操作失败！',U('/Carousel'),5);
	   }
	   $isok = $Model->where('id='.$mid)->save($data);
	   if($isok !== false){
	      $output = array('type'=>'ok','content'=>'编辑幻灯成功','url'=>U('/Carousel'));
	   }else{
	      $output = array('type'=>'error','content'=>'编辑幻灯失败','url'=>'');
	   }
	   $this->ajaxReturn($output);
	}
	
	/*  updategroup 
	 ## 更新分类
	 ## @return empty
	*/
	public function updategroup(){
	   $data = I('post.');	   
	   $Model = M('Carousel_group');
	   //die($data['pagesize']);
	   $mid = (int)$data['doid'];	   
	   if(empty($mid)){
	      $this->error('抱歉，参数不完整，操作失败！',U('/Carousel/group'),5);
	   }
	   $isok = $Model->where('id='.$mid)->save($data);
	   if($isok !== false){
	      $output = array('type'=>'ok','content'=>'编辑幻灯位置成功','url'=>U('/Carousel/group'));
	   }else{
	      $output = array('type'=>'error','content'=>'编辑幻灯位置失败','url'=>'');
	   }
	   $this->ajaxReturn($output);
	}
	
	public function delgroup(){
	   
	   $idarr = I('post.idarr');
	   $M = M('Carousel_group');
	   $MC = M('Carousel');
	   if(is_array($idarr)){
	      foreach($idarr as $i => $q){
		     if($i > 0){
			    $p .= ",";
			 }
			 $p .= $q;
		  }
		  $idarr = $p;
	   }
	   $M->where("id in(".$idarr.")")->delete();
	   $MC->where("groupid in(".$idarr.")")->delete();
	   
	   $output = array('type'=>'ok','msg'=>'删除幻灯位置成功','url'=>'');
	   
	   $this->ajaxReturn($output);
	   
	}
	public function delads(){
	   
	   $idarr = I('post.idarr');
	   $MC = M('Carousel');
	   if(is_array($idarr)){
	      foreach($idarr as $i => $q){
		     if($i > 0){
			    $p .= ",";
			 }
			 $p .= $q;
		  }
		  $idarr = $p;
	   }
	   $MC->where("id in(".$idarr.")")->delete();
	   $output = array('type'=>'ok','msg'=>'删除幻灯成功','url'=>'');	   
	   $this->ajaxReturn($output);
	   
	}
}