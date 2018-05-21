<?php
/**
 * 抓取微信公众平台数据
 * 
 * @version 1.0  后期考虑维护
 * @author dingqing 2014-2-28
 */
include 'Snoopy.class.php';
class FetchWechat {
    
    // uid
    private $_uid = 0;
    //账号
    private $_username = '';
    //密码
    private $_pwd = '';
    //token信息
    private $_token = '';
    //cookie名称,也就是文件名
    private $_cookie_name = '';
    //cookie路径
    private $_cookie_path = '';
    //cookie文件过期时间
    private $_cookie_expire_time = 3600;
    //我还是喜欢用CI里面的一些东西
    public $CI;
    
    public $test_cookie;
    
    /**
     * 构造函数
     * 
     * @access public
     * @param string/integer $uid 存放cookie和token文件标识，可根据不同应用自己定义
     */
    public function __construct($uid)
    {   
        $this->_cookie_name = 'cookie_' . $uid;
        $this->_token_name = 'token_'.$uid;
        $this->CI = & get_instance();
        $this->_cookie_path = 'data/attachment/temp/';
        $this->_uid = $uid;
    }
    
    /**
     * 微信公众平台模拟登录
     * 
     * @access public
     * @param string $username 公众号账号
     * @param string $pwd 公众号密码
     * @return array
     */
    public function login($username, $pwd)
    {
        $this->_username = $username;
        $this->_pwd = $pwd;
        
        $snoopy = new Snoopy; 
        $submit = "https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";
        
        $post_fields["username"] = $this->_username;
        $post_fields["pwd"] = md5($this->_pwd);
        $post_fields["f"] = "json";
        $post_fields["imgcode"] = "";
        
        $snoopy->referer = "https://mp.weixin.qq.com/";        
        $snoopy->submit($submit, $post_fields);
  
        $result = json_decode($snoopy->results,true);
       
        $msg = '';
        if(isset($result['base_resp']['ret']))
        {
            switch ($result['base_resp']['ret']) {
                case 0:
                    $msg = '登录成功';
                    foreach ($snoopy->headers as $key => $value) 
                    {
                            $value = trim($value);
                            if(preg_match('/^set-cookie:[\s]+([^=]+)=([^;]+)/i', $value,$match))
                            {
                                $cookie .=$match[1].'='.$match[2].'; ';
                                $this->_set_cookie($this->_cookie_name, $cookie);
                            }
                    }
                    preg_match("/token=(\d+)/i",$result['redirect_url'],$matches);
                    if($matches)
                    {
                            $this->_token = $matches[1];
                            $this->_set_cookie($this->_token_name, $this->_token);
                    }
                    break;
                case - 1:
                    $msg = '系统错误，请稍候重试';
                    break;
                case - 2:
                    $msg = '微信账号或密码错误';
                    break;
                case - 23:
                    $msg = '您输入的帐号或者密码不正确，请重新输入';
                    break;
                case - 21:
                    $msg = '不存在该帐户';
                    break;
                case - 7:
                    $msg = '您目前处于访问受限状态';
                    break;
                case - 8:
                    $msg = '请输入图中的验证码';
                    break;
                case - 27:
                    $msg = '您输入的验证码不正确，请重新输入';
                    break;
                case -26:
                	$msg = '该公众会议号已经过期，无法再登录使用。';
                	break;
                case - 25:
                    $msg = '海外帐号请在公众平台海外版登录,<a href="http://admin.wechat.com/">点击登录</a>';
                    break;
                case - 94:
                    $msg = '请使用邮箱登陆';
                    break;
                case - 10000:
                    $msg = '此帐号需要到微信公众平台登录后方可使用。';
                    break;
                case - 10001:
                    $msg = '读取个人信息错误请重试';
                    break;
                case 10:
                    $msg = '该公众会议号已经过期，无法再登录使用';
                    break;
                case 100:
                    $msg = '海外帐号请在公众平台海外版登录';
                    break;
                default:
                    $msg = '授权失败，请确认您的账号密码正确';
            }
        }
        
        return array('error_code' =>  (isset($result['base_resp']['ret']) && $result['base_resp']['ret'] == 0) ? FALSE : TRUE, 'data' => $msg, 'msg' => $msg);
    }
	
