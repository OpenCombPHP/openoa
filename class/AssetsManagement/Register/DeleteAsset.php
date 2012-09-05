<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 成本对比分析
 * */
class AddAsset extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目绩效',
			'view' => array (
					'template' => 'ProjectManagement/Performance/DepartmentCount.html',
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
					->group('responsibleperson')
 					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
 					->order('department');
		$this->ProjectManagement->load();
		$arrCount = array();
		foreach($this->ProjectManagement as $aProject)
		{
			$aTempModel = Model::create('openoa:ProjectManagement');
			$arrCount[] = array(
							'department' => $aProject['group.name']
							,'responsible' => 	$aProject['user.username']
							,'complete' => 	$aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status=3')
							,'nocomplete' => $aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status<>3')
			);
		}
		$this->doActions();
	}
	
	public function form(){
		
	}
}