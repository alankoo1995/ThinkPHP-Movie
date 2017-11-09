<?php
namespace app\admin\controller;
use think\Controller;

class Admin extends Controller
{
	public function _initialize(){
		if(!session('id')|| !session('name')){
			$this->error('您尚未登录系统',url('login/index'));
		}
	}
	
	public function index(){
		return view();
	}
	public function modify(){
		$name = db('admin')->where('id',1)->value('name');
		$this->assign('name',$name);
		return view('admin');
	}
	public function change(){
		if(request()->isPost()){
			$data = input('post.');
			$oriData = db('admin')->find(1);
			//基础校验
			if($data['password']=="")
				$this->error('密码不能为空',url('admin/modify'));
			if($data['password']==$oriData['password']||$data['name']==$oriData['name']){
				$this->error('密码不能与原密码相同',url('admin/modify'));
			}
			//将密码加密成md5码
			$data['password'] = md5($data['password']);

			if($data['name']==""){
				$res = db('admin')->where('id',1)->update(['password'=>$data['password']]);
			}
			else{
				$res = db('admin')->where('id',1)->update(['name'=>$data['name'],
														'password'=>$data['password']]);
			}
			if($res){
				$this->success('修改成功',url('admin/modify'));
			}else{
				$this->error('修改失败，请检查输入字符的合法性',url('admin/modify'));
			}
			return;
		}
		return view('admin');
	}

}