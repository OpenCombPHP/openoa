<?php
namespace org\opencomb\oa;

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
class Oa extends Extension
{
	
	/**
	 * 载入扩展
	 */
	public function load()
	{	
		ControlPanel::registerMenuHandler( array(__CLASS__,'buildControlPanelMenu') ) ;
		
		//设置首页控制器
		$aAccessRouter = AccessRouter::singleton() ;
	}
	
	static public function buildControlPanelMenu(array & $arrConfig)
	{
		$arrConfig['item:oa'] = array(
				'title'=> '人事管理' ,
				'link' => '?c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement' ,
				'query' => 'c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement' ,
				'menu' => 1,
				'item:depatmentmanagement' => array(
						'title' => '部门管理' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.Dep.DepartmentManagement' ,
				),
				'item:positionmanagement' => array(
						'title' => '职位管理' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.Position.PositionManagement' ,
				),
				'item:employeemanagement' => array(
						'title' => '员工管理' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.Employee.EmployeeManagement' ,
				),
				'item:demissionmanagement' => array(
						'title' => '离职管理' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.Demission.DemissionManagement' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.Demission.DemissionManagement' ,
				),
				'item:personnelcontractmanagement' => array(
						'title' => '人事合同管理' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.PersonnelContractManagement' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.PersonnelContractManagement' ,
				),
				'item:contractexpireremind' => array(
						'title' => '合同到期提醒' ,
						'link' => '?c=org.opencomb.oa.PersonnelManagement.ContractExpireRemind' ,
						'query' => 'c=org.opencomb.oa.PersonnelManagement.ContractExpireRemind' ,
				),
		);
	}
}
