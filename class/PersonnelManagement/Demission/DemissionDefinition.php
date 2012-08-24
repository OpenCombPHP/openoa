<?php
namespace org\opencomb\openoa\PersonnelManagement\Demission;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class DemissionDefinition extends ControlPanel{
	public $arrConfig = array (
			'title' => '离职管理',
			'view' => array (
					'template' => 'PersonnelManagement/Demission/DemissionDefinition.html',
					'widgets'=>array(
							array(
									'id'=>'eid',
									'class'=>'text',
									'title'=>'员工工号',
							),
							array(
									'id'=> 'addtime',
									'class'=> 'text',
									'title'=> '提交时间',
							),
							array(
									'id'=> 'reason',
									'class'=> 'text',
									'type' => 'multiple',
									'title'=> '离职原因',
							),
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
		$this->doActions();
	}
	
	public function form(){
		$arrDepartment = $this->params['Department_text'];
		$arrManager = $this->params['Manager_text'];
		$arrAccuse = $this->params['Accuse_text'];
		var_dump($arrDepartment);exit;
	}
	
}