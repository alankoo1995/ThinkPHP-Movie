<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\pages as PagesModel;

class Pages extends Controller{

	public function _initialize(){
		if(!session('id')|| !session('name')){
			$this->error('您尚未登录系统',url('login/index'));
		}
	}

	public function index(){
		$pagesRes = db('pages')->select();
		$this->assign('pagesRes',$pagesRes);
		return view('pages');
	}

	public function add(){
		if(request()->isPost()){
			$data = input('post.');
			 if($_FILES['thumb']['tmp_name']){
			 	$file = request()->file('thumb');
			 	$info = $file->move(ROOT_PATH.'public'.DS.'uploads');
				if($info){
					$thumbUrl = ROOT_PATH.'public'.DS.'uploads'.'/'.$info->getExtension();
					$data['thumb'] = $thumbUrl;
				}
			 }
		}
	}

	public function editUI($id){
		$idNow = $id;
		$this->assign('idNow',$idNow);
		$oriData = db('pages')->where('id',$id)->find();
		return view("editUI");
	}

	public function edit(){
		if(request()->isPost()){
			$data = input('post.');
			dump($data);die;
			if($data){
				$res = db('pages')->where('id',$data['id'])->update(['title'=>$data['title'],
																	'desc'=>$data['desc'],
																	'author'=>$data['author'],
																	'thumb'=>$data['thumb'],
																	'content'=>$data['content']]);
			}
		}
	}
}