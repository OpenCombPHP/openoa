<?php
namespace org\opencomb\openoa\ProjectManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class DeleteProjectType extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门管理',
			'view' => array (
					'template' => 'ProjectManagement/Type/DeleteProjectType.html',
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$aTypeModel = Model::Create('openoa:ProjectType');
		if($aTypeModel->delete('pid='.$this->params['pid']))
		{
			$this->createMessage(Message::success,"删除成功") ;
		}
		
		$this->location('?c=org.opencomb.openoa.ProjectManagement.Type.ProjectTypeManagement');
	}
}