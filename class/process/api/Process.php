<?php

namespace org\opencomb\openoa\process\api;

use org\jecat\framework\db\DB;

use org\jecat\framework\mvc\model\Category;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

class Process
{
    /**
     * $aData['name'] = 名称
     * $aData['explain'] = 备注
     * 
     * @param unknown_type $aData
     * @throws \Exception
     */
	public function CreateTask( $aData)
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( !empty($aData['name']) && !empty($aData['explain']))
	    {
            $oTaskModel = Model::create("openoa:Process_Task");
            $bIs = $oTaskModel->insert( array(
                'name'=>$aData['name'],
                'explain'=>$aData['explain'],
            ));
            return $bIs?true:false;
	    }else{
	        throw new \Exception("参数不全");
	    }
	}
	
	public function CreateNode( $aData, $tid)
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( empty($tid))
	    {
	        throw new \Exception("Tid不能为空");
	    }
	    
	    if( !empty($aData['name']))
	    {
	        $oNodeModel = Model::create("openoa:Process_Node");
	        $oNodeModel->insert( array(
	                'tid'=>$tid,
	                'gid'=>$aData['gid'],
	                'name'=>$aData['name'],
	        ));
	        $nid = DB::singleton()->lastInsertId();
	
	        for($i = 1; $i <= 5; $i++)
	        {
    	        if( !empty($aData['status'][$i]))
    	        {
    	            $oStatusModel = Model::create("openoa:Process_Status");
        	        $oStatusModel->insert( array(
        	                'nid'=>$nid,
                	        'name'=>$aData['status'][$i],
                	        'tonid'=>0,
        	        ));
    	        }
	        }
	        return true;
	    }else{
	        throw new \Exception("参数不全");
	    }
	}
	
	public function EditNode( $aData, $nid)
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    if( empty($nid))
	    {
	        throw new \Exception("Tid不能为空");
	    }
	    
	    if( !empty($aData['gid']))
	    {
	        $oNodeModel = Model::create("openoa:Process_Node");
	        $oNodeModel->update( array(
	                'gid'=>$aData['gid'],
	        ),"id = ".$nid);
	
	        for($i = 1; $i <= 4; $i++)
	        {
    	        if( !empty($aData['status'][$i]) )
    	        {
        	        $oStatusModel = Model::create("openoa:Process_Status");
        	        $oStatusModel->update( array(
        	                'name'=>$aData['status'][$i],
        	                'tonid'=>$aData['tonid'][$i],
	                ),"id = ".$aData['sid'][$i]);
    	        }
	        }
	        return true;
	    }else{
	        throw new \Exception("参数不全");
	    }
	
	}
	
	public function CreateRecord( $aData ,$tid)
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( empty($tid))
	    {
	        throw new \Exception("Tid不能为空");
	    }
	    
	    if( !empty($aData['title']))
	    {
	        $oNodeModel = Model::create("openoa:Process_Node");
	        $oNodeModel -> limit(1);
	        $oNodeModel->load( array( $tid), array("tid"));
	
	        $oRecordModel = Model::create("openoa:Process_Record");
	        $oRecordModel->insert( array(
	                'uid'=>$uid,
	                'tid'=>$tid,
	                'title'=>$aData['title'],
	                'date1'=>$aData['date1'],
	                'date2'=>$aData['date2'],
	                'explain'=>$aData['explain'],
	                'nowNid'=>$oNodeModel['id'],
	        ));
	
	        $oRecordDetailsModel = Model::create("openoa:Process_Record_Details");
	        $oRecordDetailsModel->insert( array(
	                'rid'=>DB::singleton()->lastInsertId(),
	                'ids'=>$oNodeModel['id'],
	                'type'=>'node',
	                'datetime'=>date("Y-m-d H:i:s"),
	        ));
	        return true;
	    }else{
	        throw new \Exception("参数不全");
	    }
	}
	
	public function ActionApproval( $rid, $sid)
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    if( empty($sid))
	    {
	        throw new \Exception("Sid不能为空");
	    }
	
	    $oStatusModel = Model::create("openoa:Process_Status");
	    $oStatusRow = $oStatusModel->load( array($sid), array("id"));
	
	    $oRecordModel = Model::create("openoa:Process_Record");
	    $oRecordModel->update(array(
	            'nowNid'=>$oStatusRow['tonid'],
	    ),"id = ".$rid);
	
	
	    $oRecordDetailsModel = Model::create("openoa:Process_Record_Details");
	    $oRecordDetailsModel->insert(array(
	            'rid'=>$rid,
	            'ids'=>$sid,
	            'type'=>'status',
	            'datetime'=>date("Y-m-d H:i:s"),
	    ));
	
	    $oRecordDetailsModel->insert(array(
	            'rid'=>$rid,
	            'ids'=>$oStatusRow['tonid'],
	            'type'=>'node',
	            'datetime'=>date("Y-m-d H:i:s"),
	    ));
	
	    return true;
	
	}
}
