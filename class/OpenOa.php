<?php
namespace org\opencomb\openoa;

use org\opencomb\openoa\controller\OpenOaController;

use org\opencomb\coresystem\auth\PurviewSetting;

use org\jecat\framework\system\AccessRouter;

use org\opencomb\platform\ext\Extension;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/**
 * 
 * @wiki /蜂巢/oa
 * @author anubis
 *
 */
class OpenOa extends Extension
{
	
	/**
	 * 载入扩展
	 */
	public function load()
	{	
		
		OpenOaController::registerMenuHandler( array(__CLASS__,'buildControlPanelMenu') ) ;
		
		ControlPanel::registerMenuHandler( array(__CLASS__,'buildControlPanelMenu') ) ;
		
		//设置首页控制器
		$aAccessRouter = AccessRouter::singleton() ;
	}
	
	static public function buildControlPanelMenu(array & $arrConfig)
	{
		$arrConfig['item:openoa'] = array(
				'title'=> '人事管理' ,
				'link' => '?c=org.opencomb.openoa.PersonnelManagement.Dep.DepartmentManagement' ,
				'query' => 'c=org.opencomb.openoa.PersonnelManagement.Dep.DepartmentManagement' ,
				'menu' => 1,
				'item:depatmentmanagement' => array(
						'title' => '部门管理' ,
						'link' => '?c=org.opencomb.openoa.PersonnelManagement.Dep.DepartmentManagement' ,
						'query' => 'c=org.opencomb.openoa.PersonnelManagement.Dep.DepartmentManagement' ,
				),
				'item:positionmanagement' => array(
						'title' => '职位管理' ,
						'link' => '?c=org.opencomb.openoa.PersonnelManagement.Position.PositionManagement' ,
						'query' => 'c=org.opencomb.openoa.PersonnelManagement.Position.PositionManagement' ,
				),
				'item:employeemanagement' => array(
						'title' => '员工管理' ,
						'link' => '?c=org.opencomb.openoa.PersonnelManagement.Employee.EmployeeManagement' ,
						'query' => 'c=org.opencomb.openoa.PersonnelManagement.Employee.EmployeeManagement' ,
				),
				'item:demissionmanagement' => array(
						'title' => '离职管理' ,
						'link' => '?c=org.opencomb.openoa.PersonnelManagement.Demission.DemissionManagement' ,
						'query' => 'c=org.opencomb.openoa.PersonnelManagement.Demission.DemissionManagement' ,
						'menu' => 1,
						'item:demissiondefinition' => array(
							'title' => '离职流程定义' ,
							'link' => '?c=org.opencomb.openoa.PersonnelManagement.Demission.DemissionDefinition' ,
							'query' => 'c=org.opencomb.openoa.PersonnelManagement.Demission.DemissionDefinition' ,
						)
				),
				'item:personnelcontractmanagement' => array(
						'title' => '人事合同管理' ,
						'link' => '?c=org.opencomb.openoa.PersonnelManagement.Contract.ContractManagement' ,
						'query' => 'c=org.opencomb.openoa.PersonnelManagement.Contract.ContractManagement' ,
						'menu' => 1,
						'item:notsignedcontract' => array(
							'title' => '未签合同管理' ,
							'link' => '?c=org.opencomb.openoa.PersonnelManagement.Contract.NoContract' ,
							'query' => 'c=org.opencomb.openoa.PersonnelManagement.Contract.NoContract' ,
						)
				),
		);
	}
}
