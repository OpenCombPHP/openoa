<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;
use org\jecat\framework\auth\IdManager ;

/*
 * 成本对比分析
 * */
class MyCurrentQuery extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目绩效',
			'view' => array (
					'template' => 'ProjectManagement/Performance/MyCurrentQuery.html',
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
		//echo IdManager::singleton()->currentUserId();exit;
		//$this->view->variables()->set('sPublisher',IdManager::singleton()->currentUserId());
		$arrCurrent = array();
		$arrCurrent = $this->getCurrentTime();
		$this->model('openoa:ProjectManagement','ProjectManagement')
 					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
					->where('starttime>='.$arrCurrent[0].' and '.'starttime<='.$arrCurrent[1].' and '.'responsibleperson='.IdManager::singleton()->currentUserId());
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
	
}