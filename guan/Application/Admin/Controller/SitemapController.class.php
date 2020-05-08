<?php

namespace Admin\Controller;

use Think\Controller;

class SitemapController extends Controller
{

    private $Cate;
	private $Cont;
    private $Result;
    private $prefix;
    private $baseLink;
    private $siteLink;

    public function _initialize(){
        $this->Cate = M('category');
        $this->Cont = M('content');
        $this->Result = array();
        $this->prefix = './';
        $this->baseLink = 'http://'.$_SERVER['HTTP_HOST'].'/index.php';
        $this->siteLink = C('SITE_URL');
    }

    public function index(){
        $mapcate = $this->GetSubMenu();
        $this->Result[] = array(
            'loc' => $this->siteLink.'/index.html',
            'priority' => '0.8',
            'lastmod' => date('Y-m-d H:i:s'),
            'changefreq' => 'always'
        );
        foreach ($mapcate as $q){
            $this->Result[] = array(
                'loc' => $q['links'],
                'priority' => '0.8',
                'lastmod' => date('Y-m-d H:i:s'),
                'changefreq' => 'always'
            );
            /*$this->Result[] = array(
                'loc' => $q['mlinks'],
                'priority' => '0.8',
                'lastmod' => date('Y-m-d H:i:s'),
                'changefreq' => 'always'
            );*/
        }
        //移动端

        $rs = $this->Cont->field('a.id,a.addtime,a.savename,b.dirname')->join(' as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id')->select();
        foreach($rs as $q){
            $this->Result[] = array(
                'loc' => $this->siteLink.'/'.$q['dirname'].'/'.$q['savename'].'.html',
                'priority' => '0.8',
                'lastmod' => $q['addtime'],
                'changefreq' => 'monthly'
            );
            /*$this->Result[] = array(
                'loc' => $this->siteLink.'/m/'.$q['dirname'].'/'.$q['savename'].'.html',
                'priority' => '0.8',
                'lastmod' => $q['addtime'],
                'changefreq' => 'monthly'
            );*/
        }

        //dump($this->Result);
        $isready = $this->BuildSiteMap();
        $res = array(
            'type' => 'ok'
        );
        if(!$isready){
            $res['type'] = 'error';
        }
        $this->ajaxReturn($res);
    }

    public function BuildSiteMap(){
        //dump($this->Result);
        $sitetxt = '';
        $sitemap = "<?xml version='1.0' encoding='UTF-8' ?><urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
        foreach($this->Result as $q){
            $sitemap .= "<url> "."<loc>".$q['loc']."</loc> "."<priority>".$q['priority']."</priority> <lastmod>".$q['lastmod']."</lastmod> <changefreq>".$q['changefreq']."</changefreq> </url> ";
            $sitetxt .= $q['loc'].PHP_EOL;
        }
        $sitemap .= '</urlset>';
        $isok = file_put_contents('./sitemap.xml',$sitemap);
        file_put_contents('./sitetxt.txt',$sitetxt);
        return $isok;
    }

    public function GetSubMenu(){
        $ret = array();
        $rs = $this->Cate->field('id,pid,catename,links,model,dirname')->order('pid asc,taxis desc')->select();

        if($rs){
            foreach($rs as $i => $q){
                $ret[$q['id']] = $q;
                $ret[$q['id']]['links'] = $this->siteLink."/".$q['dirname'].'/index.html';
                //$ret[$q['id']]['mlinks'] = $this->siteLink."/m/".$q['dirname'].'/index.html';
                /*if($q['links'] == ''){
                    if($q['model'] == 0 && $q['pid'] != 0){
                        //$fapath = $this->Cate->where('id='.$q['pid'])->getField('dirname');
                        $ret[$q['id']]['links'] = 'http://www.yddichun.com/index.php/Page/index/id/'.$q['id'].'.html';
                    }else{
                        //$ret[$q['id']]['links'] = 'http://www.yddichun.com/a/'.$q['dirname'].'/';
                        //$ret[$q['id']]['links'] = 'http://www.yddichun.com/index.php/Article/index/id/'.$q['id'].'.html';
                    }
                }*/
            }
        }
        return $ret;
    }

}