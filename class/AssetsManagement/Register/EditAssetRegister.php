<?php
namespace org\opencomb\openoa\AssetsManagement\Register;

use org\jecat\framework\db\sql\Update;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 编辑资产登记
 * */
class EditAssetRegister extends OpenOaController{
	public $arrConfig = array (
			'title' => '编辑资产登记',
			'view' => array (
					'template' => 'AssetsManagement/Register/EditAssetRegister.html',
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
		$nAid = $this->params['aid'];
		if(isset($nAid) && $nAid != ''){
			$aTypeModel = Model::create('openoa:AssetType');
			$aTypeModel->load();
			$aAssetModel = Model::create('openoa:AssetManagement')
							->belongsTo('openoa:AssetType');
			$aAssetModel->load($nAid,'aid');
			
			$this->view->variables()->set('aTypeModel',$aTypeModel);
			$this->view->variables()->set('aAssetModel',$aAssetModel);
		}else{
			$this->messageQueue()->create(Message::error,'无可编辑的内容');
		}
		
// 		$sPrefix = DB::singleton()->tableNamePrefix();
// 		$sSQLcomplete = "select *,count(*) from ".$sPrefix."openoa_ProjectManagement"." group by responsibleperson"." order by department";
// 		$aComplete = DB::singleton()->query($sSQLcomplete);
// 		var_dump($aComplete->fetchAll());exit;
		
// 		$sSQLNocomplete = "select *,count(*) from ".$sPrefix."openoa_ProjectManagement"." where status<>3"." group by responsibleperson"." order by department";
// 		$aNoComplete = DB::singleton()->query($sSQLNocomplete);
// 		var_dump($aNoComplete->fetchAll());

		$this->doActions();
	}
	
	public function form(){
		$nAid = $this->params['edit_hide_aid'];
		$sSid = $this->params['edit_sid'];
		$sName = $this->params['edit_name'];
		$nType = $this->params['edit_type'];
		$nStatus = $this->params['edit_status'];
		
		$aAssetModel = Model::create('openoa:AssetManagement');
		$nUpdateRow = $aAssetModel->update(
				array(
					'sid' => $sSid
					,'name' => $sName
					,'type' => $nType
					,'status' => $nStatus	
				),	'aid='.$nAid
		);
		
		if($nUpdateRow > 0){
			$this->messageQueue()->create(Message::success,'编辑成功');
			$this->location('?c=org.opencomb.openoa.AssetsManagement.Register.RegisterManagement');
		}else{
			$this->messageQueue()->create(Message::error,'无可更新内容');
		}
		
	}

}