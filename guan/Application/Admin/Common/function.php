<?php
    
	function CheckSession(){
	   if(!session("?islogin")){
	      //$this->error("抱歉，您尚未登录",U("/Admin/Login"));
		  return false;
	   }
	   return true;
    }
	
	function repic($str=''){
	   return empty($str)?'/UpLoadFile/image/2017-04-07/58e7154d0a584.jpg':$str;
	}
	
	function emnick($str){//昵称转换
	   $str = str_replace("\"","",$str);
	   $str = '{"result_str":"'.$str.'"}'; //JSON格式
       $strarray = json_decode($str,true);
       return $strarray['result_str'];
	}
	
	function nickname($str){
	   $tmpStr = json_encode($str);
	   $tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie", "addslashes('\\1')", $tmpStr);  
	   return $tmpStr;
	}

/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function delDirAndFile($path, $delDir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
    return true;
}
	
	function pidarr($id){
	   static $pidarr;
	   $Model = M('Category');
	   $rs = $Model->field('id,pid')->where('id='.$id)->find();
	   if($rs){
	      if($rs['pid'] != 0){
		     $pidarr .= ','.$rs['pid'];
			 pidarr($rs['pid']);
		  }
	   }
	   return $pidarr;  
	}
	
    /*  Categorytree   
	 ## 分类树 
	 ## 加载分类表所有分类，并序列化为一维数组
	 ## @return $ret Array
    */
	function categorytree($table = 'admin_menu'){
	   $Model = M($table);
	   $condition = "1=1";
	   $groupid = session('user.groupid');
	   if($groupid != 1){	      
		  if($table == 'admin_menu'){
		     $condition .= " and islock=0";
			 $pagelevel = getpagelevel($groupid);
			 $condition .= " and id in(".$pagelevel.")";
		  }
	   }
	   $rowlist = $Model->where($condition)->order('pid asc,taxis desc')->select();
	   foreach($rowlist as $q){
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
	
	/*  insert_after   
	 ## 数组排序
	 ## @return $before+$insert+$after [array]
    */
	function insert_after($arr, $key, $insert){
	    
		$position = array_search($key, array_keys($arr));
        if($position===false){
           $position = count($arr); 
        }else{
           $position++;
        }
        $before = array_slice($arr, 0, $position, true);
        $after  = array_slice($arr, $position, null, true);
        return $before+$insert+$after;	
			
	}
	
	/*  setmenu   
	 ## 后台操作菜单
	 ## @return $menuarr [array]
    */
	function setcate($focusid){
	   $groupid = session('user.groupid');
	   $Model = M('category');
	   if($groupid != 1){
	      //非系统管理员
		  $catelevel = getcatelevel($groupid);
	   }
	   //return $pagelevel;
	   $condition = '1=1';
	   if(!empty($catelevel)){
		  //return $pagelevel; 
		  $condition .= " and id in(".$catelevel.")";
	   }
	   //dump($condition);
	   $rs = $Model->where($condition)->order('pid asc,taxis desc')->select();
	   //序列化菜单
	   if(!empty($focusid)){
	      $pidarr = pidarr($focusid);
	      $pidarr = $focusid.$pidarr;
	      $pidarr = explode(',',$pidarr);
	   }
	   	   
	   foreach($rs as $q){
		  $url = U('/Content/article',array('id'=>$q['id']));
		  if($q['model'] == 0){
		     $url = U('/Content/page',array('id'=>$q['id']));
		  }
		  if($q['model'] == 2){
		     continue;
		  }
		  if(in_array($q['id'],$pidarr)){
		     $cls = 'active';
		  }else{
		     $cls = 'neq';
		  }
		  $menu[$q['id']] = array(
			 'id' => $q['id'],
			 'pid' => $q['pid'],
			 'cls' => $cls,
		     'name' => $q['catename'],
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
	
	function getpagelevel($groupid = 0){
	   $Model = M('admin_group');
	   $rs = $Model->field('pagelevel')->where('id='.$groupid)->find();
	   if($rs !== false){
	      return $rs['pagelevel'];
	   }
	}
	
	function getcatelevel($groupid = 0){
	   $Model = M('admin_group');
	   $rs = $Model->field('catearr')->where('id='.$groupid)->find();
	   if($rs !== false){
	      return $rs['catearr'];
	   }
	}
	
	function chinesesubstr($str, $start, $len) { // $str指字符串,$start指字符串的起始位置，$len指字符串长度
        $strlen = $start + $len; // 用$strlen存储字符串的总长度，即从字符串的起始位置到字符串的总长度
        for($i = $start; $i < $strlen;) {
            if (ord ( substr ( $str, $i, 1 ) ) > 0xa0) { // 如果字符串中首个字节的ASCII序数值大于0xa0,则表示汉字
                $tmpstr .= substr ( $str, $i, 3 ); // 每次取出三位字符赋给变量$tmpstr，即等于一个汉字
                $i=$i+3; // 变量自加3
            } else{
                $tmpstr .= substr ( $str, $i, 1 ); // 如果不是汉字，则每次取出一位字符赋给变量$tmpstr
                $i++;
            }
        }
        return $tmpstr; // 返回字符串
    }
	
	/*  SpHtml2Text   
	 ## 将HTML过滤为纯文本
	 ## @return $alltext [string]
    */
	function SpHtml2Text($str){	
		$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
		$alltext = "";
		$start = 1;
		for($i=0;$i<strlen($str);$i++)
		{
			if($start==0 && $str[$i]==">")
			{
				$start = 1;
			}
			else if($start==1)
			{
				if($str[$i]=="<")
				{
					$start = 0;
					$alltext .= " ";
				}
				else if(ord($str[$i])>31)
				{
					$alltext .= $str[$i];
				}
			}
		}
		$alltext = str_replace("　"," ",$alltext);
		$alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
		$alltext = preg_replace("/[ ]+/s"," ",$alltext);
		return $alltext;	
	}
	
	function hidetel($str){
	   $relstr_f = substr($str,0,3);
	   $relstr_m = '*****';
	   $relstr_b = substr($str,-3);
	   $relstr = $relstr_f.$relstr_m.$relstr_b;
	   return $relstr;
	}
	
	
	/**
	 * 功能：生成二维码
	 * @param string $qr_data   手机扫描后要跳转的网址
	 * @param string $qr_level  默认纠错比例 分为L、M、Q、H四个等级，H代表最高纠错能力
	 * @param string $qr_size   二维码图大小，1－10可选，数字越大图片尺寸越大
	 * @param string $save_path 图片存储路径
	 * @param string $save_prefix 图片名称前缀
	*/
	function createQRcode($save_path,$qr_data='PHP QR Code :)',$qr_level='L',$qr_size=4,$save_prefix='qrcode'){
		if(!isset($save_path)) return '';
		//设置生成png图片的路径
		$PNG_TEMP_DIR = & $save_path;
		//导入二维码核心程序
		vendor('PHPQRcode.class#phpqrcode');  //注意这里的大小写哦，不然会出现找不到类，PHPQRcode是文件夹名字，class#phpqrcode就代表class.phpqrcode.php文件名
		//检测并创建生成文件夹
		if (!file_exists($PNG_TEMP_DIR)){
			mkdir($PNG_TEMP_DIR);
		}
		$filename = $PNG_TEMP_DIR.'test.png';
		$errorCorrectionLevel = 'L';
		if (isset($qr_level) && in_array($qr_level, array('L','M','Q','H'))){
			$errorCorrectionLevel = & $qr_level;
		}
		$matrixPointSize = 4;
		if (isset($qr_size)){
			$matrixPointSize = & min(max((int)$qr_size, 1), 10);
		}
		if (isset($qr_data)) {
			if (trim($qr_data) == ''){
				die('data cannot be empty!');
			}
			//生成文件名 文件路径+图片名字前缀+md5(名称)+.png
			$filename = $PNG_TEMP_DIR.$save_prefix.md5($qr_data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			//开始生成
			QRcode::png($qr_data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		} else {
			//默认生成
			QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		}
		if(file_exists($PNG_TEMP_DIR.basename($filename)))
			return basename($filename);
		else
			return FALSE;
	}
	
	
?>