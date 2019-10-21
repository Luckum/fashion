<?php

class SymbolHelper
{
    protected static $replaceCodes = [
        '%uc0' => 'A', '%uc1' => 'A', '%uc2' => 'A', '%uc3' => 'A', '%uc4' => 'A',
        '%uc5' => 'A', '%uc8' => 'E', '%uc9' => 'E', '%uca' => 'E', '%ucb' => 'E',
        '%ucc' => 'I', '%ucd' => 'I', '%uce' => 'I', '%ucf' => 'I', '%ud1' => 'N',
        '%ud2' => 'O', '%ud3' => 'O', '%ud4' => 'O', '%ud5' => 'O', '%ud6' => 'O',
        '%ud9' => 'U', '%uda' => 'U', '%udb' => 'U', '%udc' => 'U', '%udd' => 'Y',
        '%uc7' => 'C', '%ud0' => 'D', 
        '%ue0' => 'a', '%ue1' => 'a', '%ue2' => 'a', '%ue3' => 'a', '%ue4' => 'a',
        '%ue5' => 'a', '%ue7' => 'c', '%ue8' => 'e', '%ue9' => 'e', '%uea' => 'e',
        '%ueb' => 'e', '%uec' => 'i', '%ued' => 'i', '%uee' => 'i', '%uef' => 'i',
        '%uf0' => 'o', '%uf1' => 'n', '%uf2' => 'o', '%uf3' => 'o', '%uf4' => 'o',
        '%uf5' => 'o', '%uf6' => 'o', '%uf8' => 'o', '%uf9' => 'u', '%ufa' => 'u',
        '%ufb' => 'u', '%ufc' => 'u', '%ufd' => 'y', '%uff' => 'y',
        '%20' => ' ', '%2b' => '+', '%26' => '&', '%2d' => '-', '%27' => "'", '%2e' => '.',
        '%2c' => ',', '%2f' => '/', '%uba' => 'o', '%28' => '(', '%29' => ')',
    ];
    
    public static function utf8_to_unicode($str)
    {
        $unicode = [];        
        $values = [];
        $lookingFor = 1;

        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < ord('A')) {
                if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
                    $unicode[] = chr($thisValue);
                } else {
                    $unicode[] = '%' . dechex($thisValue);
                }
            } else {
                if ($thisValue < 128) 
                    $unicode[] = $str[$i];
                else {
                    if (count($values) == 0) $lookingFor = ($thisValue < 224) ? 2 : 3;                
                    $values[] = $thisValue;                
                    if (count($values) == $lookingFor) {
                        $number = ($lookingFor == 3) ?
                            (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64):
                            (($values[0] % 32) * 64) + ($values[1] % 64);
                        $number = dechex($number);
                        $unicode[] = (strlen($number)==3) ? "%u0" . $number : "%u" . $number;
                        $values = [];
                        $lookingFor = 1;
                    }
                }
            }
        }
        
        return implode("", $unicode);
    }
    
    public static function getCorrectName($name)
    {
        $codded = self::utf8_to_unicode($name);
        foreach (self::$replaceCodes as $code => $symbol) {
            $codded = str_replace($code, $symbol, $codded);
        }
        
        return $codded;
    }
}