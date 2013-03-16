<?php

$xroster_mydir = dirname(__FILE__);
require_once "$xroster_mydir/../../../include/cp_header.php";
require_once file_exists("$xroster_mydir/../language/" . $xoopsConfig['language'] . '/main.php')
  ? "$xroster_mydir/../language/" . $xoopsConfig['language'] . '/main.php'
  : "$xroster_mydir/../language/english/main.php";
require_once "$xroster_mydir/../common.inc.php";

function xroster_AdminHeader(){
  global $xoopsModule;
  xoops_cp_header();
  printf(_MD_ADMINWELCOME, $xoopsModule->getVar('name'));
  echo '<p align="center"><b><a href="', XOOPS_URL, '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=', $xoopsModule->getVar('mid'), '">', _MD_PREFERENCES, '</a></b>
    | <a href="index.php?op=members_add">', _MD_ADDMEMBER, '</a>
    | <a href="index.php?op=members_approve">', _MD_NEWMEMBERS, '</a>
    | <a href="index.php?op=members_list">', _MD_MEMBERS, '</a></p>';
/*    <a href="index.php?op=Title_Editor">', _MD_TITLEEDITOR, '</a>
    | <a href="index.php?op=Title_Editor&t_action=add">', _MD_ADDTITLE, '</a>
    | <a href="index.php?op=Group_Editor">', _MD_GROUPEDITOR, '</a>
    | <a href="index.php?op=Group_Editor&g_action=add">', _MD_ADDGROUP, '</a>
    | <a href="index.php?op=Category_Editor">', _MD_CATEGORYEDITOR, '</a>
    | <a href="index.php?op=Category_Editor&c_action=add">', _MD_ADDCATEGORY, '</a></p>'; */
}

