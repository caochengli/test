<?php

namespace Home\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Think\Controller;

class HelpController extends Controller
{

    private $Cate;
    private $Art;

    public function _initialize()
    {
        $this->Cate = M('category');
        $this->Art = M('content');
    }

    /*
      ## getPageLoad()
      ## @param int $id 类ID
      ## @return array $pageArr 类配置信息数组
    */
    public function getPageLoad($id){
        if(empty($id)){
            return;
        }
        $pageArr = array();

        $rs = $this->Cate->field('id,pid,catename,subtitle,subdesc,pic,defaultpic,shortcontent,content,listtemp,contenttemp,pagesize,seo_title,seo_keyword,seo_desc,dirname')->where('id='.$id)->find();
        foreach ($rs as $key => $val){
            $pageArr[$key] = $val;
        }

        if(empty($rs['subtitle'])){
            $adWords = $this->setAdWords($id);
            $pageArr['subtitle'] = $adWords['subtitle'];
            $pageArr['subdesc'] = $adWords['subdesc'];
        }

        $pageArr['grandid'] = $this->GetTopId($id);

        $this->assign('grandid',$pageArr['grandid']);

        if(empty($pageArr['pic'])){
            $ban = $this->setBanner($id);
            $pageArr['pic'] = empty($ban) ? C('SITE_NOBANNER') : $ban;
        }
        //location
        $iditem = $this->focusItem($id);
        $pageArr['location'] = $this->breadNav($iditem,C('SITE_BREADCUT'));

        if(!empty($pageArr['listtemp'])){
            $tempex = strtolower(trim(substr(strrchr($pageArr['listtemp'],'.'),0)));
            $pageArr['listtemp'] = str_replace($tempex,'',$pageArr['listtemp']);
        }
        if(!empty($pageArr['contenttemp'])){
            $tempex = strtolower(trim(substr(strrchr($pageArr['contenttemp'],'.'),0)));
            $pageArr['contenttemp'] = str_replace($tempex,'',$pageArr['contenttemp']);
        }

        return $pageArr;
    }

    public function getCateForRand(){
        $rs = $this->Cate->field('dirname,catename')->where('isnav=1')->order('rand()')->limit(0,10)->select();
        return $rs;
    }

    public function breadNav($idarr,$Sep='&gt;'){
        $rs = $this->Cate->field('id,pid,model,catename,dirname,links')->where('id in('.$idarr.')')->order('id asc')->select();
        $ret = '';
        if($rs){
            foreach($rs as $q){
                if($q['links'] == ''){
                    /*switch($q['model']){
                        case 0:
                            $links = U('/Page/index',array('id'=>$q['id']));
                            break;
                        case 1:
                            $links = U('/Article/index',array('id'=>$q['id']));
                            break;
                        default:
                            $links = U('/Page/index',array('id'=>$q['id']));
                            break;
                    }*/
                    $links = C('SITE_URL').'/'.$q['dirname'].'/index.html';
                }else{
                    $links = $q['links'];
                }
                $ret .= $Sep."<a href='".$links."'>".$q['catename']."</a>";
            }
        }
        return $ret;
    }

    public function focusItem($id){
        static $pidarr;
        $rs = $this->Cate->field('id,pid')->where('id='.$id)->find();
        if($rs){
            if($rs['pid'] != 0){
                $pidarr .= $rs['pid'].',';
                $this->focusItem($rs['pid']);
            }
        }
        $FocusItem = $pidarr.$id;
        return $FocusItem;
    }

    public function setBanner($id){
        static $str = '';
        $rs = $this->Cate->field('pic,pid')->where('id='.$id)->find();
        if($rs){
            $str = $rs['pic'];
            if(empty($str)){
                if($rs['pid'] != 0){
                    $this->setBanner($rs['pid']);
                }
            }
        }
        return $str;
    }

    public function setAdWords($id)
    {
        do{
            $pid = empty($rs['pid']) ? $id : $rs['pid'];
            $rs = $this->Cate->field('pid,subtitle,subdesc')->where('id='.$pid)->find();
        }while(empty($rs['subtitle']) && $rs['pid'] != 0);
        return $rs;
    }


    public function GetTopId($id){
        static $pid;
        $rs = $this->Cate->field('id,pid')->where('id='.$id)->find();

        if($rs['pid'] != 0){
            $this->GetTopId($rs['pid']);
        }else{
            $pid = $rs['id'];
        }

        return (int)$pid;
    }

    /*
      ## GetSubMenu
      ## @param int $pid 父类ID
      ## @return array $ret 分类结构数组
    */
    public function GetSubMenu($pid, $isnav = 1)
    {
        global $str;
        $str = '';
        $idarr = $this->GetSonArr($pid);
        $ret = array();
        $rs = $this->Cate->field('id,pid,catename,subtitle,dirname,links,model')->where('id in(' . $idarr . ') and isnav=' . $isnav)->order('pid asc,taxis desc')->select();
        if ($rs) {
            foreach ($rs as $i => $q) {
                $ret[$q['id']] = $q;
                if (empty($q['links'])) {
                    /*switch ($q['model']) {
                        case 1:
                            //$ret[$q['id']]['links'] = U('/Article/index', array('id' => $q['id']));
                            $ret[$q['id']]['links'] = U('/Article/index', array('id' => $q['id']));
                            break;
                        default:
                            $ret[$q['id']]['links'] = U('/Page/index', array('id' => $q['id']));
                            break;
                    }*/
                    $ret[$q['id']]['links'] = C('SITE_URL').'/'.$q['dirname'].'/index.html';
                }
            }
            foreach ($ret as $q) {
                if (isset($ret[$q['pid']])) {
                    $ret[$q['pid']]['submenu'][$q['id']] = &$ret[$q['id']];
                } else {
                    $rets[$q['id']] = &$ret[$q['id']];
                }
            }
        }
        return $rets;
    }

