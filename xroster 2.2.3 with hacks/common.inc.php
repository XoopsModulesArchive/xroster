<?php

/************************************************
 * Common stuff for xroster
 * by Luis Mirabal
 ***********************************************/

/**
 * Options (for drop down lists)
 */
global  $xoopsModuleConfig;
$xrosterList_connspeed = array('56K', 'Cable', 'DSL/ADSL', 'T1', 'T3');
$xrosterList_ahour = array('1 - 2', '2 - 4', '4 - 6', '6 - 8');
$xrosterList_weapon = array('Pistol', 'Shotgun', 'Machine Gun', 'Rifle', 'Sniper Rifle', 'Bazooka');
$xrosterList_imnetworks = array('XFire', 'ICQ', 'Yahoo! Messenger', 'AOL Instant Messenger', 'MSN Messenger');
$xrosterList_positions = array('QB', 'RB', 'WR', 'Oline', 'Dline', 'LB', 'K', 'P', 'TE', 'S', 'CB');
$xrosterList_height = array( '<5ft', '5ft1',  '5ft2', '5ft3', '5ft4', '5ft5', '5ft6', '5ft7', '5ft8', '5ft9', '5ft10', '5ft11',
                               '6ft',  '6ft1', '6ft2', '6ft3', '6ft4', '6ft5', '6ft6', '6ft7', '6ft9', '6ft8', '6ft10', '6ft11', '>6ft11');
$xrosterList_weight = array ( '<150lbs', '155lbs', '160lbs', '165lbs', '170lbs', '175lbs', '180lbs', '185lbs', '190lbs', '195lbs',
                              '200lbs', '205lbs', '210lbs', '215lbs', '220lbs', '225lbs', '230lbs', '235lbs', '240lbs', '245lbs',
                               '250lbs', '255lbs', '260lbs', '265lbs', '270lbs', '275lbs', '285lbs', '290lbs', '295lbs', '300lbs',
							   '305lbs', '310lbs', '315lbs', '320lbs', '325lbs', '330lbs', '335lbs', '340lbs', '345lbs', '350lbs', '>350lbs');

@$xrosterlist_ppicpath = (array) scandir(XOOPS_ROOT_PATH . "/" .$xoopsModuleConfig['ppicpath']);
if (count($xrosterlist_ppicpath) > 2) {
   unset($xrosterlist_ppicpath[1]);
   unset($xrosterlist_ppicpath[0]);	
   $xrosterlist_ppicpath= array_values($xrosterlist_ppicpath);	
}   


$xrostermember_handler =& xoops_gethandler('member');
$xrosteruids =& $xrostermember_handler->getUsersByGroup(2);
$criteria = new Criteria('uid', "(".implode(',', $xrosteruids).")", "IN");
$criteria->setSort('uname');
$xrosterList_users=$xrostermember_handler->getUserList($criteria);



/**
 * xroster Functions
 */

function dump($var) {
  echo '<pre>'; print_r($var); die('</pre>');
}

function xroster_PostVar($k, $defval = null) {
  static $db = false, $myts = false;
  if(!$db) $db =& Database::getInstance();
  if(!$myts) $myts =& MyTextSanitizer::getInstance();
  return isset($_POST[$k]) ? $myts->stripSlashesGPC($_POST[$k]) : $defval;
}

function &xroster_Query($sql) {
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

function xroster_LocationDropDown($value = 'US') {
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

function xroster_DropDown($name, $options, $value = '', $use_keys = false, $empty_option = _MD_PICKONE) {
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

function xroster_YNDropDown($name, $value = 0) {
  return '<select name="' . $name . '">
<option value="0"' . (!$value ? ' selected' : '') . '>' . _NO . '</option>
<option value="1"' . ($value ? ' selected' : '') . '>' . _YES . '</option>
</select>';
}

function xroster_SQLDropDown($sql, $name, $value = '', $empty_option = null) {
  $db =& Database::getInstance();
  $result = xroster_Query($sql);
  $option = array();
  while($row = $db->fetchArray($result)) {
    if(!isset($use_keys)) $use_keys = count($row) == 1 ? false : true;
    if(!$use_keys)
      $options[] = array_shift($row);
    else
      $options[array_shift($row)] = array_shift($row);
  }
  return xroster_DropDown($name, $options, $value, $use_keys, $empty_option);
}

function xroster_DefaultTitle() {
  static $ret = null;
  if($ret === null) {
    $db =& Database::getInstance();
    $result = $db->query('SELECT id FROM ' . $db->prefix('xroster_titles') . ' WHERE isdefault = 1');
    if($row = $db->fetchArray($result)) {
      $ret = $row['id'];
    } else {
      $row = $db->fetchArray($db->query('SELECT id FROM ' . $db->prefix('xroster_titles') . ' ORDER BY weight DESC LIMIT 1'));
      $ret = $row['id'];
    }
  }
  return $ret ? (int)$ret : 0;
}

/**
 * Misc. Functions
 */

function validate_email($str){ 
	return is_string($str) && preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $str); 

}

?>