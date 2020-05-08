<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    
	public function index(){
       $this->display();
    }
   
   /** 
	* CheckLogin  
	* 用户登录判断
	* @return json 
   */
   public function CheckLogin(){
      $Group = M('admin_group');
	  $Admin = M("Admin");	  
	  $condition['username'] = I("post.username");
	  $condition['password'] = md5(I("post.password"));	  
	  $rs = $Admin->where($condition)->find();	  
	  if($rs){
	     session("islogin",1);
		 session("user.username",$rs["username"]);
		 session("user.userid",$rs["id"]);
		 session("user.groupid",$rs["groupid"]);
		 $catelev = $Group->where('id='.$rs['groupid'])->getField('catearr');
		 session("user.catelev",$catelev);
		 session("UserInfo",$rs);
		 //查询组名
		 $Model = M('admin_group');
		 $rsmm = $Model ->field('name')->where('id='.$rs['groupid'])->find();
		 session("user.groupname",$rsmm['name']);
		 $back = array("type"=>"ok","content"=>"登陆成功","url"=>U('/Index'));
	  }else{
	     $back = array("type"=>"error","content"=>"用户名或密码错误","url"=>"");
	  }
	  //echo json_encode($back);
	  $this->ajaxReturn($back);
   }
   
   /** 
	* logout  
	* 用户退出
	* @return redirect 
   */
   public function logout(){
      session(NULL);
	  $back = array("type"=>"ok","content"=>"退出成功","url"=>U("/Login"));
	  $this->ajaxReturn($back);
	  //redirect(U("/Login"));
   }
	
}