function Members_Edit($id = 0) {
  global $xoopsDB, $xrosterList_users, $xoopsModuleConfig, $xrosterlist_ppicpath, $xrosterList_connspeed, $xrosterList_ahour, $xrosterList_weapon, $xrosterList_imnetworks, $xrosterList_positions, $xrosterList_height, $xrosterList_weight;
	if($id) {
    $result = xroster_Query("SELECT * FROM {xroster} WHERE id = $id");
  	if(!($member = $xoopsDB->fetchArray($result))) return false;
    $member['since'] = formatTimestamp($member['since'], 's');
	} else
    $member = array('member' => 1, 'since' => formatTimestamp(time(), 's'));
  $result = xroster_Query('SELECT id, name FROM {xroster_titles} ORDER BY  name');
  while($row = $xoopsDB->fetchArray($result))
    $titles[$row['id']] = $row['name'];
  // Here comes the form
  echo '<form method="post">
    <input type="hidden" name="id" value="' . $id . '">
    <input type="hidden" name="op" value="members_update">
    <table cellspacing="8" cellpadding="8" class="outer">';
  echo '<tr><td>', _MD_REALNAME, '</td><td><input type="text" name="realname" value="', $member['realname'], '"></td></tr>';
  echo '<tr><td>', _MD_NAME, '</td><td>', xroster_DropDown('membername', $xrosterList_users, $member['membername']), '</td></tr>';
  echo '<tr><td>', _MD_BDATE, '</td><td><input type="text" name="bdate" value="', $member['bdate'], '"></td></tr>';
  echo '<tr><td>', _MD_POSITIONS, '</td><td>', xroster_DropDown('spositions', $xrosterList_positions, $member['spositions']), '</td></tr>';
  echo '<tr><td>', _MD_WEIGHT, '</td><td>', xroster_DropDown('sweight', $xrosterList_weight, $member['sweight']), '</td></tr>';
  echo '<tr><td>', _MD_HEIGHT, '</td><td>', xroster_DropDown('sheight', $xrosterList_height, $member['sheight']), '</td></tr>';  
  echo '<tr><td>', _MD_EXPER, '</td><td><input type="text" name="exper" value="', $member['exper'], '"></td></tr>';   
  echo '<tr><td>', _MD_SCHOOL, '</td><td><input type="text" name="school" value="', $member['school'], '"></td></tr>';
  echo '<tr><td>', _MD_JNUMBER, '</td><td><input type="text" name="jnumber" value="', $member['jnumber'], '"></td></tr>';
  echo '<tr><td>', _MD_PHONE, '</td><td><input type="text" name="phone" value="', $member['phone'], '"></td></tr>';
  echo '<tr><td>', _MD_EMAIL, '</td><td><input type="text" name="email" value="', $member['email'], '"></td></tr>';
  echo '<tr><td>', _MD_ADDRESS, '</td><td><input type="text" name="address" value="', $member['address'], '"></td></tr>';
  echo '<tr><td>', _MD_CITY, '</td><td><input type="text" name="city" value="', $member['city'], '"></td></tr>';
  echo '<tr><td>', _MD_STATE, '</td><td><input type="text" name="pstate" value="', $member['pstate'], '"></td></tr>'; 
  echo '<tr><td>', _MD_ZIPCODE, '</td><td><input type="text" name="zipcode" value="', $member['zipcode'], '"></td></tr>'; 
  echo '<tr><td>', _MD_IMAGEPATH, '</td><td>', xroster_DropDown('picture', $xrosterlist_ppicpath, $member['picture']), '</td></tr>'; 
// echo '<tr><td>', _MD_AGE, '</td><td><input type="text" name="age" value="', $member['age'], '"></td></tr>';
//  echo '<tr><td>', _MD_GROUP, '</td><td>', xroster_SQLDropDown('SELECT id, name FROM {xroster_groups} ORDER BY weight, name', 'gid', $member['gid']), '</td></tr>';
//  echo '<tr><td>', _MD_CONNECTION, '</td><td>', xroster_DropDown('connection', $xrosterList_connspeed + array(_MD_OTHER=>_MD_OTHER), $member['connection']), '</td></tr>';
//  echo '<tr><td>', _MD_AVAILABLEHOURS, '</td><td>', xroster_DropDown('ahours', $xrosterList_ahour + array(_MD_TOOMANYHOURS=>_MD_TOOMANYHOURS), $member['ahours']), '</td></tr>';
//  echo '<tr><td>', _MD_SECONDARYWEAPON, '</td><td>', xroster_DropDown('sweapon', $xrosterList_weapon, $member['sweapon']), '</td></tr>';
//  echo '<tr><td colspan="2">', _MD_NOTE3, '<br><textarea rows="3" name="why_play">', $member['why_play'], '</textarea></td></tr>';
//  echo '<tr><td colspan="2">', _MD_NOTE1, '<br><textarea rows="3" name="additional_comments">', $member['additional_comments'], '</textarea></td></tr>';
 // echo '<tr><td>', _MD_IMAGEPATH, '</td><td><input type="text" name="picture" value="', $member['picture'], '"></td></tr>';
//  echo '<tr><td>', _MD_WEBSITEURL, '</td><td><input type="text" name="siteurl" value="', $member['siteurl'], '"></td></tr>';
//  echo '<tr><td>', _MD_IMNETWORK, '</td><td>', xroster_DropDown('impref', $xrosterList_imnetworks, $member['impref']), '</td></tr>';
//  echo '<tr><td colspan="2">', _MD_NOTE5, '<br><textarea rows="3" name="additional_info">', $member['additional_info'], '</textarea></td></tr>';
  echo '<tr><td colspan="2">', _MD_APPROVED, '  (This will also add or subtract user from player group when program is done)   ', xroster_YNDropDown('member', $member['member']), '</td></tr>';
  echo '<tr><td align="center" colspan="2"><input type="submit" value="', _MD_UPDATE, '"></td></tr>
  </table><form>';
}

