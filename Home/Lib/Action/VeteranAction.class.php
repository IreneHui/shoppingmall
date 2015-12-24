<?php 
	class VeteranAction extends PremiseAction{
		function veteran_info($flag=null){
			$p=M("veteran");
			$per=$p->find($_GET['vid']);
			$this->assign('pi',$per);
			//dump($per);exit;

			if(!$flag)
				$this->display();
		}
		//显示所有人员信息列表
		function maintain_veteran($flag=null){
			$v=M("veteran_date");
			$p=M('veteran');
			import('ORG.Util.Page');// 导入分页类
			$count=$p->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$p->limit($page->firstRow.','.$page->listRows)->select();
			$veteran_date=$v->find(1);
			$this->assign('veteran_date',$veteran_date['veteran_date']);
			$this->assign('person',$arr);
			$this->assign('show',$show);
			if(!$flag){
				$this->display();
			}
		}
		//添加人员信息页面
		function add_veteran(){
			$this->display();
		}
		//添加人员信息
		function do_add_veteran(){
			$p=M('Veteran');
			$p->create();
			if($p->add()){
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"add successfully");

			}else{
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"add error");

			}
		}
		//显示编辑人员页面
		function veteran_editor(){
			$pid=$_GET['vid'];
			$p=M('veteran');
			$arr=$p->find($pid);
			$this->assign("pi",$arr);
			$this->display();
		}
		//编辑人员信息
		function veteran_modi(){
			$p=M('veteran');
			$p->create();
			$result=$p->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"modify error");
			}
		}
		function veteran_del(){
			$pid=$_GET['vid'];
			$p=M('veteran');
			$result=$p->delete($pid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"delete error");
			}
		}
		function search_veteran(){
        	$data['workID']=$_POST['search_person'];
			$data['name']=array('like',"%{$_POST['search_person']}%");
			$data['_logic']='or';
			$p=M("veteran");
			import('ORG.Util.Page');// 导入分页类
			$count=$p->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$p->limit($page->firstRow.','.$page->listRows)->where($data)->select();
			$v=M("veteran_date");
			$veteran_date=$v->find(1);
			$this->assign('veteran_date',$veteran_date['veteran_date']);
			$this->assign('person',$arr);
			$this->assign('show',$show);

			$this->assign('page',"Veteran/maintain_veteran");
			R('Index/menu');
			$this->display('Index/index');
		}
		function set_date(){
			$p=M('veteran_date');
			$_POST['vdid']='1';
			dump($_POST);
			$p->create();
			$result=$p->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"set date successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Veteran','page2'=>'maintain_veteran'),1,"set date error");
			}

		}
	}
 ?>