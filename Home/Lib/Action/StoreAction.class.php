<?php  
	class StoreAction extends PremiseAction{
		function store_location($flag=null){
			$sl=M('store_location');
			$st=M('store');
			//find all floor and sort
			$max=(int)$sl->max('floor');
			$min=(int)$sl->min('floor');
			for($i=$min;$i<=$max;$i++){
				$where['floor']=$i;
				if($sl->where($where)->count()){
					$floor1[$i]++;
				}
			}
			for($i=$min,$j=0;$i<=$max;$i++){
				//dump($i);
				if($floor1[$i]){
				//	dump($i);dump($j);
					$floor[$j]['floor']=$i;
					$j++;
				}
			}
			for($i=0;$i<sizeof($floor);$i++){
				$where['floor']=$floor[$i]['floor'];
				$floor[$i]['store']=$sl->where($where)->select();
				for($j=0;$j<sizeof($floor[$i]['store']);$j++){
					$where1['stid']=$floor[$i]['store'][$j]['stid'];
					$floor[$i]['store'][$j]['stname']=$st->where($where1)->getfield('stname');
				}
			}
			$this->assign('floor',$floor);
			if(!$flag)
				$this->display();
		}
		function add_location($flag=null){
			$s=M('store');
			$where['slid']='0';
			$arr=$s->where($where)->select();
			$this->assign('store',$arr);
			if(!$flag)
				$this->display();
		}
		function do_add_location(){
			$sl=M('store_location');
			$sl->create();
			$st=M('store');		
			if($result=$sl->add()){
				$where['stid']=$_POST['stid'];
				$where['slid']=$result;
				$st->save($where);
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"add successfully");

			}else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"add error");

			}
		}
		function location_editor(){
			$slid=$_GET['slid'];
			$sl=M('store_location');
			$arr=$sl->find($slid);
			$st=M('store');
			$where['stid']=$arr['stid'];
			$arr['stname']=$st->where($where)->getfield('stname');
			$where1['slid']=0;
			$arr1=$st->where($where1)->select();
			$this->assign('store',$arr1);
			$this->assign("location",$arr);
			$this->display();
		}
		function location_modi(){
			$sl=M('store_location');
			$sl->create();
			$result=$sl->save();
			if($result){
				if($_POST['stid']!=$_POST['origin_store']){
					$st=M('store');
					$where['stid']=$_POST['stid'];
					$where['slid']=$_POST['slid'];
					$result=$st->save($where);
					$where1['stid']=$_POST['origin_store'];
					$where1['slid']='0';
					$result=$st->save($where1);
				}
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"modify error");
			}
		}
		function location_del(){
			$slid=$_GET['slid'];
			$sl=M('store_location');
			$where['slid']=$slid;
			$stid=$sl->where($where)->getfield('stid');
			$result=$sl->delete($slid);
			if($result){
				$st=M('store');
				$where['stid']=$stid;
				$where['slid']=0;
				$st->save($where);
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_location'),1,"delete error");
			}
		}
		function add_category(){
			$this->display();
		}
		function do_add_category(){
			$sc=M('store_category');
			$sc->create();
			if($sc->add()){
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"add successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"add error");
			}
		}
		function store_category($flag=null){
			$st=M('store');
			$sc=M('store_category');
			$sl=M('store_location');
			$category=$sc->select();
			for($i=0;$i<sizeof($category);$i++){
				$where['scid']=$category[$i]['scid'];
				$category[$i]['store']=$st->where($where)->select();
				for($j=0;$j<sizeof($category[$i]['store']);$j++){
					$where1['slid']=$category[$i]['store'][$j]['slid'];
					$category[$i]['store'][$j]['slname']=$sl->where($where1)->getfield('slname');
				}
			}
			$this->assign('category',$category);
			if(!$flag)
				$this->display();

		}
		function category_editor($flag=null){
			$sc=M('store_category');
			$where['scid']=$_GET['scid'];
			$arr=$sc->where($where)->find();
			$this->assign('category',$arr);
			if(!$flag)
				$this->display();
		}
		function modi_category($flag=null){
			$sc=M('store_category');
			$sc->create();
			$result=$sc->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"modify error");
			}
		}
		function category_del(){
			$scid=$_GET['scid'];
			$sc=M('store_category');
			$result=$sc->delete($scid);
			if($result){
				$st=M('store');
				$where['scid']=$_GET['scid'];
				$arr=$st->where($where)->select();
				for($i=0;$i<sizeof($arr);$i++){
					$arr[$i]['scid']=0;
					$st->save($arr[$i]);
				}
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_category'),1,"delete error");
			}
		}
		function store_management($flag=null){
			$st=M('store');
			import('ORG.Util.Page');// 导入分页类
			$count=$st->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$st->limit($page->firstRow.','.$page->listRows)->select();
			$sl=M('store_location');
			$sc=M('store_category');
			$p=M('personal_info');
			for($i=0;$i<sizeof($arr);$i++){
				$where['slid']=$arr[$i]['slid'];
				$arr[$i]['slname']=$sl->where($where)->getfield('slname');
				$where['scid']=$arr[$i]['scid'];
				$arr[$i]['scname']=$sc->where($where)->getfield('scname');
				$where['pid']=$arr[$i]['pic'];
				$arr[$i]['name']=$p->where($where)->getfield('name');
			}
			$this->assign('show',$show);
			$this->assign('store',$arr);
			if(!$flag){
				$this->display();
			}
		}
		function add_store($flag=null){
			$sl=M('store_location');
			$st=M('store');
			$sc=M('store_category');
			$where['stid']=0;
			$location=$sl->where($where)->select();
			$category=$sc->select();
			$p=M('personal_info');
			$where['authority']=4;
			$pic=$p->where($where)->select();
			$this->assign('location',$location);
			$this->assign('category',$category);
			$this->assign('pic',$pic);
			if(!$flag){
				$this->display();
			}
		}
		function do_add_store(){
			$st=M('store');
			$st->create();
			if($result=$st->add()){
				$sl=M('store_location');
				$where['stid']=$result;
				$where['slid']=$_POST['slid'];
				$sl->save($where);
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"add successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"add error");
			}
		}
		function store_editor($flag=null){
			$st=M('store');
			$sl=M('store_location');
			$sc=M('store_category');
			$p=M('personal_info');
			$where['stid']=$_GET['stid'];
			$store=$st->where($where)->find();
			$where['scid']=$store['scid'];
			$store['scname']=$sc->where($where)->getfield('scname');
			$where['slid']=$store['slid'];
			$store['slname']=$sl->where($where)->getfield('slname');
			$where['pid']=$store['pic'];
			$store['name']=$p->where($where)->getfield('name');
			$category=$sc->select();
			$where1['stid']=0;
			$location=$sl->where($where1)->select();
			$where1['authority']=4;
			$pic=$p->where($where1)->select();
			$this->assign('pic',$pic);
			$this->assign('store',$store);
			$this->assign('category',$category);
			$this->assign('location',$location);
			if(!$flag){
				$this->display();
			}
		}
		function modi_store(){
			$st=M('store');
			$st->create();
			$result=$st->save();
			if($result){
				if($_POST['origin_slid']!=$_POST['slid']){
					$sl=M('store_location');
					$where['slid']=$_POST['slid'];
					$where['stid']=$_POST['stid'];
					$sl->save($where);
					$where1['slid']=$_POST['origin_slid'];
					$where1['stid']=0;
					$sl->save($where1);

				}
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"modify error");
			}
		}
		function store_del(){
			$stid=$_GET['stid'];
			$st=M('store');
			$where['stid']=$stid;
			$slid=$st->where($where)->getfield('slid');
			$result=$st->delete($stid);
			if($result){
				$sl=M('store_location');
				$where['slid']=$slid;
				$where['stid']=0;
				$sl->save($where);
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'store_management'),1,"delete error");
			}
		}
		function store_more($flag=null){
			$st=M('store');
			$stid=$_GET['stid'];
			$arr=$st->find($stid);
			$sl=M('store_location');
			$sc=M('store_category');
			$where['slid']=$arr['slid'];
			$arr['slname']=$sl->where($where)->getfield('slname');
			$where['scid']=$arr['scid'];
			$arr['scname']=$sc->where($where)->getfield('scname');
			$this->assign('store',$arr);
			if(!$flag){
				$this->display();
			}
		}
		function search_store(){
			$data['stname']=array('like',"%{$_POST['search_person']}%");
			$st=M("store");
			import('ORG.Util.Page');// 导入分页类
			$count=$st->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$st->limit($page->firstRow.','.$page->listRows)->where($data)->select();
			$this->assign('store',$arr);
			$this->assign('show',$show);
			$this->assign('page',"Store/store_management");
			R('Index/menu');
			$this->display('Index/index');
		}
		function change_store_info($flag=null){
			if($_SESSION['authority']!=4){
				$message='1';
				$this->assign('message',$message);
			}
			else{
				$message='0';
				$st=M('store');
				import('ORG.Util.Page');// 导入分页类
				$count=$st->count();//获取数据的总数
				$page  = new Page($count,15);//
				$page->setConfig('header','条信息');
				$show=$page->show();//返回分页信息
				$where['pic']=$_SESSION['pid'];
				$arr=$st->limit($page->firstRow.','.$page->listRows)->where($where)->select();
				$sl=M('store_location');
				$sc=M('store_category');
				$p=M('personal_info');
				for($i=0;$i<sizeof($arr);$i++){
					$where['slid']=$arr[$i]['slid'];
					$arr[$i]['slname']=$sl->where($where)->getfield('slname');
					$where['scid']=$arr[$i]['scid'];
					$arr[$i]['scname']=$sc->where($where)->getfield('scname');
					$where['pid']=$arr[$i]['pic'];
					$arr[$i]['name']=$p->where($where)->getfield('name');
				}
				$this->assign('show',$show);
				$this->assign('store',$arr);
				$this->assign('message',$message);
			}
			if(!$flag){
				$this->display();
			}
		}
		function change_store_editor($flag=null){
			$st=M('store');
			$sc=M('store_category');
			$where['stid']=$_GET['stid'];
			$store=$st->where($where)->find();
			$where['scid']=$store['scid'];
			$store['scname']=$sc->where($where)->getfield('scname');
			$category=$sc->select();
			$this->assign('store',$store);
			$this->assign('category',$category);
			if(!$flag){
				$this->display();
			}
		}
		function modi_change_store(){
			$st=M('store');
			$st->create();
			$result=$st->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'change_store_info'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Store','page2'=>'change_store_info'),1,"modify error");
			}
		}
	}

?>