<?php
namespace org\opencomb\openoa\AssetsManagement\Discard;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 成本对比分析
 * */
class AssetDiscardManagement extends OpenOaController{
	public $arrConfig = array (
			'title' => '资产登记',
			'view' => array (
					'template' => 'AssetsManagement/Discard/AssetDiscardManagement.html',
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
		$aAssetManagementModel = Model::create('openoa:AssetManagement')
								->belongsTo('openoa:AssetType','type','tid','type');
		$aAssetManagementModel->load();
		$this->view->variables()->set('aAssetManagementModel',$aAssetManagementModel);
		$this->doActions();
	}
	
	public function form(){
		$aAssetManagementModel = Model::create('openoa:AssetManagement')
						->belongsTo('openoa:AssetType','type','tid','type');
		$aAssetManagementModel->load();
		$arrAid = $this->params['id_key'];
		$nUpdateRows = 0;
		
		foreach($arrAid as $aid)
		{
			$nTemp = $aAssetManagementModel->update(
					array(
						'status' => 4		
					),'aid='.$aid
			);
			$nUpdateRows+= $nTemp;
		}
		
		if($nUpdateRows > 0){
			$this->messageQueue(Message::success,'更新成功');
			$this->location('?c=org.opencomb.openoa.AssetsManagement.Discard.AssetDiscardManagement');
		}else{
			$this->messageQueue(Message::error,'更新失败');
		}
	}

	public function formSearch(){
		$aAssetManagementModel = Model::create('openoa:AssetManagement')
					->belongsTo('openoa:AssetType','type','tid','type');
		
		if(isset($this->params['search_key']) && $this->params['search_key'] != ''){
			$aAssetManagementModel->load($this->params['search_key'],'sid');
		}else{
			$aAssetManagementModel->load();
		}
		
		$this->view->variables()->set('aAssetManagementModel',$aAssetManagementModel);
	}
	
	public function getCurrentTime(){
		$y = date('Y',time());
		$m = date('m',time());
		$d = date('d',time());
		$t0 = date('t');
		$t1 = mktime(0,0,0,$m,1,$y);
		$t2 = mktime(0,0,0,$m,$t0,$y);
		$arrCurrentTime = array($t1,$t2);
		return($arrCurrentTime);
	}
	
	public function getNextTime(){
		
	}
}