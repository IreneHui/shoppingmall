<?php
	class PremiseAction extends Action{
		Public function _initialize(){
   		// 初始化的时候检查用户权限
   			if(!isset($_SESSION['workID']) || $_SESSION['workID']==''){
				$this->redirect('Login/login');
			}
			if($_GET['s']==1){
				$this->redirect('Index/index',array('page1'=>MODULE_NAME,'page2'=>ACTION_NAME));
			}
		}
	}
?>
