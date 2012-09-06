<?php

namespace org\opencomb\openoa\process;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class CreateRecord extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/CreateRecord.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
            $oTaskModel = Model::create("openoa:Process_Record");
            $oTaskModel->insert( array(
                'name'=>$_POST['name'],
                'explain'=>$_POST['explain'],
            ));
            $this->messageQueue ()->create ( Message::success, "保存成功" );
            $this->location('?c=org.opencomb.openoa.process.CreateTask');
	    }
	    
	    $oModel = Model::create("openoa:Process_Task");
	    $oModel->hasMany("openoa:Process_Node","id","tid","node");
	    $oRow = $oModel->load( array( $this->params()->get('tid')) , array('id'));
	    
	    $this->view()->variables()->set('row', $oRow );
	    
	    
	    $oModel = Model::create("openoa:Process_Node");
	    $oList = $oModel->load( array( $this->params()->get('tid')) , array('tid'));
	    $this->view()->variables()->set('list', $oList );
	}
}
