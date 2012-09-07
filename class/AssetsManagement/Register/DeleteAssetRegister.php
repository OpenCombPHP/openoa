<?php
namespace org\opencomb\openoa\AssetsManagement\Register;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 删除资产登记
 * */
class DeleteAssetRegister extends OpenOaController{
	public $arrConfig = array (
			'title' => '删除资产登记',
			'view' => array (
					'template' => 'AssetsManagement/Register/DeleteAssetRegister.html',
			),
// 			'perms' => array (
// 					// 权限类型的许可
// 					'perm.purview' => array (
// 							'name' => Water::WATER_CaiWu
// 					)
// 			)
	);
	
	public function process() {
		$nAid = $this->params['aid'];
		$aAssetModel = Model::create('openoa:AssetManagement')
							->belongsTo('openoa:AssetType','type','tid','type');
		$nDeleteRow = $aAssetModel->delete('aid='.$nAid);
		if($nDeleteRow > 0){
			$this->messageQueue()->create(Message::success,'删除资产登记成功');
			$this->location('?c=org.opencomb.openoa.AssetsManagement.Register.RegisterManagement');
		}else{
			$this->messageQueue()->create(Message::error,'删除资产登记无效');
		}
	}
}