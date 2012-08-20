<?php
namespace org\opencomb\openoa\PersonnelManagement\Position;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;

/*
 * 成本对比分析
 * */
class PositionManagement extends ControlPanel{
	public $arrConfig = array (
			'title' => '职位管理',
			'view' => array (
					'template' => 'PersonnelManagement/Position/PositionManagement.html',
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
		$aPositionModel = Model::Create('openoa:PositionManagement');
		$aPositionModel->load();
		
		$this->view()->setModel($aPositionModel);
		$this->view->variables()->set('aPositionModel',$aPositionModel) ;
		$this->doActions();
	}
	
	public function form(){

	}
	
}