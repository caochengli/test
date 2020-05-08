<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController {
    
	public function index(){
       $catearr = categorytree();
	   //dump($catearr);
	   $this->assign('catearr',$catearr);
	   $this->display();
    }
	
	public function add(){
	   $catearr = categorytree();
	   //dump($catearr);
	   $this->assign('catearr',$catearr);
	   $this->display();
	}
	
	public function adduser(){
	   $M = M('admin_group');
	   $rsmm = $M->where('id <> 1')->select();
	   $this->assign('grouparr',$rsmm);
	   $this->display();
	}
	
	public function edit(){
	   $catearr = categorytree();
	   $id = I('get.id');
	   if(empty($id)){
	      $this->error('参数不足',U('/Role'));
	   }
	   $Model = M('admin_menu');
	   $rs = $Model->where('id='.$id)->find();
	   //$rs['focusid'] = $id;
	   $rsmm = $Model->where('pid='.$id)->find();
	   $isson = 0;
	   if($rsmm){
		  $isson = 1;
	   }
	   $rs['isson'] = $isson;
	   $this->assign('rs',$rs);
	   $this->assign('catearr',$catearr);
	   $this->display();
	}
	
	/*  user 
	 ## 用户列表
	 ## @return $rs [array]
	*/
	public function user(){
	   $Model = M('admin');
	   $rs = $Model->field('a.username username,a.id id,a.taxis taxis,a.islock islock,b.name name')->join(' as a LEFT JOIN __ADMIN_GROUP__ as b ON a.groupid=b.id')->where('b.id <> 1')->order('a.taxis desc,a.id desc') ->select();
	   $this->assign('userarr',$rs);
	   $this->display();
	}
	
	/*  usergroup 
	 ## 用户组列表
	 ## @return $rs [array]
	*/
	public function usergroup(){
	   $Model = M('admin_group');
	   //当前会员准入权限
	   $rs = $Model->where('id <> 1')->order('taxis desc,id desc') ->select();
	   $this->assign('usergrouparr',$rs);
	   $this->display();
	}
	
	/*  edituser 
	 ## 编辑用户
	 ## @return $rs [array]
	*/
	public function edituser(){
	   $Model = M('admin');
	   $id = I('get.id');
	   if(empty($id)){
	      $this->error('参数不足',U('/Role/user'));
	   }
	   $rs = $Model->where('id='.$id)->find();
	   $M = M('admin_group');
	   $rsmm = $M->where('id <> 1')->select();
	   $this->assign('rs',$rs);
	   $this->assign('grouparr',$rsmm);
	   
	   
	   $this->display();
	}
	
	/*  edituser 
	 ## 编辑用户
	 ## @return $rs [array]
	*/
	public function editusergroup(){
	   $Model = M('admin_group');
	   $id = I('get.id');
	   if(empty($id)){
	      $this->error('参数不足',U('/Role/usergroup'));
	   }
	   $rs = $Model->where('id='.$id)->find();
	   $this->assign('rs',$rs);
	   $this->display();
	}
	
	/*  insert 
	 ## 写入规则
	 ## @return $output [json]
	*/
	public function insert(){
	   $data = I('post.');
	   $pid = $data['pid'];
	   $Model = M('admin_menu');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }
	   $data['level'] = 0;
	   if($pid!=0){
	      $rs = $Model->field('level')->where('id='.$pid)->find();
	      $data['level'] = $rs['level']+1;
	   }
	   $isok = $Model->add($data);
	   if($isok){
		  $output = array('type'=>'ok','content'=>'新增规则成功','url'=>U('/Role')); 
	   }else{
	      $output = array('type'=>'error','content'=>'新增规则失败','url'=>U('/Role/add'));
	   }
	   echo json_encode($output);
	}
	
	/*  insertuser 
	 ## 新增用户
	 ## @return $output [json]
	*/
	public function insertuser(){
	   $data = I('post.');
	   $Model = M('admin');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }
	   $data['password'] = md5($data['password']);
	   $isok = $Model->add($data);
	   if($isok){
		  $output = array('type'=>'ok','content'=>'新增用户成功','url'=>U('/Role/user')); 
	   }else{
	      $output = array('type'=>'error','content'=>'新增用户失败','url'=>U('/Role/adduser'));
	   }
	   echo json_encode($output);
	}
	
	/*  insertusergroup
	 ## 新增用户组
	 ## @return $output [json]
	*/
	public function insertusergroup(){
	   $data = I('post.');
	   $Model = M('admin_group');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }	   
	   $isok = $Model->add($data);
	   if($isok){
		  $output = array('type'=>'ok','content'=>'新增用户组成功','url'=>U('/Role/usergroup')); 
	   }else{
	      $output = array('type'=>'error','content'=>'新增用组户失败','url'=>U('/Role/addusergroup'));
	   }
	   echo json_encode($output);
	}
	
	/*  update 
	 ## 编辑规则
	 ## @return $output [json]
	*/
	public function update(){
	   $data = I('post.');
	   $opid = I('get.pid');
	   $mid = I('get.id');
	   $pid = $data['pid'];
	   $Model = M('admin_menu');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }
	   //是否更新父栏目
	   if($opid != $pid){
		   //是否更新层级
		   if($pid!=0){
			  $rs = $Model->field('level')->where('id='.$pid)->find();
			  $data['level'] = $rs['level']+1;
		   }else{
		      $data['level'] = 0;
		   }
	   }
	   $isok = $Model->where('id='.$mid)->save($data);
	   if($isok !== false){
		  $output = array('type'=>'ok','content'=>'更新规则成功','url'=>U('/Role')); 
	   }else{
	      $output = array('type'=>'error','content'=>'更新规则失败','url'=>U('/Role/edit',array('id'=>$mid)));
	   }
	   echo json_encode($output);
	}
	
	/*  update 
	 ## 编辑规则
	 ## @return $output [json]
	*/
	public function updateuser(){
	   $data = I('post.');
	   $mid = I('get.id');
	   $Model = M('admin');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }
	   //是否更新密码
	   $rs = $Model->field('password')->where('id='.$mid)->find();
	   if($rs['password'] != $data['password']){
		  //更新密码
		  $updata['password'] = md5($data['password']);
	   }
	   $updata['groupid'] = $data['groupid'];
	   $updata['islock'] = $data['islock'];
	   $updata['taxis'] = $data['taxis'];
	   //$updata['regions'] = $data['regions'];
	   
	   $isok = $Model->where('id='.$mid)->save($updata);
	   if($isok !== false){
		  $output = array('type'=>'ok','content'=>'更新用户成功','url'=>U('/Role/user')); 
	   }else{
	      $output = array('type'=>'error','content'=>'更新用户失败','url'=>U('/Role/edituser',array('id'=>$mid)));
	   }
	   echo json_encode($output);
	}
	
	/*  updateusergroup 
	 ## 编辑用户组
	 ## @return $output [json]
	*/
	public function updateusergroup(){
	   $data = I('post.');
	   $mid = I('get.id');
	   $Model = M('admin_group');
	   if(empty($data['taxis'])){
	      $data['taxis'] = 0;
	   }	   
	   $isok = $Model->where('id='.$mid)->save($data);
	   if($isok !== false){
		  $output = array('type'=>'ok','content'=>'更新用户组成功','url'=>U('/Role/usergroup')); 
	   }else{
	      $output = array('type'=>'error','content'=>'更新用户失败','url'=>U('/Role/editusergroup',array('id'=>$mid)));
	   }
	   echo json_encode($output);
	}
	
	
	/*
	   ## 开放城市
	   ## opencity
	*/
	public function opencity(){
	   $Region = M('region');
	   $rs = $Region->where('region_type=2 and is_open=1')->select();
	   foreach($rs as $q){
	      $regstr .= "<input type='checkbox' name='regions[]' checked='checked' value='".$q['region_id']."' />".$q['region_name']."&nbsp;&nbsp;";
	   }
	   $this->assign('regstr',$regstr);
	   $this->display();
	}
	
	public function setCityConfig(){
	   $Region = M('region');
	   $regs = I('post.regions');
	   $reg = '';
	   $reg_p_s = '';
	   $reg_p = array();
	   $region_all = 0;
	   if(is_array($regs)){
	      foreach($regs as $i=>$q){		     
			 if($i > 0){
			    $reg .= ',';
			 }
			 $reg .= $q;
			 $region_p = $Region->where('region_id='.$q)->getField('parent_id');
			 if(!in_array($region_p, $reg_p, true)){
			    $reg_p[$i] = $region_p;
			 }
		  }
		  //dump($reg_p);
		  foreach($reg_p as $i=>$v){		     
			 if($i > 0){
			    $reg_p_s .= ',';
			 }
			 $reg_p_s .= $v;
		  }
	      $region_all = $reg.','.$reg_p_s;
	   }
	   //更新
	   $Region->where('region_id>0')->setField('is_open',0);
	   //更新
	   $Region->where("region_id in(".$region_all.")")->setField('is_open',1);
	   $this->success("开通城市配置成功",U('/Role/opencity'),3);
	   //dump($reg_p_s);
	}
	
	
	/*  siteconfig 
	 ## 网站配置
	 ## @return $output [json]
	*/
	public function siteconfig(){	   
	   $this->display();
	}
	public function updateconfig(){
	   $data = I('post.');
	   //dump($data);
	   $output = "<?php \n return array(\n";
	   foreach($data as $key=>$val){
		  $output .= "\n\t'" . $key . "'=>'" . $val . "',";
	   }
	   $output .= "\n);\n\n";
	   
	   $filepath = CONF_PATH.'config.site.php';
	   //echo $filepath;
	   $isok = file_put_contents ($filepath,$output);
	   if($isok !== 0){
	      //$this->success('配置更新成功',U('/Role/siteconfig'));
		  $dors = array('type'=>'ok','content'=>'配置更新成功','url'=>U('/Role/siteconfig'));
	   }else{
	      $dors = array('type'=>'error','content'=>'配置更新失败','url'=>U('/Role/siteconfig'));
	   }
	   echo json_encode($dors);
	}
	
	/*  sysconfig 
	 ## 网站配置
	 ## @return $output [json]
	*/
	public function sysconfig(){
	   //$this->assign ('SYS_PUT_PIC',C('SYS_PUT_PIC'));
	   //$this->assign ('SYS_TITLE',C('SYS_TITLE'));
	   $this->display();
	}
	public function updatesysconfig(){
	   $data = I('post.');
	   //dump($data);
	   $output = "<?php \n return array(\n";
	   foreach($data as $key=>$val){
		  $output .= "\n\t'" . $key . "'=>'" . $val . "',";
	   }
	   $output .= "\n);\n\n";
	   
	   $filepath = CONF_PATH.'config.sys.php';
	   //echo $filepath;
	   $isok = file_put_contents ($filepath,$output);
	   if($isok !== 0){
	      //$this->success('配置更新成功',U('/Role/siteconfig'));
		  $dors = array('type'=>'ok','content'=>'配置更新成功','url'=>U('/Role/sysconfig'));
	   }else{
	      $dors = array('type'=>'error','content'=>'配置更新失败','url'=>U('/Role/sysconfig'));
	   }
	   echo json_encode($dors);
	}
	
	/*  delete 
	 ## 删除规则
	 ## @return $output [json]
	*/
	public function delete(){
	   $id = I('get.id');
	   $tabel = I('get.tabel');
	   $back = I('get.back');
	   $Role = I('get.role');
	   if(empty($tabel)){
	      $tabel = 'admin_menu';
	   }
	   if(empty($Role)){
	      $Role = 'Role';
	   }
	   if(empty($back)){
	     $back = '/'.$Role;
	   }else{
		 $back = '/'.$Role.'/'.$back;
	   }
	   if(empty($id)){
	      $this->error('参数不足',U('/Index'));
	   }
	   $Model = M($tabel);
	   $isok = $Model->where('id='.$id)->delete();
	   if($isok !== false){
	      $output = array('type'=>'ok','content'=>'删除成功','url'=>U($back)); 		   
	   }else{
	      $output = array('type'=>'error','content'=>'删除失败','url'=>'');  
	   }
	   echo json_encode($output);
	}
	
	/*  updatetaxis 
	 ## 更新排序
	 ## @return $output [json]
	*/
	public function updatetaxis(){
	   $tabel = I('get.tabel');
	   $back = I('get.back');
	   $Role = I('get.role');
	   if(empty($Role)){
	      $Role = 'Role';
	   }
	   if(empty($back)){
	     $back = '/'.$Role;
	   }else{
		 $back = '/'.$Role.$back;  
	   }
	   if(empty($tabel)){
	      $output = array('type'=>'error','content'=>'参数不足,排序更新失败','url'=>U('/Index'));
		  echo json_encode($output);
		  die();
	   }
	   $idarr = I('post.idarray');
	   $taxarr = I('post.taxisArray');
	   $Model = M($tabel);
	   $updateok = 1;
	   foreach($idarr as $i => $fg){
		  $data['taxis'] = $taxarr[$i];
	      $isok = $Model->where('id='.$fg)->save($data);
		  if($isok === false){
		     $updateok = 0;
		  }
	   }
	   if($updateok == 0){
		  $output = array('type'=>'error','content'=>'排序更新失败','url'=>''); 
	   }else{
	      $output = array('type'=>'ok','content'=>'排序更新成功','url'=>U($back));
	   }
	   echo json_encode($output);
	}
	
	
	/*  getpowerjson 
	 ## 权限列表json
	 ## @return $data [json]
	*/
	public function getpowerjson(){
	   //header("Content-type:text/html;charset=utf-8");
	   $groupid = I('get.groupid');
	   
	   //操作者身份
	   //$gid = session('user.groupid');
	   
	   if(empty($groupid)){
		  echo 'error';
	   }
	   $pagelevel = getpagelevel($groupid);
	   $tree = categorytree('admin_menu');
	   //dump($tree);
	   foreach($tree as $i=>$rs){
	      $check = false;
		  if($this->checkit($pagelevel,$rs['id'])){
			 $check = true;  
		  }
		  if($groupid==1){ $check = true; }
		  //if($check){
			  $data[$i] = array(
				 'id' => $rs['id'],
				 'pId' => $rs['pid'],
				 'name' => $rs['name'],
				 'open' => true,
				 'checked' => $check
			  );
		  //}
	   }
	   $data = array_values($data);
	   echo json_encode($data);
	}
	
	/*  getcatejson 
	 ## 页面权限列表json
	 ## @return $data [json]
	*/
	public function getcatejson(){
	   //header("Content-type:text/html;charset=utf-8");
	   //echo 'error';
	   $groupid = I('get.groupid');
	   if(empty($groupid)){
		  echo 'error';
	   }
	   $catearr = getcatelevel($groupid);
	   $tree = categorytree('category');
	   //dump($tree);
	   
	   foreach($tree as $i=>$rs){
	      $check = false;   
		  if($this->checkit($catearr,$rs['id'])){
			 $check = true;  
		  }
		  if($groupid == 1){
		     $check = true;
		  }
		  $data[$i] = array(
		     'id' => $rs['id'],
			 'pId' => $rs['pid'],
		     'name' => $rs['catename'],
			 'open' => true,
			 'checked' => $check
		  );
	   }
	   $data = array_values($data);
	   echo json_encode($data);
	}
	
	/*  savepagelevel 
	 ## 更新权限列表
	 ## @return $data [json]
	*/
	public function savepagelevel(){
	   $id = I('get.groupid');
	   if($id == 1){
	      $output = array('type'=>'error','content'=>'系统不允许对该角色权限编辑','url'=>'');
		  echo json_encode($output);
		  die();
	   }
	   if(empty($id)){
	      $output = array('type'=>'error','content'=>'排序更新失败','url'=>'');
		  echo json_encode($output);   
	   }
	   $data = I('post.');
	   $Model = M('admin_group');
	   $isok = $Model->where('id='.$id)->save($data);
	   if($isok !== false){
		  $output = array('type'=>'ok','content'=>'页面权限更新成功','url'=>'');  
	   }else{
		  $output = array('type'=>'error','content'=>'排序更新失败','url'=>''); 
	   }
	   echo json_encode($output);
	}
	
	/*  savecatelevel 
	 ## 更新栏目权限列表
	 ## @return $data [json]
	*/
	public function savecatelevel(){
	   $id = I('get.groupid');
	   if(empty($id)){
	      $output = array('type'=>'error','content'=>'栏目权限更新失败','url'=>'');
		  echo json_encode($output);   
	   }else if($id == 1){
	      $output = array('type'=>'error','content'=>'您无权更新该角色权限','url'=>'');
		  echo json_encode($output);
		  return false;
	   }
	   $data = I('post.');
	   $Model = M('admin_group');
	   $isok = $Model->where('id='.$id)->save($data);
	   if($isok !== false){
		  $output = array('type'=>'ok','content'=>'栏目权限更新成功','url'=>'');  
	   }else{
		  $output = array('type'=>'error','content'=>'栏目权限更新失败','url'=>''); 
	   }
	   echo json_encode($output);
	}
	
	
	
	public function checkit($str1,$str2){
	   $arr = explode(',',$str1);
	   $bool = false;
	   foreach($arr as $q){
		  if($q==$str2){
		     $bool = true;
		  }
	   }
	   return $bool;
	}
	
	
	
	
}