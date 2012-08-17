<?php
namespace org\opencomb\oa\PersonnelManagement\Employee;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class DeleteEmployee extends ControlPanel{
	public $arrConfig = array (
			'title' => '部门管理',
			'view' => array (
					'template' => 'PersonnelManagement/Employee/DeleteEmployee.html',
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$this->model('openoa:EmployeeManagement','employee')
							->hasOne('coresystem:userinfo','uid','uid','userinfo')
							->hasOne('coresystem:user','uid','uid','user');
		
	
		$nUser = $this->model('coresystem:user')->delete('uid='.$this->params['eid']);
		$nUserInfo = $this->model('coresystem:userinfo')->delete('uid='.$this->params['eid']);
		$nEmployee = $this->model('openoa:EmployeeManagement')->delete('uid='.$this->params['eid']);

		if($nEmployee && $nUserInfo && $nUser)
		{
			$this->createMessage(Message::success,"删除成功") ;
		}
		
		$this->location('?c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement');
	}
}