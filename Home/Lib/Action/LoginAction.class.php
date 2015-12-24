<?php
	class LoginAction extends Action{
		function code(){
			import('ORG.Util.Image');
    		Image::buildImageVerify();
		}
		function Login(){
			$this->display();
		}
		function do_login(){
			$workID=$_POST['workID'];
			$password=$_POST['password'];
			$code=$_POST['code'];
			
			if($_SESSION['verify']!=md5($code)){
				$this->error('验证码错误');dump($_SESSION['verify']);dump($code);dump(md5($code));exit;
			}
			$f=M('personal_info');
			$where['workID']=$workID;
			$where['password']=md5($password);
			$arr=$f->field('pid,authority,name')->where($where)->find();
			if($arr){
				$_SESSION['workID']=$workID;
				$_SESSION['pid']=$arr['pid'];
				$_SESSION['authority']=$arr['authority'];
				$_SESSION['name']=$arr['name'];
				$this->redirect("__APP__/Index/index");

			}
			else{
				$this->error('用户名或密码错误');
			}
		}	
		function logout(){
			$_SESSION=array();
			if(isset($_COOKIE[session_name()])){
				setcookie(session_name(),'',time()-1,'/');
			}
			session_destroy();
			$this->redirect('login');
		}
	}
?>