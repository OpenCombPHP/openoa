<?php
namespace org\opencomb\openoa\PersonnelManagement\Position;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class DeletePosition extends ControlPanel{
	public $arrConfig = array (
			'title' => '部门管理',
			'view' => array (
					'template' => 'PersonnelManagement/Position/DeletePosition.html',
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$aPositionModel = Model::Create('openoa:PositionManagement');
		if($aPositionModel->delete('pid='.$this->params['pid']))
		{
			$this->createMessage(Message::success,"删除成功") ;
		}
		
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement');
	}
}