<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    
	//protected $UserInfo;


	protected $ajaxres;
	protected $Pic;
	protected $Help;
		
	public function _initialize(){
	   //登录状态验证
	   if(!CheckSession()){
	      Redirect(U("/Login"));
	   }
	   $this->Help = A('Help');
	   $this->Pic = M('pic_arr');
	   //do nothing
	   $this->ajaxres = array(
	      'type' => 'error',
		  'msg' => '操作失败',
		  'url' => ''
	   );
	   //nav
	   $navbar = $this->ControlNav();
	   $this->assign('navbar',$navbar);
	   //会员信息
	   $UserInfo = session('UserInfo');
	   //dump($this->UserInfo);
	   $this->assign('userinfo',$UserInfo);
	   //弹窗内容
	   $this->_init();
	}
	
	public function _init(){
	   
	}

    public function clearCache(){
        $is_clear = delDirAndFile('./Application/Runtime/');
        $this->ajaxReturn($is_clear);
    }
	
	/*
	  ## GetSonArr
	  ## @param int $id 父类ID
	  ## @return string $str 子类ID序列字符串
	*/
	public function GetSonArr($id,$tp=0){
	   static $idarr;
	   if($tp == 0){
	      $idarr = "";
		  $tp++;
	   }
	   $Cate = M('category');
	   $rs = $Cate->field('id')->where('pid='.$id)->select();
	   if($rs){
	      foreach($rs as $i => $q){
		     $idarr .= $q['id'].',';
			 $this->GetSonArr($q['id'],$tp);
		  }
	   }
	   $str = $idarr.$id;
	   return $str;
	}
	
	public function set_ajaxres($type,$content,$url){
	   $this->ajaxres = array(
	      'type' => $type,
		  'msg' => $content,
		  'url' => $url
	   );
	}
	
	/*
	  ## ControlNav
	  ## 功能菜单
	*/
	public function ControlNav(){
	   $groupid = session('user.groupid');
	   $Model = M('admin_menu');
	   if($groupid != 1){
	      //非系统管理员
		  $pagelevel = getpagelevel($groupid);
	   }
	   //return $pagelevel;
	   $condition = '1=1';
	   if(!empty($pagelevel)){
		  //return $pagelevel; 
		  $condition .= " and id in(".$pagelevel.")";
	   }
	   $rs = $Model->where($condition)->order('pid asc,taxis desc')->select();
	   //序列化菜单
	   foreach($rs as $q){
		  if(empty($q['icon'])){
		     $icon = 'fa-circle-o';
		  }else{
		     $icon = $q['icon'];
		  }
		  $url = U('/'.$q['role']);
		  $menu[$q['id']] = array(
			 'id' => $q['id'],
			 'pid' => $q['pid'],
		     'name' => $q['name'],
			 'role' => $q['role'],
			 'icon' => $icon,
			 'isc' => $q['isc'],
			 'url' => $url
		  );
		  //$m[$q['id']] = $q;
	   }	   
	   //print_r($menu);
	   $ret = array();
	   foreach($menu as $q){
		  if(isset($menu[$q['pid']])){
	         $menu[$q['pid']]['submenu'][] = &$menu[$q['id']];
		  }else{
		     $ret[] = &$menu[$q['id']];
		  }
	   }
	   return $ret;
	}
	
	public function GPSon($id,$idarr){
	   static $res;
	   $M = M('category');	
	   $condition = "pid=".$id;  
	   if(!empty($idarr) && session('user.groupid')!=1){
	      $condition .= " and id in(".$idarr.")";
	   }
	   $rs = $M->field('id,pid,catename,level')->where($condition)->select();
	   if($rs){
	      foreach($rs as $q){
		     $res[] = $q;
		     $this->GPSon($q['id'],$idarr);
		  }
	   }
	   //return $res;
	   //$res[] = $id;
	   return $this->indexGPSon($res);
	}
	
	public function indexGPSon($res){
	   foreach($res as $q){
	      $cate_sort[$q['level']][$q['pid']][$q['id']] = $q;
	   }	   	   
	   $ret = array();
       foreach($cate_sort as $level=>$sort_fid){            
			foreach ($sort_fid as $fid => $childs) {                
				if ($fid == 0) {
                    $ret = $ret + $childs;
                } else {
                    $ret = insert_after($ret, $fid, $childs);
                }
            }
       }
	   return $ret;
	}
	
	public function GetTopId($id){
	   static $pid;
	   $Model = M('Category');
	   $rs = $Model->field('id,pid')->where('id='.$id)->find();
	   if($rs){
	      if($rs['pid'] != 0){
		     $this->GetTopId($rs['pid']);
		  }else{
		     $pid = $rs['id'];
		  }
	   }
	   return (int)$pid;  
	}
	
	/**
	  ## delrs
	  ## ……
	**/
	public function delrs(){
	   $idarr = I('post.idarr');
	   $table = I('post.table');
	   if(empty($table)){
	      $this->set_ajaxres('error','未指定删除表','');
		  $this->ajaxReturn($this->ajaxres);
	   }
	   $M = M($table);
	   if(is_array($idarr)){
	      foreach($idarr as $i => $q){
		     if($i > 0){
			    $p .= ",";
			 }
			 $p .= $q;
		  }
		  $idarr = $p;
	   }
	   $isok = $M->where("id in(".$idarr.")")->delete();
	   if($isok){
	      $this->set_ajaxres('ok','删除成功','');
	   }
	   $this->ajaxReturn($this->ajaxres);
	}
	
	/**
	 * @param null $data
	 * @return array|mixed|null
	 * Function descript: 过滤post提交的参数；
	 *
	*/
	public function checkDataPost($data=null){
	   if(!empty($data)){
	      $data = explode(',',$data);
		  foreach($data as $v){
			  if((!isset($_POST[$v]))||(empty($_POST[$v]))){
				if($_POST[$v]!==0 && $_POST[$v]!=='0'){
				  //$this->returnApiError('-1','invalid '.$v.' value');
				  return false;
				}
			  }
		  }
		  unset($data);
		  $data = I('post.');
		  //unset($data['_URL_'],$data['token']);
		  return $data;
	   }
	}
	
	/**
	 * @param null $data
	 * @return array|mixed|null
	 * Function descript: 过滤post提交的参数；
	 *
	*/
	public function checkDataGet($data=null){
	   if(!empty($data)){
	      $data = explode(',',$data);
		  foreach($data as $v){
			  if((!isset($_GET[$v]))||(empty($_GET[$v]))){
				if($_GET[$v]!==0 && $_GET[$v]!=='0'){
				  //$this->returnApiError('-1','invalid '.$v.' value');
				  return false;
				}
			  }
		  }
		  unset($data);
		  $data = I('get.');
		  //unset($data['_URL_'],$data['token']);
		  return $data;
	   }
	}
	
	public function listPaging($arr,$tab,$unio=0){
	   $parr = $arr;
	   //$rule = array('cid'=>'c');
	   $M = M($tab);
	   $condition = '1=1';
	   $cond = '1=1';
	   unset($parr['page']);
	   $maps = array();
	   
	   foreach($parr as $key => $val){
	      if($key == 'title' && !empty($val)){		     
			 $condition .= " and a.title like '%".$val."%'";
			 $cond .= " and title like '%".$val."%'";
		  }else{
		     if($val >= 0 && $val != ''){
		        $condition .= " and a.".$key."=".$val;
				$cond .= " and ".$key."=".$val;
		     }
		  }
		  $maps[$key] = urldecode($val);
	   }
	   
	   $count = $M->where($cond)->count();
	   $Page = new \Think\Page($count,20);
	   foreach($maps as $key=>$val) {
	      $Page->parameter[$key] = urlencode($val);
	   }
	   $Page->setConfig('prev','上一页');
	   $Page->setConfig('next','下一页');
	   $pagination = $Page->show();
	   $this->assign('pagination',$pagination);
	   if($unio == 0){
	      return $cond;
	   }
	   return $condition;
	}
	
	public function getOptSearch(){
	   $parr = I('param.');
	   $page = $parr['page'];
	   $tab = $parr['table'];
	   $field = $parr['field'];
	   $key = $parr['key'];
	   $pagesize = 20;
	   $M = M($tab);
	   if($tab == 'house'){
	       $cond = 'a.'.$field." like '%".$key."%' OR b.telno like '%".$key."%'";
		   $firstRow = ($page-1)*$pagesize;  
		   $total_count = $M->field('a.id')->join(' as a LEFT JOIN __USER__ as b ON a.uid=b.id')->where($cond)->count();
		   $rs = $M->field('a.id,a.'.$field.',b.telno')->join(' as a LEFT JOIN __USER__ as b ON a.uid=b.id')->where($cond)->limit($firstRow,$pagesize)->select();
		   $res = array(
			  'total_count' => $total_count,
			  'items' => ''
		   );
		   foreach($rs as $i => $q){
			  $res['items'][$i]['id'] = $q['id'];
			  $res['items'][$i]['text'] = $q[$field].'('.$q['telno'].')';
		   }
	   }else if($tab == 'user'){
	       $cond = 'a.'.$field." like '%".$key."%' OR b.realname like '%".$key."%' OR b.nickname like '%".$key."%'";
		   $firstRow = ($page-1)*$pagesize;  
		   $total_count = $M->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where($cond)->count('a.id');
		   $rs = $M->field('a.id,a.'.$field.',b.realname')->join(' as a LEFT JOIN __USER_INFO__ as b ON a.id=b.uid')->where($cond)->limit($firstRow,$pagesize)->select();
		   $res = array(
			  'total_count' => $total_count,
			  'items' => ''
		   );
		   foreach($rs as $i => $q){
			  $res['items'][$i]['id'] = $q['id'];
			  $res['items'][$i]['text'] = $q[$field].'('.$q['realname'].')';
		   }
	   }else{
		   $cond = $field." like '%".$key."%'";
		   $firstRow = ($page-1)*$pagesize;	   
		   $total_count = $M->where($cond)->count();
		   $rs = $M->field('id,'.$field)->where($cond)->limit($firstRow,$pagesize)->select();
		   $res = array(
			  'total_count' => $total_count,
			  'items' => ''
		   );
		   foreach($rs as $i => $q){
			  $res['items'][$i]['id'] = $q['id'];
			  $res['items'][$i]['text'] = $q[$field];
		   }
	   }
	   $this->ajaxReturn($res);
	}
	
	public function getPicArrayData($imgName){
	   $picarr = I('post.'.$imgName);
	   $titarr = I('post.'.$imgName.'_title');
	   $conarr = I('post.'.$imgName.'_desc');
	   $txsarr = I('post.'.$imgName.'_taxis');
	   $imgData = array();
	   if(is_array($picarr)){
		  foreach($picarr as $i => $q){
		     $imgData[$i] = array(
				'pic' => $q,
				'title' => $titarr[$i],
				'content' => $conarr[$i],
				'taxis' => $txsarr[$i]
			 );
		  }
	   }
	   return $imgData;
	}

	public function getPicArrayEdit($id){
	   $rspic = $this->Pic->field('title,content,taxis,pic')->where('sid='.$id)->order('taxis desc,id desc')->select();
	   return $rspic;
	}
	
	public function ArrayToString($arr,$sep){
	   $str = '';
	   foreach($arr as $q){
	      if(!empty($str)){
		     $str .= $sep;
		  }
		  $str .= $q;
	   }
	   return $str;
	}
}