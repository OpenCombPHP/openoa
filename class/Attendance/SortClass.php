<?php

namespace org\opencomb\openoa\Attendance;

class SortClass
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
    
	static public function get( $id)
	{
	    return self::$aSort[$id];
	}
}
