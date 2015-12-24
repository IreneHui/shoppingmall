<?php 
	class Salary_ssAction extends PremiseAction{
		function search_year(){
			$salary=M('salary');
			$where['year']=$_POST['search_ss_year'];
			if($salary->where($where)->find()){
				$year=$_POST['search_ss_year'];		
			}
			else{
				$year=date('Y',time());
				$error="1";
			}
			for($i=0;$i<12;$i++){
				$month[$i]=$i+1;
			}
			$info['month']='1';
			$info['year']=$year;
			$this->assign('info',$info);
			$this->assign('month',$month);
			$this->assign('error',$error);
			$this->assign('year',$year);
			$this->assign('cmonth','1');
			$this->assign('page','Salary_ss/sss_personal');
			R('Index/menu');
			$this->display('Index/index');
			//$this->display('Salary_ss/sss_personal');
			//$this->assign('page','Salary_ss:sss_personal');
			//dump($_GET);exit;
			// R("Index/index",array('page'=>'Salary_ss:sss_personal'));
			//$this->assign('page',"Index:index");
			//$this->display("Index/index");
			// $this->display('Salary_ss/sss_personal');
			
			//$this->assign('page','Salary_ss/sss_personal');
			// R("Index/index",array('page1'=>"Salary_ss:salary_info"));
			//$this->display("Salary_ss/sss_personal");
			

		}
		function sss_personal($flag=null){
			if($_GET['year']){
				$year=$_GET['year'];
			}
			else
				$year=date('Y',time());
			for($i=0;$i<12;$i++){
				$month[$i]=$i+1;
			}
			if($_GET['month'])
				$this->assign('cmonth',$_GET['month']);
			else
				$this->assign('cmonth','1');
			$info['year']=$year;
			$info['month']=$cmonth;
			$this->assign('info',$info);
			$this->assign('month',$month);
			$this->assign('year',$year);
			R("Salary_ss/salary_info",array('year'=>$year,'month'=>$cmonth));
			if(!$flag)
				$this->display();
		}
		function salary_info($flag=null){
			$salary=M('salary');
			$where['year']=$_GET['year'];
			$where['month']=$_GET['month'];
			$where['pid']=$_SESSION['pid'];
			$arr=$salary->where($where)->find();
			$this->assign('info',$arr);
			$this->assign('page1','salary_info');
			if(!$flag)
				$this->display();
		}
		function social_security_info($flag=null){
			$ss=M('social_security');
			$where['year']=$_GET['year'];
			$where['month']=$_GET['month'];
			$where['pid']=$_SESSION['pid'];
			$arr=$ss->where($where)->find();
			$this->assign('info',$arr);
			$this->assign('page1','social_security_info');
			if(!$flag)
				$this->display('Salary_ss/social_security_info');
		}
		function accumulation_fund_info($flag=null){
			$af=M('accumulation_fund');
			$where['year']=$_GET['year'];
			$where['month']=$_GET['month'];
			$where['pid']=$_SESSION['pid'];
			$arr=$af->where($where)->find();
			$this->assign('info',$arr);
			$this->assign('page1','accumulation_fund_info');
			if(!$flag)
				$this->display('Salary_ss/accumulation_fund_info');
		}
		function sss_management($flag=null){
			if($_GET['year']){
				$year=$_GET['year'];
			}
			else
				$year=date('Y',time());
			if($_GET['month'])
				$cmonth=$_GET['month'];
			else{
				$cmonth=date('m',time());
			}
			$info['year']=$year;
			$info['month']=$cmonth;
			$this->assign('info',$info);
			$this->assign('month',$cmonth);
			$this->assign('year',$year);
			//R("Salary_ss/salary_list",array('flag'=>1,'year'=>$year,'month'=>$cmonth));
			if(!$flag)
				$this->display();
		}
		function salary_list($flag=null){
			$salary=M('salary');
			if($_GET['year'])
				$where['year']=$_GET['year'];
			else
				$year=date('Y',time());
			$where['month']=$_GET['month'];
			$arr=$salary->where($where)->select();
			
			$p=M('personal_info');
			for($i=0;$i<sizeof($arr);$i++){
				$data['pid']=$arr[$i]['pid'];
				$arr[$i]['workID']=$p->where($data)->getfield('workID');
				$arr[$i]['IDNo']=$p->where($data)->getfield('IDNo');	
				$arr[$i]['name']=$p->where($data)->getfield('name');
			}
			$this->assign('info',$arr);
			$this->assign('page1','salary_list');
			if(!$flag)
				$this->display();
		}
		function social_security_list($flag=null){
			$ss=M('social_security');
			if($_GET['year'])
				$where['year']=$_GET['year'];
			else
				$year=date('Y',time());
			$where['month']=$_GET['month'];
			$arr=$ss->where($where)->select();
			
			$p=M('personal_info');
			for($i=0;$i<sizeof($arr);$i++){
				$data['pid']=$arr[$i]['pid'];
				$arr[$i]['workID']=$p->where($data)->getfield('workID');
				$arr[$i]['IDNo']=$p->where($data)->getfield('IDNo');	
				$arr[$i]['name']=$p->where($data)->getfield('name');
			}
			$this->assign('info',$arr);
			$this->assign('page1','social_security_list');
			if(!$flag)
				$this->display();
		}
		function accumulation_fund_list($flag=null){
			$af=M('accumulation_fund');
			if($_GET['year'])
				$where['year']=$_GET['year'];
			else
				$year=date('Y',time());
			$where['month']=$_GET['month'];
			$arr=$af->where($where)->select();
			
			$p=M('personal_info');
			for($i=0;$i<sizeof($arr);$i++){
				$data['pid']=$arr[$i]['pid'];
				$arr[$i]['workID']=$p->where($data)->getfield('workID');
				$arr[$i]['IDNo']=$p->where($data)->getfield('IDNo');	
				$arr[$i]['name']=$p->where($data)->getfield('name');
			}
			$this->assign('info',$arr);
			$this->assign('page1','salary_list');
			if(!$flag)
				$this->display();
		}
		function salary_more(){
			$s=M('salary');
			$where['sid']=$_GET['sid'];
			$arr=$s->where($where)->find();
			$this->assign('info',$arr);
			$this->assign('page1','Salary_ss/salary_info');
			$this->display("Salary_ss/sss_management");
		}
		//删除工资
		function salary_del(){
			$sid=$_GET['sid'];
			$s=M('salary');
			$result=$s->delete($sid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete error");
			}
		}
		function social_security_del(){
			$sid=$_GET['ssid'];
			$s=M('social_security');
			$result=$s->delete($sid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete error");
			}
		}
		function accumulation_fund_del(){
			$afid=$_GET['afid'];
			$s=M('accumulation_fund');
			$result=$s->delete($afid);
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"delete error");
			}
		}
		function search_salary(){
			$salary=M('salary');
			$data['name']=array('like',"%{$_POST['search_salary']}%");
			$data['year']=$_POST['search_salary'];
			$data['month']=$_POST['search_salary'];
			$data['_logic']='or';
			$info=$salary->where($data)->select();
			$this->assign('info',$info);
			$this->assign('page','Salary_ss/sss_management');
			$this->assign('page1','Salary_ss/salary_list');
			R('Index/menu');
			$this->display('Index/index');	
		}
		function search_social_security(){
			$salary=M('social_security');
			$where['name']=array('like',"%{$_POST['search_salary']}%");
			$p=M('personal_info');
			$data['pid']=$p->where($where)->getfield('pid');
			$data['year']=$_POST['search_salary'];
			$data['month']=$_POST['search_salary'];
			$data['_logic']='or';
			$info=$salary->where($data)->select();
			for($i=0;$i<sizeof($info);$i++){
				$data['pid']=$info[$i]['pid'];
				$info[$i]['workID']=$p->where($data)->getfield('workID');
				$info[$i]['IDNo']=$p->where($data)->getfield('IDNo');	
				$info[$i]['name']=$p->where($data)->getfield('name');
			}
			$this->assign('info',$info);
			$this->assign('page','Salary_ss/sss_management');
			$this->assign('page1','Salary_ss/social_security_list');
			R('Index/menu');
			$this->display('Index/index');	
		}
		function search_accumulation_fund(){
			$salary=M('accumulation_fund');
			$where['name']=array('like',"%{$_POST['search_salary']}%");
			$p=M('personal_info');
			$data['pid']=$p->where($where)->getfield('pid');
			$data['year']=$_POST['search_salary'];
			$data['month']=$_POST['search_salary'];
			$data['_logic']='or';
			$info=$salary->where($data)->select();
			for($i=0;$i<sizeof($info);$i++){
				$data['pid']=$info[$i]['pid'];
				$info[$i]['workID']=$p->where($data)->getfield('workID');
				$info[$i]['IDNo']=$p->where($data)->getfield('IDNo');	
				$info[$i]['name']=$p->where($data)->getfield('name');
			}
			$this->assign('info',$info);
			$this->assign('page','Salary_ss/sss_management');
			$this->assign('page1','Salary_ss/accumulation_fund_list');
			R('Index/menu');
			$this->display('Index/index');	
		}
		function salary_editor(){
			$where['sid']=$_GET['sid'];
			$s=M('salary');
			$arr=$s->where($where)->find();
			$p=M('personal_info');
			$data['pid']=$arr['pid'];
			$arr['workID']=$p->where($data)->getfield('workID');
			//dump($arr);
			$this->assign('info',$arr);
			$this->display();
		}
		function salary_modi(){
			$s=M('salary');
			$s->create();
			$result=$s->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify error");
			}
		}
		function social_security_editor(){
			$where['ssid']=$_GET['ssid'];
			$s=M('social_security');
			$arr=$s->where($where)->find();
			$p=M('personal_info');
			$data['pid']=$arr['pid'];
			$arr['workID']=$p->where($data)->getfield('workID');
			//dump($arr);
			$this->assign('info',$arr);
			$this->display();
		}
		function social_security_modi(){
			$s=M('social_security');
			$s->create();
			$result=$s->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify error");
			}
		}
		function accumulation_fund_editor(){
			$where['afid']=$_GET['afid'];
			$s=M('accumulation_fund');
			$arr=$s->where($where)->find();
			$p=M('personal_info');
			$data['pid']=$arr['pid'];
			$arr['workID']=$p->where($data)->getfield('workID');
			//dump($arr);
			$this->assign('info',$arr);
			$this->display();
		}
		function accumulation_fund_modi(){
			$s=M('accumulation_fund');
			$s->create();
			$result=$s->save();
			if($result){
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify successfully");
			}
			else{
				$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,"modify error");
			}
		}

		function batch_import($flag=null){
			if(!$flag)
			$this->display();
		}
		public function do_batch_import(){
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
        	if(!$arrExcel[$i][1]||!$arrExcel[$i][2]){
        		$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'batch_import'),1,'you have to fill in the year and month');
        	}
        }
        //删除不要的表头部分，我的有三行不要的，删除三次
        // array_shift($arrExcel);
        // array_shift($arrExcel);
        // array_shift($arrExcel);//现在可以打印下$arrExcel，就是你想要的数组啦
       //查询数据库的字段
        if($_POST['sss']=='salary'){
        	$m = M('salary');
        	$fieldarr = $m->query("describe salary");
        }
        else if($_POST['sss']=='social_security'){
        	$m = M('social_security');
        	$fieldarr = $m->query("describe social_security");
        }
        else if($_POST['sss']=='accumulation_fund'){
        	$m = M('accumulation_fund');
        	$fieldarr = $m->query("describe accumulation_fund");
        }
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
            $this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,'batch import successfully');
        }
        else
            $this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,'batch import error');
    }
    function copy_last_month(){
    	$year=date('Y',time());
    	$month=date('m',time());
    	if($_GET['sss']=="salary")
    		$m=M('salary');
    	else if($_GET['sss']=="social_security")
    		$m=M('social_security');
    	else
    		$m=M('accumulation_fund');
    	if($month==1){
    		$where['year']=$year-1;
    		$where['month']=12;
    	}
    	else{
    		$where['month']=$month-1;
    		$where['year']=$year;
    	}
    	$where['pid']=$_SESSION['pid'];
    	$arr=$m->where($where)->find();
    	$arr['year']=$year;
    	$arr['month']=$month;

    	$m->create($arr);
    	$result=$m->save();
    	if($result)
    		$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'sss_management'),1,'add successfully');
    	else
    		$this->redirect('Index/index',array('page1'=>'Salary_ss','page2'=>'batch_import'),1,'add error');

    }
	}
 ?>