<?php
namespace org\opencomb\openoa\ProjectManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class ProjectTypeManagement extends ControlPanel{
	public $arrConfig = array (
			'title' => '职位管理',
			'view' => array (
					'template' => 'ProjectManagement/Type/ProjectTypeManagement.html',
			),
			'widget:paginator' => array(  //分页器bean
					'class' => 'paginator' ,
					'count' => 10, //每页10项
					'nums' => 5   //显示5个页码
			) ,
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$aTypeModel = Model::Create('openoa:ProjectType');
		
		$aTypeModel->load();
		
		$this->view()->setModel($aTypeModel);
		$this->view->variables()->set('aTypeModel',$aTypeModel) ;
		$this->doActions();
	}
	
	public function form(){

	}
	
}