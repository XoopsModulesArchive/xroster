<?php

function b_xroster_newestmember_show() {
  $block = array();
  $xoopsDB =& XoopsDatabaseFactory::getDatabaseConnection();
  $result = $xoopsDB->query('SELECT id, membername FROM ' . $xoopsDB->prefix('xRoster') . ' WHERE member=1 ORDER BY since DESC LIMIT 10');
  while($row = $xoopsDB->fetchArray($result))
    $block[] = $row;
  return $block;
}

?>