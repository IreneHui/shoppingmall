<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends PremiseAction{
	public function index($page1=null,$page2=null){
		
		if($page1)//调用右边页面
		{
			$this->assign('page',$page1.":".$page2);
			R($page1."/".$page2,array('flag'=>1));
			//$this->redirect('Index/index');
			
		}
		//$this->assign($assign_name,$assign_value);
		
		else 
			$this->redirect('Index/menu',array('flag'=>1));
		R('Index/menu');
		$this->display();
	}
	function menu($flag=null){
		if($_SESSION['authority']<5){
			$f=M('function');
			$where['default']=array(array('lt',5),array('egt',$_SESSION['authority']));
			$second=$f->where($where)->select();
			//dump($second);exit;
			for($i=0;$i<sizeof($second);$i++){
				$index=$second[$i]['father_id'];
				$count=sizeof($first[$index]['second']);
				if($count==0){
					$where1['f_id']=$index;
					$first[$index]['f_name']=$f->where($where1)->getfield('f_name');
					$first[$index]['ef_name']=$f->where($where1)->getfield('ef_name');
					//$total[sizeof($total)]['father_id']=$second[$i]['father_id'];
					//$total[sizeof($total)-1]['f_name']=$f->where($where1)->getfield('f_name');
				}
				$first[$index]['second'][$count]=$second[$i];
			}
			
			$this->assign('first',$first);
			//$this->assign('second',$first);
			if($flag){
				$this->display('Index/index');
			}
		}
		else{
			$cf=M('cfunction');
			$f=M('function');
			$where['pid']=$_SESSION['pid'];
			$second=$cf->where($where)->select();
			//dump($second);exit;
			for($i=0;$i<sizeof($second);$i++){
				$index=$second[$i]['father_id'];
				$count=sizeof($first[$index]['second']);
				if($count==0){
					$where1['f_id']=$index;
					$first[$index]['f_name']=$f->where($where1)->getfield('f_name');
					$first[$index]['ef_name']=$f->where($where1)->getfield('ef_name');
					//$total[sizeof($total)]['father_id']=$second[$i]['father_id'];
					//$total[sizeof($total)-1]['f_name']=$f->where($where1)->getfield('f_name');
				}
				$first[$index]['second'][$count]=$second[$i];
			}
			
			$this->assign('first',$first);
			//$this->assign('second',$first);
			if($flag)
				$this->display('Index/index');

		}
	}
    public function index1(){
	$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
}