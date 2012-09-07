<?php

namespace org\opencomb\openoa\process;

use org\opencomb\coresystem\mvc\controller\ControlPanel;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class CreateTask extends ControlPanel
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/CreateTask.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
            $oTaskModel = Model::create("openoa:Process_Task");
            $oTaskModel->insert( array(
                'name'=>$_POST['name'],
                'explain'=>$_POST['explain'],
            ));
            $this->messageQueue ()->create ( Message::success, "保存成功" );
            $this->location('?c=org.opencomb.openoa.process.CreateTask');
	    }
	}
}
