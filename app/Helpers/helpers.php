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

  public static function validateTags($tags)
  {
    if (is_array($tags)) {
      return array_filter($tags, function ($tag) {
        return !is_null($tag) && $tag !== false && $tag !== 0 && $tag !== 'undefined';
      });
    }

    return array_values($tags);
  }
}
