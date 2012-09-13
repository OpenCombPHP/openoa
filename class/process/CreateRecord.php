<?php

namespace org\opencomb\openoa\process;

use org\opencomb\openoa\process\api\Process;

use org\jecat\framework\db\DB;

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
            $oProcess = new Process();
            if( $oProcess->CreateRecord( $_POST, $this->params()->get('tid')))
            {
                $this->messageQueue ()->create ( Message::success, "保存成功" );
                $this->location('?c=org.opencomb.openoa.process.MyRecord');
            }else{
                $this->messageQueue ()->create ( Message::success, "保存失败" );
                $this->location('?c=org.opencomb.openoa.process.MyRecord');
            }
            
	    }
	    
	    $oModel = Model::create("openoa:Process_Task");
	    $oModel->hasMany("openoa:Process_Node","id","tid","node");
	    $oRow = $oModel->load( array( $this->params()->get('tid')) , array('id'));
	    $this->view()->variables()->set('row', $oRow );
	    
	    $oModel = Model::create("openoa:Process_Node");
	    $oModel->hasOne('coresystem:group',"gid","gid");
	    $oList = $oModel->load( array( $this->params()->get('tid')) , array('tid'));
	    $this->view()->variables()->set('list', $oList );
	}
}
