<?php 
	class AuthorityAction extends PremiseAction{
		function menu_management($flag=null){
			$f=M('function');
			$a=M('authority');

			$where['father_id']=0;
			$count=0;//获取数据的总数
			$first=$f->where($where)->select();
			for($i=0;$i<sizeof($first);$i++){
				$count++;
				$where['father_id']=$first[$i]['f_id'];
				$first[$i]['second']=$f->where($where)->select();
				
				for($j=0;$j<sizeof($first[$i]['second']);$j++){
					$count++;
					$where1['aid']=$first[$i]['second'][$j]['default'];
					$first[$i]['second'][$j]['aname']=$a->where($where1)->getfield('aname');
				}
			}
			import('ORG.Util.Page');// 导入分页类
			
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$this->assign('menu',$first);
			$this->assign('show',$show);
			if(!$flag)
				$this->display();
		}
		function menu_add(){
			$f=M("function");
			$where["level"]="1";
			$arr=$f->where($where)->select();
			$this->assign("first_menu",$arr);
			$this->display();
		}
		function do_menu_add(){
			$f=M("function");
			if($_POST['level']=="1"){
				$_POST['father_id']=0;
				$_POST['default']=0;
			}

			else{
				$_POST["father_id"]=$_POST["belongto"];
			}
			$_POST['ef_name']=time();
			$f->create();
			if($f->add()){
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"add successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"delete error");
			}
		}
		function menu_del(){
			$f_id=$_GET['f_id'];
			$f=M('function');
			$result=$f->delete($f_id);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"delete error");
			}
		}
		function total_menu_del(){
			$f_id=$_GET['f_id'];
			$f=M('function');
			$where['father_id']=$f_id;
			$where1['f_id']=$f_id;
			$result=$f->where($where)->delete();
			$result1=$f->where($where1)->delete();
			if($result1){
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"delete error");
			}
		}
		function menu_editor(){
			$f_id=$_GET['f_id'];
			$f=M("function");
			$arr=$f->find($f_id);
			$where['father_id']=0;
			$arr['belongto']=$f->where($where)->select();
			$this->assign("menu",$arr);
			$this->display();
		}
		function menu_modi(){
			$f=M('function');
			if($_POST['level']=="1"){
				$_POST['father_id']=0;
				$_POST['default']=0;
			}
			$f->create();
			$result=$f->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'menu_management'),1,"modify error");
		}
	}
		function change_authority($flag=null){
			$f=M('function');
			$a=M('authority');

			$where['father_id']=0;
			$count=0;//获取数据的总数
			$first=$f->where($where)->select();
			for($i=0;$i<sizeof($first);$i++){
				$count++;
				$where['father_id']=$first[$i]['f_id'];
				$first[$i]['second']=$f->where($where)->select();
				
				for($j=0;$j<sizeof($first[$i]['second']);$j++){
					$count++;
					$where1['aid']=$first[$i]['second'][$j]['default'];
					$first[$i]['second'][$j]['aname']=$a->where($where1)->getfield('aname');
				}
			}
			$p=M('personal_info');
			$test['pid']=$_GET['pid'];
			$name=$p->where($test)->getField('name');
			$this->assign('name',$name);
			$this->assign('menu',$first);
			$this->assign('pid',$_GET['pid']);
			//$this->redirect('Index/index',array('page1'=>'Authority','page2'=>'change_authority'));
			if(!$flag)
			$this->display();
		}
		function do_change_authority(){
			$p=M('personal_info');
			if($_POST['authority']!='5'){				
				$p->create();
				$result=$p->save();
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"change successfully");
			}
			else{
				$p->create();
				$result=$p->save();
				$cf=M('cfunction');
				$f=M('function');$where['pid']=$_POST['pid'];
					$cf->where($where)->delete();
					
				for($i=0;$i<sizeof($_POST['function']);$i++){
					$where['pid']=$_POST['pid'];
					$where['ef_name']=$_POST['function'][$i];
					$data['ef_name']=$_POST['function'][$i];
					$where['f_name']=$f->where($data)->getField('f_name');
					$where['level']=$f->where($data)->getField('level');
					$where['father_id']=$f->where($data)->getField('father_id');
					$cf->add($where);

				}
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"change successfully");

			}
		}
	
}
 ?>