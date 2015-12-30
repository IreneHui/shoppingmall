<?php 
	class Item_publishAction extends PremiseAction{
		function staff_notice(){
			$a=M('notice');
			$where['category']="员工通知";
			import('ORG.Util.Page');// 导入分页类
			$count=$a->where($where)->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$a->order('istop desc,createtime desc')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('show',$show);
			$this->assign("notice",$arr);
			$this->display();
		}
		function new_notice(){
			$p=M('personal_info');
			$where['pid']=$_SESSION['pid'];
			$_POST['department']=$p->where($where)->getField('department');			
			$a=M("notice");
			$_POST['createtime']=date('Y-m-d',time());
			if($_POST['istop']=='on')
				$_POST['istop']=1;
			$a->create();
			if($a->add()){
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_management'),1,"add successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_publish'),1,"add error");
		}}
		function store_notice($flag=null){
			$a=M('notice');
			$where['category']="商家通知";

			import('ORG.Util.Page');// 导入分页类
			$count=$a->where($where)->count();//获取数据的总数
			$page  = new Page($count,10);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			
			$arr=$a->order('istop desc,createtime desc')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('show',$show);
			$this->assign("store_notice",$arr);
			if(!$flag)
			$this->display();
		}
		function notice_info(){

			$where['nid']=$_GET['nid'];
			$a=M('notice');
			$arr=$a->where($where)->find();
			$arr['viewcount']=$arr['viewcount']+1;
			$a->save($arr);
			$arr['createtime']=$arr['createtime'];
			$this->assign("article",$arr);
			$this->display();
		}
		function notice_management($flag=null){
			$a=M('notice');
			import('ORG.Util.Date');// 导入日期类
			import('ORG.Util.Page');// 导入分页类
			$count=$a->where($where)->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$a->where($where)->order('istop desc,createtime desc')->limit($page->firstRow.','.$page->listRows)->select();
			for($i=0;$i<sizeof($arr);$i++){
				$arr[$i]['createtime']=$arr[$i]['createtime'];
				$Date = new Date($arr[$i]['createtime']);
				$time=$Date->dateDiff(time(),'d');  // 比较日期差
				$arr[$i]['lefttop']=round($arr[$i]['topday']-$time);
			}		
			$this->assign('show',$show);
			$this->assign("notice",$arr);
			if(!$flag)
			$this->display();
		}
		function notice_editor(){
			$article_id=$_GET['nid'];
			$a=M('notice');
			$notice=$a->find($article_id);
			$this->assign('notice',$notice);
			$this->display();
		}
		function notice_modi(){	
			$a=M('notice');
			if($_POST['istop']=='on'){
				$_POST['istop']=1;
			}
			else{
				$_POST['istop']=0;
			}
			$a->create();
			$result=$a->save();
			// $arr=$a->find($_POST['nid']);
			// $_POST['createtime']=$arr['createtime'];
			// $_POST['department']=$arr['department'];
			// $_POST['viewcount']=$arr['viewcount'];
			if($result){
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_management'),1,"modify error");
			}
		}
		function notice_del(){
			$article_id=$_GET['nid'];
			$a=M('notice');
			$result=$a->delete($article_id);
			if($result){				
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_management'),1,"delete error");
			}

		}
		function search_notice(){
			$salary=M('notice');
			$data['title']=array('like',"%{$_POST['search_person']}%");
			$data['createtime']=array('like',"%{$_POST['search_person']}%");
			$data['_logic']='or';
			$info=$salary->where($data)->select();
			// dump($data);dump($info);exit;
			$this->assign('notice',$info);
			$this->assign('page','Item_publish/notice_management');
			R('Index/menu');
			$this->display('Index/index');	
		}
	}
 ?>