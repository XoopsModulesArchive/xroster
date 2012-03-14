<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once dirname(__FILE__) . '/common.inc.php';

$op = isset($_GET['op']) ? $_GET['op'] : 'default';
$mid = isset($_GET['mid']) ? intval($_GET['mid']) : null;

if(!ini_get('register_globals')) { // hotfix for register_globals = off
  extract($_GET);
  extract($_POST);
}

$xoopsOption['template_main'] = 'index_template.html';

switch ($op) {
  case 'Apply':
    $xoopsTpl->assign('pop', 'apply');
    $xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
    $xoopsTpl->assign('agreement', _MD_XROSTER_AGREEMENT);
    $xoopsTpl->assign('agreement2', _MD_XROSTER_AGREEMENT2);
    $xoopsTpl->assign('heading', _MI_XROSTER_HEADING);
    $xoopsTpl->assign($lang_array_apply);
    $xoopsTpl->assign('lang_tagerror', _MD_AMSG_TAGERROR);
    // select boxes
    $xoopsTpl->assign('select_impref', xRoster_DropDown('impref', $xRosterList_imnetworks, '', false, ''));
    $xoopsTpl->assign('select_location', xRoster_LocationDropDown());
    $xoopsTpl->assign('select_game', xRoster_SQLDropDown('SELECT id, name FROM {xRoster_categories} WHERE active = 1 ORDER BY weight, name', 'cid'));
    $xoopsTpl->assign('select_speed', xRoster_DropDown('speed', $xRosterList_connspeed + array(_MD_OTHER=>_MD_OTHER)));
    $xoopsTpl->assign('select_ahours', xRoster_DropDown('ahours', $xRosterList_ahour + array(_MD_TOOMANYHOURS=>_MD_TOOMANYHOURS)));
    $xoopsTpl->assign('select_pweapon', xRoster_DropDown('pweapon', $xRosterList_weapon));
    $xoopsTpl->assign('select_sweapon', xRoster_DropDown('sweapon', $xRosterList_weapon));
    $xoopsTpl->assign('select_clanbefore', xRoster_YNDropDown('clan_before'));
    $xoopsTpl->assign('select_tag', xRoster_YNDropDown('tag'));
    break;

  case 'Submit Application':

    function submit_application($realname, $membername, $email, $age, $impref, $imid, $cid, $location, $speed, $ahours, $pweapon, $sweapon, $clan_before, $why_play, $skills_talents, $additional) {
      global $xoopsModuleConfig, $xoopsConfig;
      $db =& XoopsDatabaseFactory::getDatabaseConnection();
      $myts =& MyTextSanitizer::getInstance();
      // quote parameters
      $parameters = array('realname', 'membername', 'email', 'age', 'impref', 'imid', 'cid', 'location', 'speed', 'ahours', 'pweapon', 'sweapon', 'clan_before', 'why_play', 'skills_talents', 'additional');
      foreach($params as $param)
        if(!is_numeric($$param))
          $$param = $db->quoteString($myts->stripSlashesGPC($$param));
    	$sql = 'INSERT INTO ' . $db->prefix('xRoster') . //insert app into db
        " (tid, realname, membername, email, age, impref, imid, cid, location, connection, ahours, pweapon, sweapon, clan_before, why_play, skills_talents, additional_comments, since)
        VALUES (" . xRoster_DefaultTitle() . ", '$realname', '$membername', '$email', '$age', '$impref', '$imid', '$cid', '$location', '$speed', '$ahours', '$pweapon', '$sweapon', '$clan_before', '$why_play', '$skills_talents', '$additional', " . time() . ')';
    	if(!($result = $db->queryF($sql))) {
        exit('SQL Error in ' . __FILE__ . " :: $sql :: " . $db->error());
        return false;
    	}
    	$notify_address = $xoopsModuleConfig['adminmail'];
    	/*
        // Todo: adminemail should be in categories table
      	if($cid && ($result = $db->queryF('SELECT admin_email FROM ' . $db->prefix('xRoster_groups') . " WHERE id = '$cid'"))) {
          if(($row = $result->fetchArray($result)) && $row['admin_email'])
            $notify_address = $row['admin_email'];
        }
      */
    	return mail($notify_address, //email notify
        sprintf(_MD_MAILNEWMEMBERSUBJECT, $xoopsConfig['sitename']),
        _MD_MAILNEWMEMBER,
        "From: $name <$email>\r\nReply-To: $email\r\n");
    }

    if(validate_email($email) && $realname && $membername && $age && $tag) {
      if(submit_application($realname, $membername, $email, $age, $impref, $imid, $cid, $location, $speed, $ahours, $pweapon, $sweapon, $clan_before, $why_play, $skills_talents, $additional)) {
        $xoopsTpl->assign('pop', 'applied');
        $xoopsTpl->assign('lang_applied', _MD_AMSG_APPLIED);
      }
    } else {
      $xoopsTpl->assign('pop', 'apply');
      $xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
      $xoopsTpl->assign('agreement', _MD_XROSTER_AGREEMENT);
      $xoopsTpl->assign('heading', _MI_XROSTER_HEADING);
      $xoopsTpl->assign($lang_array_apply);
      if(!$tag)
        $msg = _MD_AMSG_TAGERROR;
      else {
        $msg = _MD_AMSG_ERROR . '<br>';
        if(!$realname) $msg .= '<b>' . _MD_AMSG_ENAME . '</b><br>';
        if(!$membername) $msg .= '<b>' . _MD_AMSG_ECALLSIGN . '</b><br>';
        if(!validate_email($email))  $msg .= '<b>' . _MD_AMSG_EEMAIL . '</b><br>';
        if(!$age) $msg .= '<b>' . _MD_AMSG_EAGE . '</b><br>';
        $msg .= _MD_AMSG_ERROR_STOVR;
      }
      $xoopsTpl->assign('msg', $msg);
      $xoopsTpl->assign('realname', $realname);
      $xoopsTpl->assign('membername', $membername);
      $xoopsTpl->assign('email', $email);
      $xoopsTpl->assign('age', $age);
      $xoopsTpl->assign('why_play', $why_play);
      $xoopsTpl->assign('skills_talents', $skills_talents);
      $xoopsTpl->assign('additional', $additional);
      $xoopsTpl->assign('lang_tagerror', _MD_AMSG_TAGERROR);
      // select boxes
      $xoopsTpl->assign('select_location', xRoster_LocationDropDown($location));
      $xoopsTpl->assign('select_game', xRoster_SQLDropDown('SELECT id, name FROM {xRoster_categories} WHERE active = 1 ORDER BY weight, name', 'gid', $gid));
      $xoopsTpl->assign('select_speed', xRoster_DropDown('speed', $xRosterList_connspeed + array(_MD_OTHER=>_MD_OTHER), $speed));
      $xoopsTpl->assign('select_ahours', xRoster_DropDown('ahours', $xRosterList_ahour + array(_MD_TOOMANYHOURS=>_MD_TOOMANYHOURS), $ahours));
      $xoopsTpl->assign('select_pweapon', xRoster_DropDown('pweapon', $xRosterList_weapon, $pweapon));
      $xoopsTpl->assign('select_sweapon', xRoster_DropDown('sweapon', $xRosterList_weapon, $sweapon));
      $xoopsTpl->assign('select_clanbefore', xRoster_YNDropDown('clan_before', $clan_before));
      $xoopsTpl->assign('select_tag', xRoster_YNDropDown('tag', $tag));
    }
    break;

  case 'View':

    function getMember($id) {
      $db =& XoopsDatabaseFactory::getDatabaseConnection();
      $rs = xRoster_Query('SELECT m.*, t.name AS title, g.name AS xgroup, c.name AS game FROM {xRoster} m
        INNER JOIN {xRoster_titles} t ON m.tid = t.id
        INNER JOIN {xRoster_groups} g ON m.gid = g.id
        INNER JOIN {xRoster_categories} c ON m.cid = c.id
        WHERE m.member=1 AND m.id = %u', $id);
    	$ret = $db->fetchArray($rs);
      $ret['since'] = formatTimestamp($ret['since'], 's');
    	return $ret;
    }

    $xoopsTpl->assign('pop', 'view_member');
    $xoopsTpl->assign('opt2', $xoopsModuleConfig['hidemail']);
    $xoopsTpl->assign('member', getMember($id));
    $xoopsTpl->assign($lang_array_view);
    break;

  default:

    function getMembers() {
      $db =& XoopsDatabaseFactory::getDatabaseConnection();
      $rs = xRoster_Query('SELECT m.id, m.membername, m.since, t.name AS title, g.name AS xgroup, c.name AS game FROM {xRoster} m
        INNER JOIN {xRoster_titles} t ON m.tid = t.id
        INNER JOIN {xRoster_groups} g ON m.gid = g.id
        INNER JOIN {xRoster_categories} c ON m.cid = c.id
        WHERE m.member = 1 ORDER BY c.weight, g.weight, t.weight, m.membername');
      $members = array();
      while($row = $db->fetchArray($rs)) $members[] = $row;
      return $members;
    }

    $xoopsTpl->assign('pop', 'list_members');
    $xoopsTpl->assign(array('lang_name'=>_MD_NAME, 'lang_title'=>_MD_TITLE, 'lang_since'=>_MD_SINCE, 'lang_nomembers'=>_MD_NOMEMBERS));
    $members = array();
    foreach(getMembers() as $row)
      $members[ $row['game'] ][ $row['xgroup'] ][] = array(
        'id'=>$row['id'],
        'membername'=>$row['membername'],
        'since'=>formatTimestamp($row['since'], 's'),
        'title'=>$row['title']);
    $xoopsTpl->assign('members', $members);
}

$xoopsTpl->assign('xoops_showrblocks', 0);
require_once XOOPS_ROOT_PATH . '/footer.php';

?>