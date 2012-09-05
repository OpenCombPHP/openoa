<?php
namespace org\opencomb\openoa\PersonnelManagement\Demission;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AddDemission extends OpenOaController{
	public $arrConfig = array (
			'title' => '离职管理',
			'view' => array (
					'template' => 'PersonnelManagement/Demission/AddDemission.html',
					'widgets'=>array(
							array(
									'id'=>'eid',
									'class'=>'text',
									'title'=>'员工工号',
							),
							array(
									'id'=>'gid',
									'class'=>'text',
									'title'=>'所在部门',
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
		
	}
	
	public function form(){
		$sUid = $this->params['hidden_uid'];
		$sName = $this->params['name'];
		$sGid = $this->params['hidden_gid'];
		$sGid = $this->params['hidden_gid'];
		$sDepartment = $this->params['department'];
		$sApplyTime = $this->params['addtime'];
		$SReason = $this->prarms['reason'];
	}
	
}