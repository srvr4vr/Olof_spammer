<?php
$arComponentParameters = array(
   "GROUPS" => array(
      "SETTINGS" => array(
         "NAME" => "Настройки"
      ),
   ),
   "PARAMETERS" => array(
       "email" => array(
           "PARENT" => "SETTINGS",
           "NAME" => "Email",
           "TYPE" => "STRING",
       ),
       "key" => array(
           "PARENT" => "SETTINGS",
           "NAME" => "Секретный ключ",
           "TYPE" => "STRING",
       ),
   )
);

