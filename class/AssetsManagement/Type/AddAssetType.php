<?php
namespace org\opencomb\openoa\AssetsManagement\Type;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;

/*
 * 成本对比分析
 * */
class AddAssetType extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加职位',
			'view' => array (
					'template' => 'AssetsManagement/Type/AddAssetType.html',
					'widgets'=>array(
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
		$aTypeModel = Model::Create('openoa:AssetType');
		$aTypeModel->load();
		
		$this->view()->setModel($aTypeModel);
		$this->view->variables()->set('aTypeModel',$aTypeModel) ;
		$this->doActions();
	}
	
	public function form(){
		if( empty($this->params['name']) )
		{
			$this->createMessage(Message::error,"%s 不能为空",'类别名称') ;
			return ;
		}
		
		$sName = $this->params['name'];
		$this->model('openoa:AssetType','type');
		$this->type->load();
		$nUpdateRows = $this->type->replace(array('name'=>$sName));
		
		if($nUpdateRows > 0){
			$this->messageQueue()->create(Message::success,"添加类别成功") ;
			$this->location('?c=org.opencomb.openoa.AssetsManagement.Type.AssetTypeManagement');
		}else{
			$this->view->createMessage(Message::error,"添加类别失败") ;
		}
	}	
}