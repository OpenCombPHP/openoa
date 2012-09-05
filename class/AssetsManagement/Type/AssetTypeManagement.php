<?php
namespace org\opencomb\openoa\AssetsManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AssetTypeManagement extends OpenOaController{
	public $arrConfig = array (
			'title' => '职位管理',
			'view' => array (
					'template' => 'AssetsManagement/Type/AssetTypeManagement.html',
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
		$aTypeModel = Model::Create('openoa:AssetType');
		
		$aTypeModel->load();
		
		$this->view()->setModel($aTypeModel);
		$this->view->variables()->set('aTypeModel',$aTypeModel) ;
		$this->doActions();
	}
	
	public function form(){

	}
	
}