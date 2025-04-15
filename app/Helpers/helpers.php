<?php

namespace App\Helpers;

class Helpers
{
  public static function multiply($a, $b)
  {
    $result = 0;
    for ($i = 0; $i < abs($b); $i++) {
      $result += abs($a);
    }

    if ($b < 0) {
      $result = -$result;
    }

    return $result;
  }
}
