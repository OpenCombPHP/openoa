<?php
namespace org\opencomb\openoa\ProjectManagement\Performance;

use org\jecat\framework\message\Message;
use org\jecat\framework\mvc\model\Model;
use org\opencomb\coresystem\mvc\controller\ControlPanel;
use org\opencomb\openoa\controller\OpenOaController;
use org\jecat\framework\db\DB;

/*
 * 成本对比分析
 * */
class DepartmentCount extends OpenOaController{
	public $arrConfig = array (
			'title' => '部门项目绩效',
			'view' => array (
					'template' => 'ProjectManagement/Performance/DepartmentCount.html',
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
		$this->model('openoa:ProjectManagement','ProjectManagement')
					->group('responsibleperson')
 					->belongsTo('coresystem:user','responsibleperson','uid','user')
					->belongsTo('coresystem:group','department','gid','group')
 					->order('department');
		$this->ProjectManagement->load();
		$arrCount = array();
		foreach($this->ProjectManagement as $aProject)
		{
			$aTempModel = Model::create('openoa:ProjectManagement');
			$arrCount[] = array(
							'department' => $aProject['group.name']
							,'responsible' => 	$aProject['user.username']
							,'complete' => 	$aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status=3')
							,'nocomplete' => $aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status<>3')
			);
			//echo $aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status=3');
			//echo $aTempModel->queryCount('responsibleperson='.$aProject['responsibleperson'].' and '.'status<>3');exit;
			
		}
		$this->view->variables()->set('arrCount',$arrCount) ;
		
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