function Members_List($op = 1) {
  $db =& Database::getInstance();
  $result = xroster_Query("SELECT m.id, m.membername, m.member,  m.realname, m.bdate, m.spositions,
                           m.sweight, m.sheight, m.exper, m.school, m.jnumber, m.phone, m.email, m.address, m.city, m.pstate, m.zipcode,
                           t.name AS title, g.name AS xgroup, c.name AS game
    FROM {xroster} m
    LEFT JOIN {xroster_titles} t ON m.tid = t.id
    LEFT JOIN {xroster_groups} g ON m.gid = g.id
    LEFT JOIN {xroster_categories} c ON m.cid = c.id
    WHERE m.member = $op ORDER BY  m.jnumber");
  if($db->getRowsNum($result)) {
    echo '<table cellspacing="0" cellpadding="8" class="outer">';
    $last_game = '';
    $last_group = '';
    while($member = $db->fetchArray($result)) {
      if($last_game != $member['game']) {
        echo '<tr><td colspan="4"><h3>', $member['game'], '</h3></td></tr>';
        $last_game = $member['game'];
      }
      if($last_group != $member['xgroup'] || $last_game != $member['game']) {
        echo '<tr><td colspan="4"><h4>', $member['xgroup'], '</h4></td></tr>';
        echo '<tr bgcolor="#cccccc"><td>&nbsp;</td><td><strong>', _MD_MEMBERNAME, '</strong></td><td><strong>', _MD_MEMBERTITLE, '</strong></td><td>&nbsp;</td></tr>';
        $last_group = $member['xgroup'];
      }
      echo '<tr bgcolor="#eeeeee"><td><a href="?op=members_edit&action=edit&id=', $member['id'], '">', _MD_EDIT, '</a></td>
        <td>', $member['realname'], '</td>
		<td>', $member['membername'], '</td>
		<td>', $member['spositions'], '</td>
		<td>', $member['phone'], '</td>
		<td>', $member['email'], '</td>
		<td>', $member['city'], '</td>
        <td><a href="?op=members_delete&action=confirm&id=', $member['id'], '">', _MD_DELETE, '</a>
        | <a href="?op=members_approve&action=approve&id=', $member['id'], '&subaction=', $member['member'] ? '0' : '1', '">', !$member['member'] ? _MD_APPROVE : _MD_DISAPPROVE, '</a>',
        '</td></tr>';
    }
    echo '</table>';
  } else
    echo '<p align="center">', $op == 0 ? _MD_NOAPPLICANTS : _MD_NOMEMBERS, '</p>';
}

function getMember($id, $getAll = 0) {
   $getAll = (int)$getAll ? 1 : 0;
   $db =& Database::getInstance();
   if ($getAll)  $rs = xroster_Query('SELECT m.* FROM {xroster} m WHERE m.id = %u', $id);
      else $rs = xroster_Query('SELECT m.* FROM {xroster} m WHERE m.member=1 AND m.id = %u', $id);
   $ret = $db->fetchArray($rs);
   $ret['since'] = formatTimestamp($ret['since'], 's');
   return $ret;
}

/** $id is the $id of the user from the roster database
*   $action true = add user to group  false = remove user from group
*   $xrosterList_users is list of registered users with the key being the UID and value being the UNAME
*   $key = contains the UID of the user obtained from the list of registered users
*   $xoopsModuleConfig['ugroup'] is the groupid of the group I am trying to add/remove user from
*   $result should equal true if it worked
*/

function Groups_Add_n_Remove($id, $action = 0) {
  $action = (int)$action ? 1 : 0; // making sure it is an int.  1 = add user   0 = remove user
  global $xrosterList_users, $xoopsModuleConfig, $xrosterhMember;
  $groupid=$xoopsModuleConfig['ugroup'];
  $member=getMember($id, 1); // added the 1 to have getMember get a member no matter if activated or not and modified getMember accordingly
  $key = array_search($member['membername'], $xrosterList_users);  // gets UID of user if user is a registered user on the site
  if ($key) {
    $db =& Database::getInstance();
    $result = $db->query('SELECT linkid, groupid, uid FROM ' . $db->prefix('groups_users_link') . ' WHERE uid=' . $key . ' AND groupid=' . $groupid);
    $row = $db->fetchArray($result);
	$linkid=$row['linkid'];
    if (!(isset($linkid)) && $action) {
		  $result = $db->queryF('INSERT INTO ' . $db->prefix('groups_users_link') . ' (groupid, uid)  VALUES (' . $groupid . ', ' . $key .')');
	}
    if (isset($linkid) && !($action)) { 
		  $result = $db->queryF('DELETE FROM ' . $db->prefix('groups_users_link') . ' WHERE linkid='. $linkid);  
	}		
  }
} 
   




function Members_Delete($id){
  global $xoopsModuleConfig;
  if ($xoopsModuleConfig['groupadd']) Groups_Add_n_Remove($id);
	$result = xroster_Query('DELETE FROM {xroster} WHERE id=%u', $id);
	redirect_header('index.php?op=members_list', 1, _MD_MEMBERDELETED);
}

function Members_Approve($id, $action = 1){
  $action = (int)$action ? 1 : 0;
  global $xoopsModuleConfig;
  if ($xoopsModuleConfig['groupadd']) Groups_Add_n_Remove($id, $action);
  $result = xroster_Query('UPDATE {xroster} SET member=%u, since=%u WHERE id=%u', $action, time(), $id);
  redirect_header('index.php?op=members_list', 1, _MD_MEMBERUPDATED);
}

function Group_Editor($g_action = '', $id = 0) {
  $db =& Database::getInstance();
  switch($g_action) {
    case 'delete':
      $result = xroster_Query('SELECT count(*) AS c FROM {xroster} WHERE gid=%u', $id);
      $row = $db->fetchArray($result);
      if($row['c'] == 0)
        $result = xroster_Query('DELETE FROM {xroster_groups} WHERE id=%u', $id);
      else
        printf('<br><br>' . _MD_CANTDELETEGROUP, $row['c']);
      redirect_header('index.php?op=Group_Editor', 1, _MD_GROUPDELETED);
      break;
    case 'insert':
      $sql = 'INSERT INTO {xroster_groups} (name, weight)  VALUES (%s, %u)';
    case 'update':
      $name = xroster_PostVar('name');
      $weight = xroster_PostVar('weight');
      if(!isset($sql))
        $result = xroster_Query('UPDATE {xroster_groups} SET name=%s, weight=%u WHERE ID=%u', $name, $weight, $id);
      else
        $result = xroster_Query($sql, $name, $weight);
      redirect_header('index.php?op=Group_Editor', 1, _MD_GROUPUPDATED);
      break;
    case 'edit':
      $form_params = array('id'=>$id, 'g_action'=>'update', 'btn_label'=>_MD_UPDATE);
      $result = xroster_Query('SELECT * FROM {xroster_groups} WHERE id=%u', $id);
      if($row = $db->fetchArray($result)) {
        $name = $row['name'];
        $weight = $row['weight'];
      }
    case 'add':
      if(!isset($form_params))
        $form_params = array('id'=>0, 'g_action'=>'insert', 'btn_label'=>_MD_INSERT);
      echo '<form method="post">';
      if($form_params['id'])
        echo '<input type="hidden" name="id" value="', $form_params['id'], '">';
      echo '<input type="hidden" name="g_action" value="', $form_params['g_action'], '">
        <table cellspacing="0" cellpadding="8" class="outer">
        <tr><td>', _MD_GROUPNAME, '</td><td><input type="text" name="name" value="', $name, '"></td></tr>
        <tr><td>', _MD_WEIGHT, '</td><td><input type="text" name="weight" value="', $weight, '" size="4" maxlength="3"></td></tr>
        <tr><td>&nbsp;</td><td><input type="submit" value="', $form_params['btn_label'], '"></td></tr>
        </table><form>';
      break;
    default:
      $result = xroster_Query('SELECT * FROM {xroster_groups} ORDER BY weight, name');
      if($db->getRowsNum($result)) {
        echo '<table cellspacing="0" cellpadding="8" class="outer" bgcolor="#eeeeee">';
        while($row = $db->fetchArray($result)) {
          echo '<tr><td><a href="?op=Group_Editor&g_action=edit&id=', $row['id'], '">', _MD_EDIT, '</a></td>
            <td>', $row['name'], '</td><td>', $row['weight'], '</td>
            <td><a href="?op=Group_Editor&g_action=delete&id=', $row['id'], '">', _MD_DELETE, '</a></td></tr>';
        }
        echo '</table>';
      } else
        echo '<p align="center">', _MD_NOGROUPS, '</p>';
      break;
	}
}

function Category_Editor($c_action, $id, $name, $weight, $active = 1){
  $db =& Database::getInstance();
  switch($c_action) {
  case 'delete':
    $result = xroster_Query('SELECT count(*) as count FROM {xroster} WHERE cid=%u', $id);
    $row = $db->fetchArray($result);
    if($row['count'] == 0) {
      xroster_Query('DELETE FROM {xroster_categories} WHERE ID=%u', $id);
      redirect_header('index.php?op=Category_Editor', 1, _MD_CATEGORYDELETED);
    } else
      printf('<br><br>' . _MD_CANTDELECATEGORY, $row['count']);
    break;
  case 'update':
    $result = xroster_Query("UPDATE {xroster_categories} SET name=%s, weight=%u, active=%u WHERE ID=%u", $name, $weight, $active, $id);
    redirect_header("index.php?op=Category_Editor", 1, _MD_CATEGORYUPDATED);
    break;
  case 'insert':
    $result = xroster_Query("INSERT INTO {xroster_categories} (name, weight, active) VALUES (%s, %u, %u)", $name, $weight, $active);
    redirect_header('index.php?op=Category_Editor', 1, _MD_CATEGORYINSERTED);
    break;
  case 'add': case 'edit':
    echo '<p>
      <form method="post">
      <input type="hidden" name="c_action" value="', $c_action == 'edit' ? 'update' : 'insert', '">',
      $c_action == 'edit' ? '<input type="hidden" name="id" value="' . $id . '">' : '',
      '<table cellspacing=0 cellpadding=8 class="outer">
      <tr><td>', _MD_CATEGORYNAME, '</td><td><input type="text" name="name" value="', $name, '"></td></tr>
      <tr><td>', _MD_WEIGHT, '</td><td><input type="text" name="weight" value="', $weight, '"></td></tr>
      <tr><td>', _MD_ACTIVE, '</td><td>', xroster_YNDropDown('active', $active), '</td></tr>
      <tr><td>&nbsp;</td><td><input type="submit" value="', $c_action == 'edit' ? _MD_UPDATE : _MD_INSERT, '">
      </td></tr>
      </table>
      <form>';
  break;
  default:
    $result = xroster_Query('SELECT id, name, weight, active FROM {xroster_categories} ORDER BY weight');
    if($db->getRowsNum($result) > 0) {
      echo '<p><table cellspacing="0" cellpadding="8" class="outer">
        <tr bgcolor="#cccccc"><td>&nbsp;</td><td>', _MD_CATEGORYNAME, '</td><td>', _MD_WEIGHT, '</td><td>', _MD_ACTIVE, '</td><td>&nbsp;</td></tr>';
      while($row = $db->fetchArray($result)) {
        echo '<tr bgcolor="#eeeeee">
          <td><a href="?op=Category_Editor&c_action=edit&id=', $row['id'], '&name=', $row['name'], '&weight=', $row['weight'], '&active=', $row['active'], '">', _MD_EDIT, '</a></td>
          <td>', $row['name'], '</td><td>', $row['weight'], '</td>
          <td>', $row['active'] ? _YES : _NO, '</td>
          <td><a href="?op=Category_Editor&c_action=delete&id=', $row['id'], '">', _MD_DELETE, '</a></td></tr>';
      }
      echo '</table>';
    } else
      echo '<p align="center">', _MD_NOCATEGORIES, '</p>';
  break;
  }
}

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

function Title_Editor($t_action, $id, $name, $weight){
  $db =& Database::getInstance();
	switch($t_action){
		case "delete":
			$result = xroster_Query('SELECT count(*) as count FROM {xroster} WHERE tid=%u', $id);
			$row = $db->fetchArray($result);
			if($row['count'] == 0)
				xroster_Query('DELETE FROM {xroster_titles} WHERE ID=%u', $id);
			else
			  printf('<br><br>' . _MD_CANTDELETETITLE, $row['count']);
			redirect_header('index.php?op=Title_Editor', 1, _MD_TITLEDELETED);
		  break;
		case "update":
			$sql = "UPDATE " . $db->prefix("xroster_titles") . " SET name='$name',weight=$weight WHERE ID=$id";
			if ( !$result = $db->query($sql) ) {
				exit("Error in admin/index.php :: Title_Editor($t_action,$id,$name,$weight)");
			}
			redirect_header("index.php?op=Title_Editor", 1, _MD_TITLEUPDATED);
		break;
		case "insert":
			$sql = "INSERT INTO " . $db->prefix("xroster_titles") . " (name,weight) VALUES ('$name',$weight)";
			if ( !$result = $db->query($sql) ) {
				exit("Error in admin/index.php :: Title_Editor($t_action,$id,$name,$weight)");
			}
			redirect_header("index.php?op=Title_Editor", 1, _MD_TITLEINSERTED);
		break;
		case "add":
			echo("<p>");
			echo("<form method=post>");
			echo("<input type=\"hidden\" name=\"t_action\" value=\"insert\">");
			echo("<table cellspacing=0 cellpadding=8 class=\"outer\">");
			echo("<tr><td>"._MD_TITLENAME."</td><td><input type=\"text\" name=\"name\" value=\"".$name."\"></td></tr>");
			echo("<tr><td>"._MD_WEIGHT."</td><td><input type=\"text\" name=\"weight\" value=\"".$weight."\"></td></tr>");
			echo("<tr><td>&nbsp;</td><td><input type=\"submit\" value=\""._MD_INSERT."\"></td></tr>");
			echo("</table>");
			echo("<form>");				
		break;
		case "edit":
			echo("<p>");
			echo("<form method=post>");
			echo("<input type=\"hidden\" name=\"id\" value=\"$id\">");
			echo("<input type=\"hidden\" name=\"t_action\" value=\"update\">");
			echo("<table cellspacing=0 cellpadding=8 class=\"outer\">");
			echo("<tr><td>"._MD_TITLENAME."</td><td><input type=\"text\" name=\"name\" value=\"".$name."\"></td></tr>");
			echo("<tr><td>"._MD_WEIGHT."</td><td><input type=\"text\" name=\"weight\" value=\"".$weight."\"></td></tr>");
			echo("<tr><td>&nbsp;</td><td><input type=\"submit\" value=\""._MD_UPDATE."\"></td></tr>");
			echo("</table>");
			echo("<form>");
		break;
		case 'default':
      xroster_Query('UPDATE {xroster_titles} SET isdefault=0 WHERE ID<>%u', $id);
      xroster_Query('UPDATE {xroster_titles} SET isdefault=1 WHERE ID=%u', $id);
      redirect_header('index.php?op=Title_Editor', 1, _MD_TITLEUPDATED);
      break;
		default:
			$result = xroster_Query('SELECT id, name, weight FROM {xroster_titles} ORDER BY weight');
			$titles = $titles_assoc = array();
			while($row = $db->fetchArray($result)) {
        $titles[] = $row;
        $titles_assoc[$row['id']] = $row['name'];
      }
			if(count($titles) > 0){
				echo("<p><table cellspacing=0 cellpadding=8 class=\"outer\">");
				echo("<tr bgcolor=\"#cccccc\"><td>&nbsp;</td><td>"._MD_TITLENAME."</td><td>"._MD_WEIGHT."</td><td>&nbsp;</td></tr>");
					for($j=0;$j<count($titles);$j++){
						echo("<tr bgcolor=\"#eeeeee\">");
						echo("<td><a href=\"?op=Title_Editor&t_action=edit&id=".$titles[$j]['id']."&name=".$titles[$j]['name']."&weight=".$titles[$j]['weight']."\">"._MD_EDIT."</a></td>");			
						echo("<td>".$titles[$j]['name']."</td>");
						echo("<td>".$titles[$j]['weight']."</td>");
						echo("<td><a href=\"?op=Title_Editor&t_action=delete&id=".$titles[$j]['id']."\">"._MD_DELETE."</a></td>");
						echo("</tr>");
					}
				echo("</table>");
        // Default title
        echo '<form method="post"><input type="hidden" name="t_action" value="default">',
          _MD_DEFAULTTITLE, ':', xroster_DropDown('id', $titles_assoc, xroster_DefaultTitle(), true, null),
          ' <input type="submit" value="&gt;&gt;"></form>';
			} else {
					echo("<p align=\"center\">"._MD_NOTITLES."</p>");
			}
		break;
	}
}

/**************************************
 * Main - Admin SwitchBox
 *************************************/

if(!ini_get('register_globals')) { // hotfix for register_globals=off
  extract($_GET);
  extract($_POST);
}

xroster_AdminHeader();

$op = isset($_POST['op']) ? $_POST['op'] : (isset($_GET['op']) ? $_GET['op'] : 'xrosterConfig');
switch($op) {
  case 'Title_Editor': Title_Editor($t_action, $id, $name, $weight); break;
  case 'Category_Editor':
  	Category_Editor($c_action, $id, $name, $weight, !isset($_REQUEST['active']) || (bool)$_REQUEST['active'] ? 1 : 0);
  	break;
  case 'Group_Editor':
    $g_action = isset($_REQUEST['g_action']) ? $_REQUEST['g_action'] : '';
    $id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
    Group_Editor($g_action, $id);
    break;
  case 'members_approve':
    if(@$_GET['action']=='approve' && (int)@$_GET['id'])
      Members_Approve($_GET['id'], isset($_GET['subaction']) ? (int)$_GET['subaction'] : 1);
    else
      Members_List(0);
    break;
  case 'members_list': Members_List(1); break;
  case 'members_add': $id = 0;
  case 'members_edit': Members_Edit($id); break;
  case 'members_update':
    $realname = xroster_PostVar('realname');
    $membername = xroster_PostVar('membername');
    $email = xroster_PostVar('email');
        $position = xroster_PostVar('position');
	$phone = xroster_PostVar('phone');
    $age = (int)xroster_PostVar('age');
    $gid = (int)xroster_PostVar('gid');
    $cid = (int)xroster_PostVar('cid');
    $location = xroster_PostVar('location');
    $connection = xroster_PostVar('connection');
    $ahours = xroster_PostVar('ahours');
    $pweapon = xroster_PostVar('pweapon');
    $sweapon = xroster_PostVar('sweapon');
    $clan_before = (int)xroster_PostVar('clan_before');
    $why_play = xroster_PostVar('why_play');
    $skills_talents = xroster_PostVar('skills_talents');
    $additional_comments = xroster_PostVar('additional_comments');
    $tid = (int)xroster_PostVar('tid');
    $picture = xroster_PostVar('picture');
    $sitename = xroster_PostVar('sitename');
    $siteurl = xroster_PostVar('siteurl');
    $impref = xroster_PostVar('impref');
    $imid = xroster_PostVar('imid');
    $additional_info = xroster_PostVar('additional_info');
    $member = (int)xroster_PostVar('member', 0);
    $id = (int)xroster_PostVar('id', 0);
	$jnumber = (int)xroster_PostVar('jnumber');
    $exper = (int)xroster_PostVar('exper');
	$spositions = xroster_PostVar('spositions');
	$sheight = xroster_PostVar('sheight');
	$sweight = xroster_PostVar('sweight');
	$bdate = xroster_PostVar('bdate');
	$school = xroster_PostVar('school');
	$address = xroster_PostVar('address');
	$city = xroster_PostVar('city');
	$pstate = xroster_PostVar('pstate');
	$zipcode = xroster_PostVar('zipcode');
			
    if($id) {
      //Todo: when I update, if the user was member=0, and it's approved (member=1), I should update the "since" field to time()
      $result = xroster_Query('UPDATE {xroster} SET realname=%s, membername=%s, phone=%s,  email=%s,  gid=%d, cid=%d, tid=%d, picture=%s, member=%d, 
		bdate=%s, spositions=%s, sheight=%s, sweight=%s, jnumber=%d, school=%s, address=%s, city=%s, pstate=%s, zipcode=%s, exper=%d WHERE id = %d',
        $realname, $membername, $phone,  $email, $gid, $cid, $tid, $picture, $member,
		$bdate, $spositions, $sheight, $sweight,  $jnumber, $school, $address, $city, $pstate, $zipcode, $exper, $id);
      redirect_header($member ? 'index.php?op=members_list' : 'index.php?op=members_approve', 1, _MD_MEMBERUPDATED);
    } else {
      $result = xroster_Query('INSERT INTO {xroster}
        (realname, membername, phone,  email, gid, cid, tid, picture, member, since,
		   bdate, spositions, sheight, sweight, jnumber, school, address, city, pstate, zipcode, exper)
        VALUES (%s, %s, %s,  %s, %d, %d, %d, %s,  %d, %d,
		   %s, %s, %s, %s, %d, %s, %s, %s, %s, %s, %d )',
        $realname, $membername, $phone,  $email, $gid, $cid, $tid, $picture, $member, time(),
		 $bdate, $spositions, $sheight, $sweight, $jnumber, $school, $address, $city, $pstate, $zipcode, $exper);
      redirect_header('index.php?op=members_list', 1, _MD_MEMBERADDED);
    }
    break;
  case 'members_delete': 
    Members_Delete($id);
	break;
  case 'ConfigUpdate': ConfigUpdate(); break;
}

xoops_cp_footer();

?>
<!-- if (isset($_POST['add_x'])){
$hMember =& xoops_gethandler('member');
$membership =& $hMember->addUserToGroup($_POST['groupid'],$_POST['all']);
}

if (isset($_POST['del_x'])){
$hMember =& xoops_gethandler('member');
$membership =& $hMember->removeUsersFromGroup($_POST['groupid'],array($_POST['curr'])); -->