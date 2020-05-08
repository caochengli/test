<?php

namespace Home\Controller;
use Think\Controller;


class IndexController extends CommonController
{

    protected $Cate;
    protected $Cont;

    public function autoLoad()
    {
        $this->Cate = M('category');
        $this->Cont = M('content');
    }

    public function index()
    {
        //幻灯片
        $rssup = $this->Help->SuperSlide(4);
        $this->assign('rssup',$rssup);
        //解决方案
        global $str;
        $str = '';
        $idarr = $this->Help->GetSonArr(133);
        $rs = $this->Cont->field('a.id,a.cateid,a.catename,a.title,a.one_pic,a.tags,a.savename,a.defaultpic,a.shortcontent,a.addtime,a.links,b.dirname')->join(' as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id')->where('a.cateid in('.$idarr.')')->limit(0,5)->order('a.isfocus desc,a.isgood desc,a.taxis desc,a.id desc')->select();
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
        $this->assign('caselist',$res);
        //友情链接
        $rslinks = $this->Help->SuperSlide(3);
        $this->assign('rslinks',$rslinks);
        $this->display();
    }

    public function bindText()
    {
        $M = M('category');
        $arr = array(
            'catename' => array(
                'bridge' => 'like',
                'val' => '酒'
            )
        );
        $map = array();
        /*foreach($arr as $key=>$val){
            $map[$key] = array($val['bridge'],':getkeys');
        }*/
        //$map['catename'] = array('like','s');
        $map['id'] = 7;
        $map['dirname']  = array('like',':getkey');
        //dump($map['catename']);
        $rs = $M->field('id,catename,dirname')->where($map)->bind(':getkey','%s%')->select();
        dump($rs);
    }


}