	/**
     * 设置回调地址
     */
    public function set_redirect_uri($redirect_uri)
	{   
	    $this->_token = $this->_get_cookie($this->_token_name);
	    $this->test_cookie = $this->_get_cookie($this->_cookie_name);

	    $snoopy = new Snoopy;
	    $submit = 'https://mp.weixin.qq.com/merchant/myservice?action=set_oauth_domain&f=json';
	    $post_fields = array('domain' => $redirect_uri,'lang' => 'zh_CN', 'f' => 'json', 'ajax' => 1, 'token' => $this->_token);
	    $snoopy->rawheaders['Cookie']= $this->test_cookie ;
		$snoopy->referer = 'https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token='.$this->_token.'&lang=zh_CN';
	    $snoopy->submit($submit, $post_fields);
	     
	    $result = json_decode($snoopy->results, true);
	    if ($result['base_resp']['ret'] != 0) {
	        return array('error_code' => 1, 'msg' => '设置回调地址失败，错误信息:'.$result['base_resp']['err_msg'].'(错误码:'.$result['base_resp']['ret'].')');
	    }
	}
	    
    
    /**
     * 获取公众号基础信息
     */
    public function get_account_info()
    {   
        $this->_token = $this->_get_cookie($this->_token_name);
        $this->test_cookie = $this->_get_cookie($this->_cookie_name);
        
        $send_snoopy = new Snoopy;
        $send_snoopy->referer = 'https://mp.weixin.qq.com/cgi-bin/settingpage?t=setting/index&action=index&token='.$this->_token.'&lang=zh_CN';
        $send_snoopy->rawheaders['Cookie']= $this->test_cookie ;
        $submit_url = 'https://mp.weixin.qq.com/cgi-bin/settingpage?t=setting/index&action=index&token='.$this->_token.'&lang=zh_CN&f=json';
        $send_snoopy->fetch($submit_url);
        $result = $send_snoopy->results;
    
        $data = json_decode($result, TRUE);
       
        if(isset($data['user_info']))
        {   
            $data['user_info']['qrcode'] = $this->get_qr_image($data['user_info']['fake_id']);
            $data['user_info']['email'] = $data['setting_info']['bind_email']['is_email'] == 0 ? $data['setting_info']['bind_email']['account'].'@qq.com' : $data['setting_info']['bind_email']['account'];
            return array('error_code' => FALSE, 'data' => $data['user_info']);
        }
    
        return array('error_code' => TRUE, 'data' => 'Fail To Fetch Data');
    }
    
    
    /**
     * 获取二维码图片
     * 
     * @access public
     * @param string $fake_id 图片信息ID
     * @return array
     */
    public function get_qr_image($fake_id)
    {    
        $this->_token = $this->_get_cookie($this->_token_name);
        $this->test_cookie = $this->_get_cookie($this->_cookie_name);
        
        $qrcode = "https://mp.weixin.qq.com/misc/getqrcode?fakeid={$fake_id}&token={$this->_token}&style=1";
        $send_snoopy = new Snoopy;
        $send_snoopy->referer = 'https://mp.weixin.qq.com';
        $send_snoopy->rawheaders['Cookie']= $this->test_cookie ;
        $send_snoopy->fetch($qrcode);
        $result = $send_snoopy->results;
        
        $this->CI->load->config('upload');
        $upload_image = $this->CI->config->item('upload_image');
        $file = $upload_image['upload_path'].'weixin/'.$this->_uid.'_weixin_'.time().'_middle.jpg';
        
        $this->CI->load->helper('file');
        if( ! write_file($file, $result))
        {
            return FALSE;
        }
        return 'weixin/'.$this->_uid.'_weixin_'.time().'_middle.jpg'; 
    }
    
