<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    
	private $User;
	
	public function _init(){
	   $this->User = M('user');
	}
	
	public function index(){
	   $kwd = I('post.title');
	   $condition = "islock=1";
	   if(!empty($kwd)){
	      $condition .= " and (a.telno like '%".$kwd."%' OR b.nickname like '%".$kwd."%' OR b.realname like '%".$kwd."%')";
	   }
	   $count = $this->User->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where($cond)->count('a.id');
	   
	   $Page = new \Think\Page($count,20);	   
	   $Page->parameter['title'] = urlencode($kwd);
	   $Page->setConfig('prev','上一页');
	   $Page->setConfig('next','下一页');
	   $pagination = $Page->show();
	   $this->assign('pagination',$pagination);
	   
	   $rs = $this->User->field('a.id,a.telno,a.islock,b.face,b.nickname,b.cardno,b.address,b.qrcode,b.realname')->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
	   
	   $this->assign('rslist',$rs);
	   
	   //$this->assign('pagination',$pagination);
	   $this->display();
	}
	
	public function addUser(){
	   $this->display();
	}
	
	public function insUser(){
	   $data = I('post.');
	   $UserData = array(
	      'telno' => $data['telno'],
		  'password' => $data['password']
	   );
	   $rs = $this->User->where("telno='".$data['telno']."'")->find();
	   if($rs){
	      $this->error("添加会员失败,手机号已被注册",U('/User/addUser'),5);
	   }
	   $UserInfoData = array(
	      'face' => $data['face'],
		  'nickname' => $data['nickname'],
		  'cardno' => $data['cardno'],
		  'address' => $data['address'],
		  'realname' => $data['realname']
	   );
	   $isok = $this->User->add($UserData);
	   if($isok){
	      $UserInfoData['uid'] = $isok;
		  $M = M('user_info');
		  $M->add($UserInfoData);
	   }else{
	      $this->error("添加会员失败",U('/User/addUser'),5);
	   }
	   $this->success("添加会员成功",U('/User/index'),5);
	}
	
	public function editUser($id){
	   $rs = $this->User->field('a.*,b.face,b.nickname,b.cardno,b.address,b.qrcode,b.realname')->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where('a.id='.$id)->find();
	   $this->assign('rsshow',$rs);
	   $this->display();
	}
	
	public function delUser(){
	   $idarr = I('post.');
	   if(is_array($idarr)){
	      foreach($idarr as $i => $q){
		     if($i > 0){
			    $p .= ",";
			 }
			 $p .= $q;
		  }
		  $idarr = $p;
	   }
	   $M = M('user_info');
	   $M->where('uid in('.$idarr.')')->delete();
	   $this->User->where('id in('.$idarr.')')->delete();
	   $this->set_ajaxres('ok','删除成功','');
	   $this->ajaxReturn($this->ajaxres);
	}
	
	public function updateUser($id){
	   $data = I('post.');
	   $UserData = array(
	      'telno' => $data['telno'],
		  'password' => $data['password']
	   );
	   $UserInfoData = array(
	      'face' => $data['face'],
		  'nickname' => $data['nickname'],
		  'cardno' => $data['cardno'],
		  'address' => $data['address'],
		  'realname' => $data['realname']
	   );
	   $rs = $this->User->field('a.*,b.face,b.nickname,b.cardno,b.address,b.qrcode,b.realname')->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where('a.id='.$id)->find();
	   foreach($rs as $key=>$val){
	      if($UserInfoData[$key] == $val){
		     unset($UserInfoData[$key]);
		  }
		  if($UserData[$key] == $val){
		     unset($UserData[$key]);
		  }
	   }
	   if(count($UserData) > 0){
	      $this->User->where('id='.$id)->save($UserData);
	   }
	   if(count($UserInfoData) > 0){
	      $M = M('user_info');
		  $M->where('uid='.$id)->save($UserInfoData);
	   }
	   $this->success("编辑会员成功",U('/User/index'),5);
	}
	
	public function qrcode(){
	   $save_path = isset($_GET['save_path'])?$_GET['save_path']:'Public/qrcode/';  //图片存储的绝对路径
       
	   $web_path = isset($_GET['save_path'])?$_GET['web_path']:'/Public/qrcode/';        //图片在网页上显示的路径
       
	   $qr_data = isset($_GET['qr_data'])?$_GET['qr_data']:'http://www.zetadata.com.cn/';
       
	   $qr_level = isset($_GET['qr_level'])?$_GET['qr_level']:'Q';
       
	   $qr_size = isset($_GET['qr_size'])?$_GET['qr_size']:'6';
       
	   $save_prefix = isset($_GET['save_prefix'])?$_GET['save_prefix']:'ZETA';
       
	   if($filename = createQRcode($save_path,$qr_data,$qr_level,$qr_size,$save_prefix)){
            $pic = $web_path.$filename;       
	   }
       
	   echo "<img src='".$pic."'>";	
	}
	
}