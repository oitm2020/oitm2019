<?php
namespace Math;

include("UtilAbstract.php");

class Number extends UtilAbstract
{
	public static function isPrime($subject){
		if($subject == 1) return false;
		
		$darab = 0;

		for($oszto=1; $oszto<=sqrt($subject); $oszto++){
			if($subject % $oszto == 0){
				$darab++;
			}
		}

		return $darab == 1 ? true : false;
	}
}