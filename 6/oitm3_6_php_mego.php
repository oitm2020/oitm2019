<?php
class Summary {
    /**
     * Returns the number that is the sum of excactly 3 numbers from the 
     * supplied $num array and this sum is the closest number to $target
     *
     * @param array $num
     * @param int $target
     * @return int
     */
    public function threeSumClosest($num, $target) : int
    {
        // Írd meg a metódus hiányzó részeit!
        $closest_a = null;
        $closest_b = null;
        $closest_c = null;
        $closest_value = null;
        for($a=0; $a<count($num); $a++){
        	for($b=0; $b<count($num); $b++){
        		for($c=0; $c<count($num); $c++){
        			if($a != $b && $b != $c && $c != $a){
	        			$sum = $num[$a] + $num[$b] + $num[$c];
	        			if( !isset($closest_value) || abs($sum - $target) < $closest_value ){
	        				$closest_value = abs($sum - $target);
	        				$closest_a = $num[$a];
	        				$closest_b = $num[$b];
	        				$closest_c = $num[$c];
	        			}
        			}
        		}
        	}
        }

        /*echo $closest_a;
        echo $closest_b;
        echo $closest_c;*/

        $result = $closest_a + $closest_b + $closest_c;

        return (int) $result;
    }
}

/*
$s = new Summary();
var_dump($s->threeSumClosest([-1, 2, 1, -4], 1));
*/
