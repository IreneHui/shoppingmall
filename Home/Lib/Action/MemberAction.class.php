<?php 
	class MemberAction extends PremiseAction{
		function credit($flag=null){
			$m=M('member');
			$arr=$m->select();
			for($i=0;$i<sizeof($arr);$i++){
				$arr[$i]['mtime']=date('Y-m-d',$arr[$i]['mtime']);
			}
			$this->assign('member',$arr);
			if(!$flag){
				$this->display();
			}
		}
		function add_credit($flag=null){
			if(!$flag){
				$this->display();
			}
		}
		function do_add_member(){
			$m=M('member');
			$_POST['mtime']=time();
			$m->create();
			if($result=$m->add()){
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'credit'),1,"add successfully");

			}else{
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'credit'),1,"add error");

			}
		}
		function search_member(){
			$data['mname']=array('like',"%{$_POST['search_person']}%");
			$data['phone']=$_POST['search_person'];
			$data['_logic']='or';
			$m=M("member");
			import('ORG.Util.Page');// 导入分页类
			$count=$m->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$m->limit($page->firstRow.','.$page->listRows)->where($data)->select();
			$this->assign('member',$arr);
			$this->assign('show',$show);
			$this->assign('page',"Member/credit");
			R('Index/menu');
			$this->display('Index/index');
		}
		function gift_exchange($flag=null){
			$g=M('gift');
			$arr=$g->select();
			$this->assign('gift',$arr);
			$m=M('member');
			$where['mid']=$_GET['mid'];
			$member=$m->find($_GET['mid']);
			$this->assign('member',$member);
			if(!$flag){
				$this->display();
			}
		}
		function add_gift($flag=null){
			if(!$flag){
				$this->display();
			}
		}
		function do_add_gift(){
			$g=M('gift');
			$g->create();
			if($g->add()){
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"add successfully");

			}else{
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"add error");

			}
		}
		function gift_editor($flag=null){
			$g=M('gift');
			$arr=$g->find($_GET['gid']);
			$this->assign('gift',$arr);
			if(!$flag){
				$this->display();
			}
		}
		function gift_del(){
			$gid=$_GET['gid'];
			$g=M('gift');
			$result=$g->delete($gid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"delete error");
			}
		}
		function gift_modi(){
			$g=M('gift');
			$g->create();
			if($g->save()){
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'gift_exchange'),1,"delete error");
			}
		}
		function do_gift_exchange(){
			$g=M('gift');
			$m=M('member');
			$mid=$_GET['mid'];
			$gift=$g->find($_GET['gid']);
			$member=$m->find($_GET['mid']);
			if($member['credit']<$gift['credit']){
				$this->redirect('Index/index',array('page1'=>'Member','page2'=>'credit'),1,"You don't have enough credit.");
			}
			else{
				$member['credit']=$member['credit']-$gift['credit'];
				$result=$m->save($member);
				if($result){
					$gift['amount']=$gift['amount']-1;
					$g->save($gift);
					$this->redirect('Index/index',array('page1'=>'Member','page2'=>'credit'),1,"gift exchange successfully.");
				}
			}
		}
	}
 ?>
