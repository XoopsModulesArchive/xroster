<?php

function b_contact_newestmember_show() {
  $block = array();
  $xoopsDB =& Database::getInstance();
  $result = $xoopsDB->query('SELECT id, membername FROM ' . $xoopsDB->prefix('contact') . ' WHERE member=1 ORDER BY since DESC LIMIT 10');
  while($row = $xoopsDB->fetchArray($result))
    $block[] = $row;
  return $block;
}

function b_contact_randommember_show() {
  $block = array();
  $xoopsDB =& Database::getInstance();
  $result = $xoopsDB->query('SELECT id, membername FROM ' . $xoopsDB->prefix('contact') . ' WHERE member=1 ORDER BY RAND() DESC LIMIT 10');
  while($row = $xoopsDB->fetchArray($result))
    $block[] = $row;
  return $block;
} 

?>