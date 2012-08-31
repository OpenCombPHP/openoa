<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

class DeparmentQuery extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目查询',
			'view' => array (
					'template' => 'ProjectManagement/Performance/DeparmentPerformanceQuery.html',
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
		
		//var_dump($this->ProjectManagement);exit;
		$this->view()->setModel($this->ProjectManagement);
		$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
		//$this->view->variables()->set('sNow',strtotime(date('Y-m-d'))) ;
		$this->doActions();
	}
	
	public function form(){
	}	
}