<?php

namespace org\opencomb\openoa\process;

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
	        $oNodeModel = Model::create("openoa:Process_Node");
	        $oNodeModel -> limit(1);
	        $oNodeModel->load( array($_POST['tid']), array("tid"));
	        
            $oRecordModel = Model::create("openoa:Process_Record");
            $oRecordModel->insert( array(
                'uid'=>$uid,
                'tid'=>$_POST['tid'],
                'title'=>$_POST['title'],
                'date1'=>$_POST['date1'],
                'date2'=>$_POST['date2'],
                'explain'=>$_POST['explain'],
                'nowNid'=>$oNodeModel['id'],
            ));
            
            $oRecordDetailsModel = Model::create("openoa:Process_Record_Details");
            $oRecordDetailsModel->insert( array(
                'rid'=>DB::singleton()->lastInsertId(),
                'ids'=>$oNodeModel['id'],
                'type'=>'node',
                'datetime'=>date("Y-m-d H:i:s"),
            ));
            
            $this->messageQueue ()->create ( Message::success, "保存成功" );
            $this->location('?c=org.opencomb.openoa.process.MyRecord');
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
