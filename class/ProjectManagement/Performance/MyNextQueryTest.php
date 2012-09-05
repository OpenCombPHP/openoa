<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\auth\IdManager ;

class MyNextQueryTest extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目查询',
			//'view' => array (
					//'template' => 'ProjectManagement/Performance/MyNextQuery.html',
					//'widgets'=>array(
					//)
			//),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$arrTest = array(
			'A'=>'1'
			,'B' => '2'
			,'C' => '3'	
		);
		echo json_encode($arrTest);
		exit;
// 		echo strtotime('1970-01-01');
// 		echo mktime(0,0,0,1,1,1970);exit;
// 		$arrTest = $this->getCurrentTime();
// 		echo strtotime('next month',$arrTest[0])."<br/>";
// 		echo strtotime('2012-09-01',$arrTest[0]);exit;
		//var_dump($this->getNextTime());exit; 
		$arrNext = array();
		$arrNext = $this->getNextTime();
		$this->model('openoa:ProjectManagement','ProjectManagement')
					->group('responsibleperson')
 					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
 					->order('department')
					->where('starttime>='.$arrNext[0].' and '.'starttime<='.$arrNext[1].' and '.'responsibleperson='.IdManager::singleton()->currentUserId());
		$this->ProjectManagement->load();
		
		$this->view()->setModel($this->ProjectManagement);
		$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
		$this->doActions();
	}
	
	public function form(){
	}

	public function getCurrentTime(){
		$y = date('Y',time());
		$m = date('m',time());
		$d = date('d',time());
		$t0 = date('t');
		$t1 = mktime(0,0,0,$m,1,$y);
		$t2 = mktime(0,0,0,$m,$t0,$y);
		$arrCurrentTime = array($t1,$t2);
		return($arrCurrentTime);
	}
	
	public function getNextTime(){//获取指定日期下个月的第一天和最后一天
		
		$arr = getdate();
		if($arr['mon'] == 12){
			$y = $arr['year'] +1;
			$m = $arr['mon'] -11;
			$d = date('t',mkdir(0,0,0,$m,1,$y));
			$t1 = mktime(0,0,0,$m,1,$y);
			$t2 = mktime(0,0,0,$m,$d,$y);
			$arrCurrentTime = array($t1,$t2);
			return($arrCurrentTime);
		}else{
			$y = date('Y',time());
			$m = $arr['mon'] +1;
			$t0 = date('t');
			$t1 = mktime(0,0,0,$m,1,$y);
			$t2 = mktime(0,0,0,$m,$t0,$y);
			$arrCurrentTime = array($t1,$t2);
			return($arrCurrentTime);
		}
	}
}