    /*
	  ## GetSonArr
	  ## @param int $id 类ID
	  ## @return string $idarr 形如(1,2,3…)
	*/
    public function GetSonArr($id)
    {
        global $str;
        $M = M('category');
        $rs = $M->field('id')->where('pid=' . $id)->select();
        if ($rs) {
            foreach ($rs as $q) {
                $str .= $q['id'] . ",";
                $this->GetSonArr($q['id']);
            }
        }
        $idarr = $str . $id;
        return $idarr;
    }

    /*
     ## SuperSlide
     ## @param int $id 幻灯分组ID
     ## @return array $ret 幻灯列表数组
    */
    public function SuperSlide($id = 1)
    {
        $Model = M('Carousel');
        $rs = $Model->field('title,content,pic,links')->where('groupid=' . $id)->order('taxis desc,id desc')->select();
        $ret = array();
        if ($rs) {
            foreach ($rs as $i => $q) {
                foreach ($q as $key => $val) {
                    $ret[$i][$key] = $val;
                    if ($key == 'links') {
                        if (empty($val)) {
                            $ret[$i][$key] = "javascript:void(0);";
                        }
                    }
                }
            }
            return $ret;
        }
    }

    public function getFirstChild($id){
        //$M = M('category');
        static $Fid;
        $Fid = $id;
        $rs = $this->Cate->field('id')->where('pid='.$id.' and isnav=1')->order('taxis desc')->find();
        if($rs){
            $this->getFirstChild($rs['id']);
        }
        return $Fid;
    }

    public function addFeedback(){
        $data = I('get.');
        $data['addtime'] = date('Y-m-d H:i:s');
        $M = M('feedback');
        $isok = $M->add($data);
        $res = array(
            'type' => 'error'
        );
        if($isok){
            $res['type'] = 'ok';
        }
        $this->ajaxReturn($res);
    }

    public function setHits($id)
    {
        $art = M('content');
        $res = array(
            'hits' => 0
        );
        try{
            $art->where('id='.$id)->setInc('hits',1);
            $hits = $art->where('id='.$id)->getField('hits');
            $res = array(
                'hits' => $hits
            );
        }catch (\Exception $e){
            //
        }
        $this->ajaxReturn($res);
    }

    public function getArticleUserAjax()
    {
        $page = I('post.page');
        $pagesize = I('post.pagesize');
        $cateid = I('post.cateid');
        $page = empty($page) ? 2 : $page;
        $pagesize = empty($pagesize) ? 20 : $pagesize;
        $firstrow = ($page-1)*$pagesize;
        //get cate son
        global $str;
        $str = '';
        $idarr = $this->GetSonArr($cateid);
        $rs = $this->Art->field('a.id,a.cateid,a.catename,a.title,a.one_pic,a.tags,a.savename,a.defaultpic,a.shortcontent,a.addtime,a.links,b.dirname')->join(' as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id')->where('a.cateid in('.$idarr.')')->limit($firstrow,$pagesize)->order('a.isgood desc,a.isfocus desc,a.taxis desc,a.id desc')->select();
        $res = [];
        foreach($rs as $i=>$q){
            $res[$i] = $q;
            /*if(empty($q['links'])){
                //$res[$i]['links'] = U('/Show/index',array('id'=>$q['id']));
                $res[$i]['links'] = C('SITE_URL').'/'.$q['dirname'].'/'.$q['savename'].'.html';
            }*/
            $res[$i]['links'] = C('SITE_URL').'/'.$q['dirname'].'/'.$q['savename'].'.html';
        }
        $res = array_values($res);
        $this->ajaxReturn($res);
    }

    public function sendMail()
    {
        // 获取表单输入内容
        $inputData = I('post.');
        $htmlData = $this->buildHtmlData($inputData);
        $result = array(
            'status' => 1
        );
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.qq.com;smtp2.qq.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = '851109669@qq.com'; // SMTP username
            $mail->Password = 'gfbuapsgqffnbdcc'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('851109669@qq.com', 'Mailer');
            $mail->addAddress('317377673@qq.com', 'Joe User');     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = '来自95net.net官网的需求邮件';
            $mail->Body    = $htmlData;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
        } catch (Exception $e) {
            $result['status'] = 0;
        }
        return $result;
    }

    public function buildHtmlData($inputData=[])
    {
        $M = M('feedback');
        $saveData = array(
            'name' => $inputData['name'],
            'telno' => $inputData['telno'],
            'content' => $inputData['content'],
            'addtime' => date('Y-m-d H:i:s')
        );
        $M->add($saveData);
        $html = '<table width="100%" cellspacing="1" cellpadding="5" bgcolor="#F6F6F6"><tbody>';
        $html .= '<tr><td bgcolor="#FFFFFF">姓名：</td><td bgcolor="#FFFFFF">'.$inputData['name'].'</td></tr>';
        $html .= '<tr><td bgcolor="#FFFFFF">电话：</td><td bgcolor="#FFFFFF">'.$inputData['telno'].'</td></tr>';
        $html .= '<tr><td bgcolor="#FFFFFF">需求：</td><td bgcolor="#FFFFFF">'.$inputData['content'].'</td></tr>';
        $html .= '</tbody></table>';
        return $html;
    }

}