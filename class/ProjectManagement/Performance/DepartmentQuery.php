<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

class DepartmentQuery extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目查询',
			'view' => array (
					'template' => 'ProjectManagement/Performance/DepartmentQuery.html',
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
		$this->model('openoa:ProjectManagement','ProjectManagement')
					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
					->order('department');
						//->belongsTo('coresystem:user','responsibleperson','uid','user');
		$this->ProjectManagement->load();

		$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
		$this->doActions();
	}
	
	public function form(){
		var_dump($_POST);exit;
		$time = $this->params['select_time'];
		$arrSelectTime = $this->getSelectTime($time);
		
		$this->model('openoa:ProjectManagement','ProjectManagement')
				->group('responsibleperson')
				//->belongsTo('coresystem:user','responsibleperson','uid','user')
				//->belongsTo('coresystem:group','department','gid','group')
				->order('department')
				->where('starttime>='.$arrSelectTime[0].' and '.'starttime<='.$arrSelectTime[1]);
				$this->ProjectManagement->load();
				//var_dump($this->ProjectManagement);exit;
				$this->view()->setModel($this->ProjectManagement);
				$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
	}

	public function getSelectTime($time){
		$arrTime = explode('-',$time);
		$y = $arrTime[0];
		$m = $arrTime[1];

		$t0 = date('t',mktime(0,0,0,$m,1,$y));
		$t1 = mktime(0,0,0,$m,1,$y);
		$t2 = mktime(0,0,0,$m,$t0,$y);
		$arrSelectTime = array($t1,$t2);
		return($arrSelectTime);
	}
}