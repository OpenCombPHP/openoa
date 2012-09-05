<?php
namespace org\opencomb\openoa\AssetsManagement\Register;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 成本对比分析
 * */
class AddAsset extends OpenOaController{
	public $arrConfig = array (
			'title' => '添加资产',
			'view' => array (
					'template' => 'AssetsManagement/Register/AddAsset.html',
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
		$aTypeModel = Model::create('openoa:AssetType');
		$aTypeModel->load();
		$this->view->variables()->set('aTypeModel',$aTypeModel);
		$this->doActions();
	}
	
	public function form(){
		$sSid = $this->params['sid'];
		$sName = $this->params['name'];
		$nType = $this->params['type'];
		
		$aAssetModel = Model::create('openoa:AssetManagement');
		$nAddRows = $aAssetModel->replace(array(
					'sid' => $sSid
					,'name' => $sName
					,'type' => 	$nType
					,'status' => 1
				)
		);
		if($nAddRows > 0){
			$this->messageQueue()->create(Message::success,"资产添加成功") ;
			$this->location('?c=org.opencomb.openoa.AssetsManagement.Management.AssetsManagement');
		}else{
			$this->messageQueue()->create(Message::error,"资产添加失败") ;
		}
	}
}