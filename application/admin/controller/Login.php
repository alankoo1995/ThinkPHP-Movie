<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
    	if(request()->isPost()){
    		$admin = db('admin')->find(1);
    		$data = input('post.');
    		if($admin['name']==$data['name'] && $admin['password']==md5($data['password'])){
    			session('id',$admin['id']);
    			session('name',$admin['name']);
    			$this->success('登录成功',url('../admin/index'));
    		}else{
    			$this->error('密码或用户名错误',url('index'));
    		}
    		return;
    	}
        return view('login');
    }

}
