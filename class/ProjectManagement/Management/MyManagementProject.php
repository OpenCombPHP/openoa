<?php
namespace org\opencomb\openoa\ProjectManagement\Management;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\auth\IdManager ;

/*
 * 成本对比分析
 * */
class MyManagementProject extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'ProjectManagement/Management/MyManagementProject.html',
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
		$this->view->variables()->set('sPublisher',IdManager::singleton()->currentUserId());
		$this->model('openoa:ProjectManagement','ProjectManagement')
				->belongsTo('coresystem:user','responsibleperson','uid','user');
		$this->ProjectManagement->load(IdManager::singleton()->currentUserId(),'responsibleperson');
		
		$this->view()->setModel($this->ProjectManagement);
		$this->view->variables()->set('aProjectManagement',$this->ProjectManagement) ;
		$this->doActions();
	}
	
	public function form(){
	}	
}