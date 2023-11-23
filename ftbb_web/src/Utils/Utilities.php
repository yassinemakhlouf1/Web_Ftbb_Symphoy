<?php

namespace App\Utils;

use \DateTime;

class Utilities {
    /**
     * it reteurns a DateTime object containing the date
     *  passed in argument as string
     */
    public static function getDateTimeObject($date, $format){
        $dateTime = datetime::createfromformat($format,$date);
        $dateTime->format($format);
        return $dateTime;
    }
    public static function generateId($table,$atr, $doctrine){

        $article = NULL;
        $rand = 0;
        do{
        $rand = rand(10000000, 99999999);
        $article = $doctrine->getManager()
             ->getRepository(get_class($table))
             ->findOneBy(array($atr => $rand));
        }while($article != NULL);
        return $rand;
    }
}
?>