    /**
     * 获取文章列表
     *
     * @access public
     * @param string $begin 开始
     * @return array
     */
    public function get_articles($begin)
    {
        $this->_token = $this->_get_cookie($this->_token_name);
        $this->test_cookie = $this->_get_cookie($this->_cookie_name);
        
        $qrcode = "https://mp.weixin.qq.com/cgi-bin/appmsg?begin={$begin}&count=10&t=media/appmsg_list&type=10&action=list&token={$this->_token}&lang=zh_CN&f=json";
        $send_snoopy = new Snoopy;
        $send_snoopy->referer = 'https://mp.weixin.qq.com';
        $send_snoopy->rawheaders['Cookie']= $this->test_cookie ;
        $send_snoopy->fetch($qrcode);
        $result = $send_snoopy->results;
        $result = json_decode($result, true);
        if ($result['base_resp']['ret'] != 0) {
            return array('error_code' => 1, 'msg' => '获取文章失败,错误信息:'.$result['base_resp']['err_msg'].'(错误码:'.$result['base_resp']['ret'].')');
        }
        return array('error_code' => 0, 'data' => $result['app_msg_info']);
    }
    
    /**
     * 获取文章详细内容
     *
     * @access public
     * @param string $url 文章url
     * @return array
     */
    public function get_article_detail($url)
    {
        $this->_token = $this->_get_cookie($this->_token_name);
        $this->test_cookie = $this->_get_cookie($this->_cookie_name);
        $url = $url . '&f=json';
        $send_snoopy = new Snoopy;
        $send_snoopy->referer = 'https://mp.weixin.qq.com';
        $send_snoopy->rawheaders['Cookie']= $this->test_cookie ;
        // 伪造IP地址
        $snoopy->rawheaders["X_FORWARDED_FOR"] = $this->get_rand_ip();
        $send_snoopy->fetch($url);
        $result = $send_snoopy->results;
        $result = json_decode($result, true);
        if ($result['base_resp']['ret'] != 0) {
            return array('error_code' => 1, 'msg' => '获取文章失败,错误信息:'.$result['base_resp']['errmsg'].'(错误码:'.$result['base_resp']['ret'].')');
        }
        return array('error_code' => 0, 'data' => $result['content']);
    }
    
    /**
     * 生成随机ip
     *
     * @access public
     * @return array
     */
    public function get_rand_ip()
    {
        $ip_long = array(
                array('607649792', '608174079'), //36.56.0.0-36.63.255.255
                array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
                array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
                array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
                array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
                array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
                array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
                array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
                array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
                array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 9);
        $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
    
        return $ip;
    }
    
        
    
    //获取规则
    public function get_rules()
    {
        $send_snoopy = new Snoopy;
        $send_snoopy->referer = 'https://mp.weixin.qq.com/cgi-bin/advanced?action=edit&t=advanced/edit&token='.$this->_token.'&lang=zh_CN';
        $send_snoopy->rawheaders['Cookie']= $this->test_cookie ;//$this->_get_cookie($this->_cookie_name);
        $submit_url = 'https://mp.weixin.qq.com/cgi-bin/autoreply?t=ivr/keywords&action=smartreply&token='.$this->_token.'&lang=zh_CN&f=json';
        $send_snoopy->fetch($submit_url);
        $result = $send_snoopy->results;
  
        $data = json_decode($result, TRUE);
		
        if(isset($data['reply_rules']))
        {
            $import_data = array();
            if(!empty($data['reply_rules']['item']))
            {
                //我只要文字和图文类型reply_type为1或5
                foreach($data['reply_rules']['item'] as $row)
                {	
                    if($row['reply_list'][0]['reply_type'] == 1 OR $row['reply_list'][0]['reply_type'] == 5)
                    {
                            //具体数据到业务中处理，以免经常改动接口
                            $import_data[] = $row;
                    }
                }
            }
            
            return array('error_code' => FALSE, 'data' => $import_data);
        }
        
        return array('error_code' => TRUE, 'data' => 'Fail To Fetch Data');
    }


