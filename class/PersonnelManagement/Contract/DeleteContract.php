<?php
namespace org\opencomb\openoa\PersonnelManagement\Contract;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class DeleteContract extends ControlPanel{
	public $arrConfig = array (
			'title' => '部门管理',
			'view' => array (
					'template' => 'PersonnelManagement/Contract/DeleteContract.html',
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$this->model('openoa:ContractManagement','contract');
		
	
		$nContract = $this->model('openoa:ContractManagement')->delete('id='.$this->params['id']);

		if($nContract)
		{
			$this->createMessage(Message::success,"删除成功") ;
		}
		
		$this->location('?c=org.opencomb.openoa.PersonnelManagement.Contract.ContractManagement');
	}
}