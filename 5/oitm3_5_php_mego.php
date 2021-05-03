<?php

namespace Compression;

interface CompressionInterface
{
    public static function encode(string $data);
    public static function decode(string $data);
}

class RLE implements CompressionInterface
{
	public static function encode(string $data)
	{
	if( preg_match( '/[\\x80-\\xff]+/' , $data ) ) return false;
	if(strlen($data) == 0) return "";

	$rle = "";

	$count = 0;
	$prev = $data[0];
	for($i=0; $i<strlen($data); $i++){
		if( $prev != $data[$i] ){
			if($count !=1)
			$rle .= $count;
			$rle .= $prev;

			$prev = $data[$i];
			$count = 0;
		}
		$count++;
	}

	//string végén is
	if($count !=1)
	$rle .= $count;
	$rle .= $prev;

	return $rle;
	}

	public static function decode(string $data)
	{
	if( preg_match('/[^\x20-\x7e]/', $data) ) return false;
	if(strlen($data) == 0) return "";
		$ret = "";

	$szam = "";
	for($i=0; $i<strlen($data); $i++){
		if( is_numeric($data[$i]) ){
			$szam .= $data[$i];
		} else {
			
			$szam = intval($szam);
			if($szam == 0){
				$ret .= $data[$i];
			} else {
				for($j=1; $j<=$szam; $j++){
					$ret .= $data[$i];
				}
			}
			$szam="";
		}
	}

	return $ret;
	}
}

//var_dump(RLE::decode(RLE::encode("A")));