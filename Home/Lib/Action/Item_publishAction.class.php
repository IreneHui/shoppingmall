<?php 
	class Item_publishAction extends PremiseAction{
		function notice(){
			$a=M('notice');
			$where['category']="普通消息";
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
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'personnel_notice'),1,"add successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Item_publish','page2'=>'notice_publish'),1,"add error");
		}}
		function personnel_notice($flag=null){
			$a=M('notice');
			$where['category']="普通消息";
			$where1['category']=array('in',array("人事科消息","系统消息"));

			import('ORG.Util.Page');// 导入分页类
			$count=$a->where($where)->count();//获取数据的总数
			$count1=$a->where($where1)->count();
			$page  = new Page($count,10);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			import('ORG.Util.Page');// 导入分页类
			$page1  = new Page($count1,10);//
			$page1->setConfig('header','条信息');
			$show1=$page1->show();//返回分页信息
			
			$v=M('veteran');
			$p=M('personal_info');
			import('ORG.Util.Date');// 导入日期类
			$vd=M('veteran_date');
			$date=$vd->where(1)->getField('veteran_date');
			$veteran=$v->select();//dump($veteran);
			Load('extend');
			for($i=0;$i<sizeof($veteran);$i++){	
				$veteran[$i]['birthday']=msubstr($veteran[$i]['birthday'], 5, 5, "utf-8",false);
				$Date = new Date('2015-'.$veteran[$i]['birthday']);
				// $year=floor(($Date->dateDiff(time(),$elaps="M"))/12);  // 比较日期差
				// $year1=date('Y',time())-$year;dump($year1);
				// $date=date('m-d',time());
				$time=$Date->dateDiff(time(),$elaps="d");
				if($time<0&&abs($time)<=$date){
					$vwhere['title']="请注意".$veteran[$i]['name']."在".$veteran[$i]['birthday']."的生日即将到来！";
					if($a->where($vwhere)->find())continue;
					$vwhere['createtime']=date('Y-m-d',time());
					$vwhere['department']=$p->where($_SESSION['pid'])->getField('department');
					$vwhere['category']="系统消息";
					$vwhere['istop']=1;
					$vwhere['topday']=$time;
					$a->add($vwhere);
				}
			}
			$where3['category']="系统消息";
			$arr3=$a->where($where3)->select();
			for($i=0;$i<sizeof($arr3);$i++){
				$Date = new Date(time());
				$time=$Date->dateDiff($arr3[$i]['createtime'],$elaps="d");
			}
			$arr=$a->order('istop desc,createtime desc')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
			$arr1=$a->order('istop desc,createtime desc')->where($where1)->limit($page1->firstRow.','.$page1->listRows)->select();
			$this->assign('show',$show);
			$this->assign('show1',$show1);
			$this->assign("notice",$arr);
			$this->assign('personnel_notice',$arr1);
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