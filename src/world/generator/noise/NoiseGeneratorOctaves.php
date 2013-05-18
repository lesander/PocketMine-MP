<?php

/*

           -
         /   \
      /         \
   /   PocketMine  \
/          MP         \
|\     @shoghicp     /|
|.   \           /   .|
| ..     \   /     .. |
|    ..    |    ..    |
|       .. | ..       |
\          |          /
   \       |       /
      \    |    /
         \ | /

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.


*/

/***REM_START***/
require_once("NoiseGenerator.php");
/***REM_END***/

class NoiseGeneratorOctaves extends NoiseGenerator{
	public $octaves;
	private $generatorCollection;
	public function __construct(Random $random, $octaves){	
		$this->generatorCollection = array();
		$this->octaves = (int) $octaves;
		for($o = 0; $o < $this->octaves; ++$o){
			$this->generatorCollection[$o] = new NoiseGeneratorPerlin($random);
		}
	}
	
	public function generateNoiseOctaves($floats, $int1, $int2, $int3, $int4, $int5, $int6, $par1 = false, $par2 = false, $par3 = false){
		if($par1 === false or $par2 === false or $par3 === false){
			return $this->generateNoiseOctaves($floats, $int1, 10, $int2, $int3, 1, $int4, $int5, 1, $int6);
		}
		if(!is_array($floats)){
			$floats = array();
		}
		$cnt = $int4 * $int5 * $int6;
		for($i = 0; $i < $cnt; ++$i){
			$floats[$i] = 0;
		}
		
		$d1 = 1;
		
		for($j = 0; $j < $this->octaves; ++$j){
			$d2 = $int1 * $d1 * $par1;
			$d3 = $int2 * $d1 * $par2;
			$d4 = $int3 * $d1 * $par3;
			$l1 = floor($d2);
			$l2 = floor($d4);
			$d2 -= $l1;
			$d4 - $l2;
			$l1 %= 16777216;
			$l2 %= 16777216;
			
			$d2 += $l1;
			$d4 += $l2;
			
			$this->generatorCollection[$j]->populateNouseArray($floats, $d2, $d3, $d4, $int4, $int5, $int6, $par1 * $d1, $par2 * $d1, $par3 * $d1, $d1);
			$d1 /= 2;
		}
		return $floats;
	}
}