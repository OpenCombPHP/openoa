<?php

namespace org\opencomb\openoa\process;

use org\opencomb\coresystem\mvc\controller\ControlPanel;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Node extends ControlPanel
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/Node.html',
		),
	) ;
	
	public function process()
	{
	    $oModel = Model::create("openoa:Process_Node");
	    $oModel->hasOne('coresystem:group',"gid","gid");
	    $oList = $oModel->load( );
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
