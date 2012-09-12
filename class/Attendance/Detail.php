<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Detail extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Detail.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:attendance_detail"); 
	    $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    
	    $aVal[0] = $uid;
	    $aWhere[0] = "uid";
	    if(!empty($_POST['uid']))
	    {
	        $aVal[0] = $_POST['uid'];
	        $aWhere[0] = "uid";
	    }
	    if(!empty($_POST['eid']))
	    {
	        $aVal[1] = $_POST['eid'];
	        $aWhere[1] = "userinfo.eid";
	    }
	    if(!empty($_POST['y']) && !empty($_POST['m']) && !empty($_POST['d']))
	    {
	        $aVal[2] = $_POST['y'] ."-". $_POST['m'] ."-". $_POST['d'];
	        $aWhere[2] = "date";
	    }
	    if(!empty($_POST['sort']))
	    {
	        $aVal[3] = $_POST['sort'];
	        $aWhere[3] = "sort";
	    }
	    
	    
	    $oData = $oModel->load( $aVal, $aWhere);
	    $this->view()->variables()->set('data', $oData );
	    
	    //统计
	    $aSetting = Extension::flyweight('openoa')->setting();
        $am = $aSetting->item("/",'openoa_am');
        $pm = $aSetting->item("/",'openoa_pm');
        $wxs = $aSetting->item("/",'openoa_wxs');
        $wxt = $aSetting->item("/",'openoa_wxt');
	    $aUserData = array();
	    
	    //'1'=>'事假',
	    //'2'=>'病假',
	    //'3'=>'婚假',
	    //'4'=>'产假',
	    //'5'=>'探亲假',
	    //'6'=>'丧假',
	    //'7'=>'年假',
	    //'8'=>'出差',
	    //'9'=>'外出',
	    //'10'=>'调休',
	    //'11'=>'旷工',
	    //'12'=>'加班',
	    //'13'=>'出勤',
	    //'14'=>'迟到',
	    //'15'=>'早退',
	    
	    foreach ( $oData as $v)
	    {
            $aUserData[$v['uid']]['name'] = $v['userinfo.name'];
            $aUserData[$v['uid']]['eid'] = $v['userinfo.eid'];
	        if(!empty($v['sort']))
	        {
	            @$aUserData[$v['uid']][$v['sort']] += $this->sumDate( $v['am'], $v['pm']);
	        }else{
	            @$aUserData[$v['uid']]['13'] += $this->sumDate( $v['am'], $v['pm']);
	            @$aUserData[$v['uid']]['14'] += $this->sumDate( $am, $v['am']);
	            @$aUserData[$v['uid']]['15'] += $this->sumDate( $v['pm'] ,$pm);
	        }
	    }
	    
	    $this->view()->variables()->set('data2', $aUserData );
	    
	    //姓名
	    $oUserModel = Model::create("openoa:EmployeeManagement" ,"user"); 
	    $oUserData = $oUserModel->load( );
	    $this->view()->variables()->set('users', $oUserData );
	    
	    
	    for($i = 1990; $i <= 2020; $i++){
	        $aDataY[] = $i;
	    }
	    $this->view()->variables()->set('dateY',$aDataY );
	    
	    $aDataM = array('01','02','03','04','05','06','07','08','09','10','11','12');
	    $this->view()->variables()->set('dateM',$aDataM );
	    
	    $aDataD = range(1, 31);
	    $this->view()->variables()->set('dateD',$aDataD );
	    
	}
	
	public function sumDate( $sDate1, $sDate2)
	{
	    $aSetting = Extension::flyweight('openoa')->setting();
        $am = $aSetting->item("/",'openoa_am');
        $pm = $aSetting->item("/",'openoa_pm');
        $wxs = $aSetting->item("/",'openoa_wxs');
        $wxt = $aSetting->item("/",'openoa_wxt');
        
        if(strtotime($sDate1) > strtotime($sDate2))
        {
            return 0;
        }
        
        if(strtotime($sDate1) <= strtotime($wxs) && strtotime($sDate2) >= strtotime($wxt))
        {
            if(strtotime($sDate1) < strtotime($am))
            {
                $sDateT1 = $am;
            }else{
                $sDateT1 = $sDate1;
            }
            if(strtotime($sDate2) > strtotime($pm))
            {
                $sDateT2 = $pm;
            }else{
                $sDateT2 = $sDate2;
            }
            $d1 = $this->getHour($sDateT1, $sDateT2);
            $d2 = $this->getHour($wxs, $wxt);
            return $d1 - $d2;
        }else{
            return $this->getHour($sDate1, $sDate2);
        }
	}
	
	protected function getHour( $sDate1, $sDate2)
	{
        $sDateTime1 = strtotime( $sDate1);
        $sDateTime2 = strtotime( $sDate2);
        
        $sDateTime = $sDateTime2 - $sDateTime1;
        
        return round($sDateTime/3600,1);
	}
}
