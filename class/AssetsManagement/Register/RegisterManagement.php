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
class RegisterManagement extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目绩效',
			'view' => array (
					'template' => 'AssetsManagement/Register/RegisterManagement.html',
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