	/**
	 * 开发者模式和编辑者模式切换
	 * 
	 * @access public
	 * @param integer $flag 状态  1=>开启  0=>关闭
	 * @param integer $type 模式  1=>编辑者模式 2=>开发者模式
	 * @return array
	 */
	public function switch_mode($flag, $type)
	{   
	    $this->_token = $this->_get_cookie($this->_token_name);
	    $this->test_cookie = $this->_get_cookie($this->_cookie_name);
	    
	    $snoopy = new Snoopy;
	    $submit = 'https://mp.weixin.qq.com/misc/skeyform?form=advancedswitchform&lang=zh_CN';
	    $post_fields = array('flag' => $flag, 'type' => $type, 'token' => $this->_token);
	    $snoopy->rawheaders['Cookie']= $this->test_cookie ;
	    $snoopy->referer = "https://mp.weixin.qq.com/cgi-bin/advanced?action=edit&t=advanced/edit&token={$this->_token}&lang=zh_CN";
	    $snoopy->submit($submit, $post_fields);
	     
	    $result = json_decode($snoopy->results, true);
	    if ($result['base_resp']['ret'] != 0) {
	        return array('error_code' => 1, 'msg' => '开启开发者模式失败，错误信息:'.$result['base_resp']['err_msg'].'(错误码:'.$result['base_resp']['ret'].')');
	    }
	    return array('error_code' => 0);
	}
	
	/**
	 * 填写开发者模式的url和token
	 *
	 * @access public
	 * @param string $url url
	 * @param string $callback_token token
	 * @return array
	 */
	public function add_url_token($url, $callback_token, $encoding_aeskey = '', $callback_encrypt_mode = 0)
	{   
	    $this->_token = $this->_get_cookie($this->_token_name);
	    $this->test_cookie = $this->_get_cookie($this->_cookie_name);
	    
	    $snoopy = new Snoopy;
	    $submit = "https://mp.weixin.qq.com/advanced/callbackprofile?t=ajax-response&token={$this->_token}&lang=zh_CN";
	    $post_fields = array('url' => $url, 'callback_token' => $callback_token, 'encoding_aeskey' => $encoding_aeskey, 'callback_encrypt_mode' => $callback_encrypt_mode);
	    $snoopy->rawheaders['Cookie']= $this->test_cookie ;
	    $snoopy->referer = "https://mp.weixin.qq.com/cgi-bin/advanced?action=interface&t=advanced/interface&token={$this->_token}&lang=zh_CN";
	    
	    $snoopy->submit($submit, $post_fields);
	    $result = json_decode($snoopy->results,true);
	    if ($result['base_resp']['ret'] != '0') {
	        return array('error_code' => 1, 'msg' => '填写url和token失败，错误信息:'.$result['msg'].'(错误码:'.$result['ret'].')');
	    }
	    return array('error_code' => 0);
	}
    
    //设置cookie，将cookie写入文件
    private function _set_cookie($filename, $content)
    {
        $this->CI->load->helper('file');
        if( ! write_file($this->_cookie_path . $filename, $content))
        {
            return FALSE;
        }
        return TRUE;
    }
    
    //获取cookie文件内容
    private function _get_cookie($filename)
    {
        $this->CI->load->helper('file');
        $file = $this->_cookie_path . $filename;
        if(file_exists($file))
        {
            if(filemtime($file) < (time() - $this->_cookie_expire_time))
            {
                return FALSE;
            }
            return file_get_contents($file);
        }
        return FALSE;
    }
    
    
}
