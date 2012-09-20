<?php

namespace org\opencomb\openoa\process;

use org\jecat\framework\mvc\view\View;

use org\jecat\framework\util\EventManager;

use org\opencomb\openoa\process\api\Process;

use org\jecat\framework\db\DB;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class CreateRecord extends OpenOaController
{
    const onClickRecord = 'onClickRecord' ;
    const onSaveRecord = 'onSaveRecord' ;
	protected $arrConfig = array
	(
		'title'=>'',
	) ;
	
	public function process()
	{
	    $aEventManager = EventManager::singleton() ;
	    
	    
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($_POST['Submit']))
	    {
	        
            $oProcess = new Process();
            $oProcess->CreateRecord( $_POST, $this->params()->get('tid'));
            
            // 触发事件
            $arrEventArgvs = array($this, DB::singleton()->lastInsertId(), $this->params()->get('type')) ;
            $aEventManager->emitEvent(__CLASS__,self::onSaveRecord,$arrEventArgvs) ;
            
            $this->messageQueue ()->create ( Message::success, "保存成功" );
            $this->location('?c=org.opencomb.openoa.process.MyRecord');
            
	    }
	    
	    // 触发事件
	    $arrEventArgvs = array($this,$this->params()->get('tid')) ;
	    $aEventManager->emitEvent(__CLASS__,self::onClickRecord,$arrEventArgvs) ;
	    
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
