<?php

/************************************************
 * Common stuff for xRoster
 * by Luis Mirabal
 ***********************************************/

/**
 * Options (for drop down lists)
 */

$xRosterList_connspeed = array('56K', 'Cable', 'DSL/ADSL', 'T1', 'T3');
$xRosterList_ahour = array('1 - 2', '2 - 4', '4 - 6', '6 - 8');
$xRosterList_weapon = array('Pistol', 'Shotgun', 'Machine Gun', 'Rifle', 'Sniper Rifle', 'Bazooka');
$xRosterList_imnetworks = array('XFire', 'ICQ', 'Yahoo! Messenger', 'AOL Instant Messenger', 'MSN Messenger');

/**
 * xRoster Functions
 */

function dump($var) {
  echo '<pre>'; print_r($var); die('</pre>');
}

function xRoster_PostVar($k, $defval = null) {
  static $db = false, $myts = false;
  if(!$db) $db =& Database::getInstance();
  if(!$myts) $myts =& MyTextSanitizer::getInstance();
  return isset($_POST[$k]) ? $myts->stripSlashesGPC($_POST[$k]) : $defval;
}

function &xRoster_Query($sql) {
  global $xoopsModule;
  static $db = false;
  if(!$db) $db =& Database::getInstance();
  foreach($xoopsModule->getInfo('tables') as $table)
    if(strpos($sql, '{' . $table . '}'))
      $sql = str_replace('{' . $table . '}', $db->prefix($table), $sql);
  $args = func_get_args();
  array_shift($args);
  if(!empty($args)) {
    foreach($args as $k=>$v)
      if(!is_numeric($v)) $args[$k] = $db->quoteString($v);
    $sql = vsprintf($sql, $args);
  }
  if($result = $db->queryF($sql)) {
    return $result;
  } else {
    if(function_exists('debug_backtrace')) {
      $debug_backtrace = debug_backtrace();
      $debug_backtrace = isset($debug_backtrace[1]) ? $debug_backtrace[1] : $debug_backtrace[0];
      $msg = sprintf('<h1>Error!</h1><p>%s(%s) in %s line %u</p><p>%s</p><p>%s</p><hr />', $debug_backtrace['function'], implode(', ', $debug_backtrace['args']), $debug_backtrace['file'], $debug_backtrace['line'], $sql, $db->error());
      unset($debug_backtrace);
    } else
      $msg = sprintf('<h1>Error!</h1><p>%s</p><p>%s</p><hr />', $sql, $db->error());
    exit($msg);
    return false;
  }
}

function xRoster_LocationDropDown($value = 'US') {
  static $ret = null;
  if($ret === null) {
    require_once XOOPS_ROOT_PATH . '/class/xoopsform/formelement.php';
    require_once XOOPS_ROOT_PATH . '/class/xoopsform/formselectcountry.php';
    $select_location = new XoopsFormSelectCountry('Location', 'location', $value);
    $ret = $select_location->render();
    unset($select_location);
  }
  return $ret;
}

function xRoster_DropDown($name, $options, $value = '', $use_keys = false, $empty_option = _MD_PICKONE) {
  require_once XOOPS_ROOT_PATH . '/class/xoopsform/formelement.php';
  require_once XOOPS_ROOT_PATH . '/class/xoopsform/formselect.php';
  $select = new XoopsFormSelect('', $name, $value);
  if($empty_option !== null && $empty_option !== false)
    $select->addOption('', $empty_option);
  if($use_keys)
    $select->addOptionArray($options);
  else
    foreach($options as $v)
      $select->addOption($v, $v);
  $ret = $select->render();
  unset($select);
  return $ret;
}

function xRoster_YNDropDown($name, $value = 0) {
  return '<select name="' . $name . '">
<option value="0"' . (!$value ? ' selected' : '') . '>' . _NO . '</option>
<option value="1"' . ($value ? ' selected' : '') . '>' . _YES . '</option>
</select>';
}

function xRoster_SQLDropDown($sql, $name, $value = '', $empty_option = null) {
  $db =& Database::getInstance();
  $result = xRoster_Query($sql);
  $option = array();
  while($row = $db->fetchArray($result)) {
    if(!isset($use_keys)) $use_keys = count($row) == 1 ? false : true;
    if(!$use_keys)
      $options[] = array_shift($row);
    else
      $options[array_shift($row)] = array_shift($row);
  }
  return xRoster_DropDown($name, $options, $value, $use_keys, $empty_option);
}

function xRoster_DefaultTitle() {
  static $ret = null;
  if($ret === null) {
    $db =& Database::getInstance();
    $result = $db->query('SELECT id FROM ' . $db->prefix('xRoster_titles') . ' WHERE isdefault = 1');
    if($row = $db->fetchArray($result)) {
      $ret = $row['id'];
    } else {
      $row = $db->fetchArray($db->query('SELECT id FROM ' . $db->prefix('xRoster_titles') . ' ORDER BY weight DESC LIMIT 1'));
      $ret = $row['id'];
    }
  }
  return $ret ? (int)$ret : 0;
}

/**
 * Misc. Functions
 */

function validate_email($str){ 
	return is_string($str) && eregi('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+@(([-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.)([-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$))', $str);
}

?>