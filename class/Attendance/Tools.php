<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\mvc\model\Model;

class Tools
{
    static protected  $aSort = array(
                '1'=>'事假',
                '2'=>'病假',
                '3'=>'婚假',
                '4'=>'产假',
                '5'=>'探亲假',
                '6'=>'丧假',
                '7'=>'年假',
                '8'=>'出差',
                '9'=>'外出',
                '10'=>'调休',
                '11'=>'旷工',
                '12'=>'加班',
    );
    
	static public function getSotrStr( $id)
	{
	    return !empty(self::$aSort[$id])?self::$aSort[$id]:"";
	}
    
	static public function getLateStr( $aData , $type)
	{
	    
	    $aSetting = Extension::flyweight('openoa')->setting();
	    
        $am = $aSetting->item("/",'openoa_am');
        $pm = $aSetting->item("/",'openoa_pm');
	    
	    if( empty( $aData['sort']))
	    {
	        if( $type== "am" && $aData['am'] != "00:00:00" && strtotime( $aData['am']) > strtotime( $am))
	        {
	            return "迟到";
	        }
	        if( $type== "pm" && $aData['pm'] != "00:00:00" && strtotime( $aData['pm']) < strtotime( $pm))
	        {
	            return "早退";
	        }
	    }
	}
}
