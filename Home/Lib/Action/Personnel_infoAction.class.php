<?php 
	class Personnel_infoAction extends PremiseAction{
		//显示个人信息
		function personal_info($flag=null){
			$p=M("personal_info");
			$per=$p->find($_SESSION['pid']);
			$this->assign('pi',$per);
			//dump($per);exit;

			if(!$flag)
				$this->display();
		}
		//修改密码页面
		function password_modi($flag=null){
			$this->assign('pid',$_GET['pid']);
			if(!$flag)
			{
				$this->display();
			}
		}
		//修改密码
		function do_password_modi($flag=null){
			$p=M('personal_info');
			$where['pid']=$_POST['pid'];
			$password=$p->where($where)->getfield('password');
			if(md5($_POST['old_password'])!=$password){
				R('Index/menu');
				$this->assign('pid',$_POST['pid']);
				$this->assign('page',"Personnel_info:password_modi");
				$this->assign('error',1);
				//$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'password_modi'),1,'原密码错误');
				$this->display('Index/index');
			}
			//dump($_SESSION);exit;
			else{
				$data['pid']=$_POST['pid'];
				$data['password']=md5($_POST['new_password']);
				$result=$p->save($data);	
				
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"password change successfully");
				
			}
		}
		//显示所有人员信息列表
		function maintain_info($flag=null){
			$p=M('personal_info');
			import('ORG.Util.Page');// 导入分页类
			$count=$p->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$p->limit($page->firstRow.','.$page->listRows)->select();
			$a=M('authority');
			for($i=0;$i<sizeof($arr);$i++){
				$where['aid']=$arr[$i]['authority'];
				$arr[$i]['authority']=$a->where($where)->getfield('aname');
			}
			$this->assign('person',$arr);
			$this->assign('show',$show);
			if(!$flag){
				$this->display();
			}
		}
		//打开特定人员的详细信息
		function info_more($flag=null){
			$p=M('personal_info');
			$arr=$p->find($_GET['pid']);
			$this->assign('pi',$arr);
			if(!$flag)
				$this->display('personal_info');
		}
		//删除人员
		function person_del(){
			$pid=$_GET['pid'];
			$p=M('personal_info');
			$result=$p->delete($pid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"delete error");
			}
		}
		//显示编辑人员页面
		function person_editor(){
			$pid=$_GET['pid'];
			$p=M('personal_info');
			$arr=$p->find($pid);
			$this->assign("pi",$arr);
			$this->display();
		}
		//编辑人员信息
		function person_modi(){
			$p=M('personal_info');
			$p->create();
			$result=$p->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"modify error");
			}
		}
		//检查工作证号唯一性
		function checkworkID(){
			if(!$this->isAjax()) halt('页面不存在');//最好做个判断，
            $workID=$_POST['workID'];
            $where['workID']=$workID;
            if(M('personal_info')->where($where)->find()){
            	if($workID==$_GET['workID']){
            		echo 'true';
            	}
            	else
                	echo 'false';//切记这是重点
                }else{
                echo 'true';
                }
        }
        //搜索人员
        function search_person(){
        	$data['workID']=$_POST['search_person'];
			$data['name']=array('like',"%{$_POST['search_person']}%");
			$data['_logic']='or';
			$p=M("personal_info");
			import('ORG.Util.Page');// 导入分页类
			$count=$p->count();//获取数据的总数
			$page  = new Page($count,15);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$arr=$p->limit($page->firstRow.','.$page->listRows)->where($data)->select();
			$this->assign('person',$arr);
			$this->assign('show',$show);
			$this->assign('page',"Personnel_info/maintain_info");
			R('Index/menu');
			$this->display('Index/index');
		}
		//添加人员信息页面
		function add_personal_info(){
			$this->display();
		}
		//添加人员信息
		function do_add_person(){
			$p=M('personal_info');
			$p->create();
			if($p->add()){
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"add successfully");

			}else{
				$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,"add error");

			}
		}
		function import_person($flag=null){
			if(!$flag)
			$this->display();
		}
		public function do_import_person(){
			$m = M('personal_info');
		if(!empty($_FILES['file']['name'])){
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
			}
			$found->found_photo=$info[0]['savename'];}
        $filetmpname = 'Public/Uploads/'.$info[0]['savename'];
        Vendor('Classes.PHPExcel');
        $objPHPExcel = PHPExcel_IOFactory::load($filetmpname);
        $arrExcel = $objPHPExcel->getSheet(0)->toArray();

        for($i=1;$i<=sizeof($arrExcel);$i++){
        	if(!$arrExcel[$i][1]||!$arrExcel[$i][14]||!$arrExcel[$i][15]){
        		$this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'import_person'),1,'you have to fill in the name,IDNo and workID');
        	}
        	array_shift($arrExcel[$i]);
        }
        //删除不要的表头部分，我的有三行不要的，删除三次
        //array_shift($arrExcel);
        // array_shift($arrExcel);
        // array_shift($arrExcel);//现在可以打印下$arrExcel，就是你想要的数组啦
       //查询数据库的字段
        
        $fieldarr = $m->query("describe personal_info");
        
        foreach($fieldarr as $v){
            $field[] = $v['Field'];
        }

        array_shift($field);//删除自动增长的ID        
        //循环给数据字段赋值
        foreach($arrExcel as $v){
            $fields[] = array_combine($field,$v);//将excel的一行数据赋值给表的字段
        }
        //批量插入        
        if($m->addAll($fields)){
            $this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'maintain_info'),1,'batch import successfully');
        }
        else
            $this->redirect('Index/index',array('page1'=>'Personnel_info','page2'=>'import_person'),1,'batch import error');
    }
	}
 ?>