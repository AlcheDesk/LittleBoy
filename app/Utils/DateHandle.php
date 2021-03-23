<?php

namespace App\Utils;

use DateTime;



class DateHandle  
{
   // 2018-02-28T12:12:36+08:00
   public function getDateFormat()
   {
    $d = new DateTime();
    return $d->format(DateTime::W3C);
   }
}
