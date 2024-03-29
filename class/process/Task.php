<?php

namespace org\opencomb\openoa\process;

use org\opencomb\coresystem\mvc\controller\ControlPanel;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Task extends ControlPanel
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/Task.html',
		),
	) ;
	
	public function process()
	{
	    $oModel = Model::create("openoa:Process_Task");
	    $oList = $oModel->load( );
	    $this->view()->variables()->set('list', $oList );
	}
}
