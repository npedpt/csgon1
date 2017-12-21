<?php

namespace App\Models;

class LangDetect {
  var $language = null;

  public function __construct() {
    if(($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
      if(preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
        $this->language = array_combine($list[1], $list[2]);
        foreach($this->language as $n => $v) {
          $this->language[$n] = $v ? $v : 1;
        }
        arsort($this->language, SORT_NUMERIC);
      }
    } else $this->language = array();
  }

  public function getBestMatch($default, $langs) {
    $languages = array();
    foreach($langs as $lang => $alias) {
      if(is_array($alias)) {
        foreach($alias as $alias_lang) {
          $languages[strtolower($alias_lang)] = strtolower($lang);
        }
      } else $languages[strtolower($alias)] = strtolower($lang);
    }
    foreach($this->language as $l => $v) {
      $s = strtok($l, '-');
      if(isset($languages[$s])) {
        return $languages[$s];
      }
    }
    return $default;
  }
}
