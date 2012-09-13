<?php

namespace org\opencomb\openoa\process;

use org\opencomb\openoa\process\api\Process;

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
	        $oProcess = new Process();
	        if( $oProcess->CreateTask( $_POST))
	        {
	            $this->messageQueue ()->create ( Message::success, "保存成功" );
	            $this->location('?c=org.opencomb.openoa.process.Task');
	        }else{
	            $this->messageQueue ()->create ( Message::success, "保存失败" );
	            $this->location('?c=org.opencomb.openoa.process.CreateTask');
	        }
	    }
	}
}
