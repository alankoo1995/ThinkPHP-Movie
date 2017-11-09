<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
	public function _initialize(){
		if(!session('id')|| !session('name')){
			$this->error('您尚未登录系统',url('login/index'));
		}
	}

	public function index(){
		return view();
	}
	public function logout(){
		session(null);
		$this->success('退出成功',url('login/index'));
	}
}