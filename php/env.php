<?php 
   function get_env() {
      $env = [];
      $lines = file('../../.env');

      foreach ($lines as $line) {
         if (!empty($line) && strpos(trim($line), '#') !== 0) {
            list($key, $value) = explode('=', trim($line), 2);
            $env[$key] = $value;
         }
      }

      return $env;
   }
?>