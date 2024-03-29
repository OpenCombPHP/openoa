<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;


class DepartmentNextQuery extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门下月计划',
			'view' => array (
					'template' => 'ProjectManagement/Performance/DepartmentNextQuery.html',
					'widgets'=>array(
					)
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		//var_dump($this->getNextTime());exit; 
		$arrNext = array();
		$arrNext = $this->getNextTime();
		$this->model('openoa:ProjectManagement','ProjectManagement')
					->group('responsibleperson')
 					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
 					->order('department')
					->where('starttime>='.$arrNext[0].' and '.'starttime<='.$arrNext[1]);
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