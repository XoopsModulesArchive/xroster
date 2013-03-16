<?php



$xRoster_mydir = dirname(__FILE__);
require_once "$xRoster_mydir/../../../include/cp_header.php";
require_once file_exists("$xRoster_mydir/../language/" . $xoopsConfig['language'] . '/main.php') ?
    "$xRoster_mydir/../language/" . $xoopsConfig['language']
        . '/main.php' : "$xRoster_mydir/../language/english/main.php";
require_once "$xRoster_mydir/../common.inc.php";
include_once 'admin_header.php';
$indexAdmin = new ModuleAdmin();

function Members_Edit($id = 0)
{
    global $xoopsDB, $xRosterList_connspeed, $xRosterList_ahour, $xRosterList_weapon, $xRosterList_imnetworks, $indexAdmin;
    if ($id) {

        $result = xRoster_Query("SELECT * FROM {xRoster} WHERE id = $id");
        if (!($member = $xoopsDB->fetchArray($result))) {
            return false;
        }
        $member['since'] = formatTimestamp($member['since'], 's');
    } else {
        $member = array(
            'member' => 1,
            'since'  => formatTimestamp(time(), 's')
        );
        echo $indexAdmin->addNavigation('main.php?op=members_add');
    }
    $result = xRoster_Query('SELECT id, name FROM {xRoster_titles} ORDER BY weight, name');
    while ($row = $xoopsDB->fetchArray($result)) {
        $titles[$row['id']] = $row['name'];
    }
    // Here comes the form
    echo '<form method="post">
    <input type="hidden" name="id" value="' . $id . '">
    <input type="hidden" name="op" value="members_update">
    <table cellspacing="8" cellpadding="8" class="outer">';
    echo '<tr><td>', _MD_REALNAME, '</td><td><input type="text" name="realname" value="', $member['realname'], '"></td></tr>';
    echo '<tr><td>', _MD_NAME, '</td><td><input type="text" name="membername" value="', $member['membername'], '"></td></tr>';
    echo '<tr><td>', _MD_EMAIL, '</td><td><input type="text" name="email" value="', $member['email'], '"></td></tr>';
    echo '<tr><td>', _MD_AGE, '</td><td><input type="text" name="age" value="', $member['age'], '"></td></tr>';
    echo '<tr><td>', _MD_CATEGORY, '</td><td>', xRoster_SQLDropDown('SELECT id, name FROM {xRoster_categories} ORDER BY weight, name', 'cid', $member['cid']), '</td></tr>';
    echo '<tr><td>', _MD_GROUP, '</td><td>', xRoster_SQLDropDown('SELECT id, name FROM {xRoster_groups} ORDER BY weight, name', 'gid', $member['gid']), '</td></tr>';
    echo '<tr><td>', _MD_LOCATION, '</td><td>', xRoster_LocationDropDown($member['location'] ? $member['location'] : 'US'), '</td></tr>';
    echo '<tr><td>', _MD_CONNECTION, '</td><td>', xRoster_DropDown(
        'connection', $xRosterList_connspeed + array(_MD_OTHER=> _MD_OTHER), $member['connection']
    ), '</td></tr>';
    echo '<tr><td>', _MD_AVAILABLEHOURS, '</td><td>', xRoster_DropDown(
        'ahours', $xRosterList_ahour + array(_MD_TOOMANYHOURS=> _MD_TOOMANYHOURS), $member['ahours']
    ), '</td></tr>';
    echo '<tr><td>', _MD_PRIMARYWEAPON, '</td><td>', xRoster_DropDown('pweapon', $xRosterList_weapon, $member['pweapon']), '</td></tr>';
    echo '<tr><td>', _MD_SECONDARYWEAPON, '</td><td>', xRoster_DropDown('sweapon', $xRosterList_weapon, $member['sweapon']), '</td></tr>';
    echo '<tr><td colspan="2">', _MD_CLANBEFORE, ' ', xRoster_YNDropDown('clan_before', $member['clan_before']), '</td></tr>';
    echo '<tr><td colspan="2">', _MD_NOTE3, '<br><textarea rows="3" name="why_play">', $member['why_play'], '</textarea></td></tr>';
    echo '<tr><td colspan="2">', _MD_NOTE4, '<br><textarea rows="3" name="skills_talents">', $member['skills_talents'], '</textarea></td></tr>';
    echo '<tr><td colspan="2">', _MD_NOTE1, '<br><textarea rows="3" name="additional_comments">', $member['additional_comments'], '</textarea></td></tr>';
    echo '<tr><td>', _MD_TITLE, '</td><td>', xRoster_DropDown('tid', $titles, $member['tid'], true), '</td></tr>';
    echo '<tr><td>', _MD_IMAGEPATH, '</td><td><input type="text" name="picture" value="', $member['picture'], '"></td></tr>';
    echo '<tr><td>', _MD_WEBSITENAME, '</td><td><input type="text" name="sitename" value="', $member['sitename'], '"></td></tr>';
    echo '<tr><td>', _MD_WEBSITEURL, '</td><td><input type="text" name="siteurl" value="', $member['siteurl'], '"></td></tr>';
    echo '<tr><td>', _MD_IMNETWORK, '</td><td>', xRoster_DropDown('impref', $xRosterList_imnetworks, $member['impref']), '</td></tr>';
    echo '<tr><td>', _MD_IMID, '</td><td><input type="text" name="imid" value="', $member['imid'], '"></td></tr>';
    echo '<tr><td colspan="2">', _MD_NOTE5, '<br><textarea rows="3" name="additional_info">', $member['additional_info'], '</textarea></td></tr>';
    echo '<tr><td>', _MD_SINCE, '</td><td>', $member['since'], '</td></tr>';
    echo '<tr><td colspan="2">', _MD_APPROVED, ' ', xRoster_YNDropDown('member', $member['member']), '</td></tr>';
    echo '<tr><td align="center" colspan="2"><input type="submit" value="', _MD_UPDATE, '"></td></tr>
  </table><form>';
}

function Members_List($op = 1)
{
    global $pathIcon16, $indexAdmin;
    $db =& XoopsDatabaseFactory::getDatabaseConnection();
    echo $indexAdmin->addNavigation('main.php?op=members_list');
    $result = xRoster_Query(
        "SELECT m.id, m.membername, m.member, t.name AS title, g.name AS xgroup, c.name AS game
    FROM {xRoster} m
    LEFT JOIN {xRoster_titles} t ON m.tid = t.id
    LEFT JOIN {xRoster_groups} g ON m.gid = g.id
    LEFT JOIN {xRoster_categories} c ON m.cid = c.id
    WHERE m.member = $op ORDER BY c.weight, g.weight, t.weight, m.membername"
    );
    if ($db->getRowsNum($result)) {
        echo '<table cellspacing="0" cellpadding="8" class="outer">';
        $last_game  = '';
        $last_group = '';
        while ($member = $db->fetchArray($result)) {
            if ($last_game != $member['game']) {
                echo '<tr><td colspan="4"><h3>', $member['game'], '</h3></td></tr>';
                $last_game = $member['game'];
            }
            if ($last_group != $member['xgroup'] || $last_game != $member['game']) {
                echo '<tr><td colspan="4"><h4>', $member['xgroup'], '</h4></td></tr>';
                echo '<tr bgcolor="#cccccc"><td><strong>', _MD_MEMBERNAME, '</strong></td><td><strong>', _MD_MEMBERTITLE, '</strong></td><td>', _MD_ACTIONS, '</td></tr>';
                $last_group = $member['xgroup'];
            }
            echo '<tr bgcolor="#eeeeee">
        <td>', $member['membername'], '</td>
        <td>', $member['title'], '</td>
<td><a href="?op=members_edit&action=edit&id=', $member['id'], '">',
                '<img src=' . $pathIcon16 . '/edit.png' . ' alt=' . _EDIT . ' title=' . _EDIT
                . ' />', '</a>  <a href="?op=members_delete&action=confirm&id=', $member['id'], '">',
                '<img src=' . $pathIcon16 . '/delete.png' . ' alt=' . _DELETE . ' title=' . _DELETE . ' />', '</a>
         <a href="?op=members_approve&action=approve&id=', $member['id'], '&subaction=', $member['member'] ? '0' : '1', '">', !$member['member']
                ? '<img src=' . $pathIcon16 . '/on.png' . ' alt=' . _MD_APPROVE . ' title=' . _MD_APPROVE . ' />'
                : '<img src=' . $pathIcon16 . '/off.png' . ' alt=' . _MD_DISAPPROVE . ' title=' . _MD_DISAPPROVE
                . ' />', '</a>', '</td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p align="center">', $op == 0 ? _MD_NOAPPLICANTS : _MD_NOMEMBERS, '</p>';
    }
}

function Members_Delete($id)
{
    $result = xRoster_Query('DELETE FROM {xRoster} WHERE id=%u', $id);
    redirect_header('main.php?op=members_list', 1, _MD_MEMBERDELETED);
}

function Members_Approve($id, $action = 1)
{
    global $indexAdmin;
    echo $indexAdmin->addNavigation('main.php?op=members_approve');
    $action = (int)$action ? 1 : 0;
    $result = xRoster_Query('UPDATE {xRoster} SET member=%u, since=%u WHERE id=%u', $action, time(), $id);
    redirect_header('main.php?op=members_list', 1, _MD_MEMBERUPDATED);
}

function Group_Editor($g_action = '', $id = 0)
{
    global $pathIcon16, $indexAdmin;
    echo $indexAdmin->addNavigation('main.php?op=Group_Editor');
    $indexAdmin->addItemButton(_MD_ADDGROUP, 'main.php?op=Group_Editor&g_action=add', 'add');
    echo $indexAdmin->renderButton('right', '');

    $db =& XoopsDatabaseFactory::getDatabaseConnection();
    switch ($g_action) {
        case 'delete':
            $result = xRoster_Query('SELECT count(*) AS c FROM {xRoster} WHERE gid=%u', $id);
            $row    = $db->fetchArray($result);
            if ($row['c'] == 0) {
                $result = xRoster_Query('DELETE FROM {xRoster_groups} WHERE id=%u', $id);
            } else {
                printf('<br><br>' . _MD_CANTDELETEGROUP, $row['c']);
            }
            redirect_header('main.php?op=Group_Editor', 1, _MD_GROUPDELETED);
            break;
        case 'insert':
            $sql = 'INSERT INTO {xRoster_groups} (name, weight)  VALUES (%s, %u)';
        case 'update':
            $name   = xRoster_PostVar('name');
            $weight = xRoster_PostVar('weight');
            if (!isset($sql)) {
                $result = xRoster_Query('UPDATE {xRoster_groups} SET name=%s, weight=%u WHERE ID=%u', $name, $weight, $id);
            } else {
                $result = xRoster_Query($sql, $name, $weight);
            }
            redirect_header('main.php?op=Group_Editor', 1, _MD_GROUPUPDATED);
            break;
        case 'edit':
            $form_params = array(
                'id'       => $id,
                'g_action' => 'update',
                'btn_label'=> _MD_UPDATE
            );
            $result      = xRoster_Query('SELECT * FROM {xRoster_groups} WHERE id=%u', $id);
            if ($row = $db->fetchArray($result)) {
                $name   = $row['name'];
                $weight = $row['weight'];
            }
        case 'add':
            if (!isset($form_params)) {
                $form_params = array(
                    'id'       => 0,
                    'g_action' => 'insert',
                    'btn_label'=> _MD_INSERT
                );
            }
            echo '<form method="post">';
            if ($form_params['id']) {
                echo '<input type="hidden" name="id" value="', $form_params['id'], '">';
            }
            echo '<input type="hidden" name="g_action" value="', $form_params['g_action'], '">
        <table cellspacing="0" cellpadding="8" class="outer">
        <tr><td>', _MD_GROUPNAME, '</td><td><input type="text" name="name" value="', $name, '"></td></tr>
        <tr><td>', _MD_WEIGHT, '</td><td><input type="text" name="weight" value="', $weight, '" size="4" maxlength="3"></td></tr>
        <tr><td>&nbsp;</td><td><input type="submit" value="', $form_params['btn_label'], '"></td></tr>
        </table><form>';
            break;
        default:
            $result = xRoster_Query('SELECT * FROM {xRoster_groups} ORDER BY weight, name');
            if ($db->getRowsNum($result)) {
                //echo '<table cellspacing="0" cellpadding="8" class="outer" bgcolor="#eeeeee">';
                echo '<p><table cellspacing="0" cellpadding="8" class="outer">
                 <tr bgcolor="#cccccc"><td>', _MD_GROUPNAME, '</td><td>', _MD_WEIGHT, '</td><td>', _MD_ACTIONS, '</td></tr>';
                while ($row = $db->fetchArray($result)) {
                    echo '<tr>
            <td>', $row['name'], '</td><td>', $row['weight'], '</td>
            <td><a href="?op=Group_Editor&g_action=edit&id=', $row['id'], '">',
                        '<img src=' . $pathIcon16 . '/edit.png' . ' alt=' . _EDIT . ' title=' . _EDIT . ' />', '</a>
            <a href="?op=Group_Editor&g_action=delete&id=', $row['id'], '">',
                        '<img src=' . $pathIcon16 . '/delete.png' . ' alt=' . _DELETE . ' title=' . _DELETE
                        . ' />', '</a></td></tr>';
                }
                echo '</table>';
            } else {
                echo '<p align="center">', _MD_NOGROUPS, '</p>';
            }
            break;
    }
}

function Category_Editor($c_action, $id, $name, $weight, $active = 1)
{
    global $pathIcon16, $indexAdmin;
    echo $indexAdmin->addNavigation('main.php?op=Category_Editor');
    $indexAdmin->addItemButton(_MD_ADDCATEGORY, 'main.php?op=Category_Editor&c_action=add', 'add');
    echo $indexAdmin->renderButton('right', '');
    $db =& XoopsDatabaseFactory::getDatabaseConnection();

    switch ($c_action) {
        case 'delete':
            $result = xRoster_Query('SELECT count(*) as count FROM {xRoster} WHERE cid=%u', $id);
            $row    = $db->fetchArray($result);
            if ($row['count'] == 0) {
                xRoster_Query('DELETE FROM {xRoster_categories} WHERE ID=%u', $id);
                redirect_header('main.php?op=Category_Editor', 1, _MD_CATEGORYDELETED);
            } else {
                printf('<br><br>' . _MD_CANTDELECATEGORY, $row['count']);
            }
            break;
        case 'update':
            $result = xRoster_Query("UPDATE {xRoster_categories} SET name=%s, weight=%u, active=%u WHERE ID=%u", $name, $weight, $active, $id);
            redirect_header("main.php?op=Category_Editor", 1, _MD_CATEGORYUPDATED);
            break;
        case 'insert':
            $result = xRoster_Query("INSERT INTO {xRoster_categories} (name, weight, active) VALUES (%s, %u, %u)", $name, $weight, $active);
            redirect_header('main.php?op=Category_Editor', 1, _MD_CATEGORYINSERTED);
            break;
        case 'add':
        case 'edit':
            echo '<p>
      <form method="post">
      <input type="hidden" name="c_action" value="', $c_action == 'edit' ? 'update' : 'insert', '">',
            $c_action == 'edit' ? '<input type="hidden" name="id" value="' . $id . '">' : '', '<table cellspacing=0 cellpadding=8 class="outer">
      <tr><td>', _MD_CATEGORYNAME, '</td><td><input type="text" name="name" value="', $name, '"></td></tr>
      <tr><td>', _MD_WEIGHT, '</td><td><input type="text" name="weight" value="', $weight, '"></td></tr>
      <tr><td>', _MD_ACTIVE, '</td><td>', xRoster_YNDropDown('active', $active), '</td></tr>
      <tr><td>&nbsp;</td><td><input type="submit" value="', $c_action == 'edit' ? _MD_UPDATE : _MD_INSERT, '">
      </td></tr>
      </table>
      <form>';
            break;
        default:
            $result = xRoster_Query('SELECT id, name, weight, active FROM {xRoster_categories} ORDER BY weight');
            if ($db->getRowsNum($result) > 0) {
                echo '<p><table cellspacing="0" cellpadding="8" class="outer">
        <tr bgcolor="#cccccc"><td>', _MD_CATEGORYNAME, '</td><td>', _MD_WEIGHT, '</td><td>', _MD_ACTIVE, '</td><td>', _MD_ACTIONS, '</td></tr>';
                while ($row = $db->fetchArray($result)) {
                    echo '<tr bgcolor="#eeeeee">

          <td>', $row['name'], '</td><td>', $row['weight'], '</td>
          <td>', $row['active'] ? _YES : _NO, '</td>
          <td><a href="?op=Category_Editor&c_action=edit&id=', $row['id'], '&name=', $row['name'], '&weight=', $row['weight'], '&active=', $row['active'], '">',
                        '<img src=' . $pathIcon16 . '/edit.png' . ' alt=' . _EDIT . ' title=' . _EDIT
                        . ' />', '</a>  <a href="?op=Category_Editor&c_action=delete&id=', $row['id'], '">',
                        '<img src=' . $pathIcon16 . '/delete.png' . ' alt=' . _DELETE . ' title=' . _DELETE
                        . ' />', '</a></td></tr>';
                }
                echo '</table>';
            } else {
                echo '<p align="center">', _MD_NOCATEGORIES, '</p>';
            }
            break;
    }
}

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

function Title_Editor($t_action, $id, $name, $weight)
{
    global $pathIcon16, $indexAdmin;
    $db =& XoopsDatabaseFactory::getDatabaseConnection();
    echo $indexAdmin->addNavigation('main.php?op=Title_Editor');
    $indexAdmin->addItemButton(_MD_ADDTITLE, 'main.php?op=Title_Editor&t_action=add', 'add');
    echo $indexAdmin->renderButton('right', '');
    $db =& XoopsDatabaseFactory::getDatabaseConnection();

    switch ($t_action) {
        case "delete":
            $result = xRoster_Query('SELECT count(*) as count FROM {xRoster} WHERE tid=%u', $id);
            $row    = $db->fetchArray($result);
            if ($row['count'] == 0) {
                xRoster_Query('DELETE FROM {xRoster_titles} WHERE ID=%u', $id);
            } else {
                printf('<br><br>' . _MD_CANTDELETETITLE, $row['count']);
            }
            redirect_header('main.php?op=Title_Editor', 1, _MD_TITLEDELETED);
            break;

        case 'update':
            $result = xRoster_Query("UPDATE {xRoster_titles} SET name=%s, weight=%u WHERE ID=%u", $name, $weight, $id);
            redirect_header("main.php?op=Title_Editor", 1, _MD_TITLEUPDATED);
            break;

        case 'insert':
            $result = xRoster_Query("INSERT INTO {xRoster_titles} (name, weight) VALUES (%s, %u)", $name, $weight);
            redirect_header('main.php?op=Title_Editor', 1, _MD_TITLEINSERTED);
            break;
        case 'add':
        case 'edit':
            echo '<p>
             <form method="post">
             <input type="hidden" name="t_action" value="', $t_action == 'edit' ? 'update' : 'insert', '">',
            $t_action == 'edit' ? '<input type="hidden" name="id" value="' . $id . '">' : '', '<table cellspacing=0 cellpadding=8 class="outer">
             <tr><td>', _MD_TITLENAME, '</td><td><input type="text" name="name" value="', $name, '"></td></tr>
             <tr><td>', _MD_WEIGHT, '</td><td><input type="text" name="weight" value="', $weight, '"></td></tr>
             <tr><td>&nbsp;</td><td><input type="submit" value="', $t_action == 'edit' ? _MD_UPDATE : _MD_INSERT, '">
             </td></tr>
             </table>
             <form>';
            break;

        case 'default':
            xRoster_Query('UPDATE {xRoster_titles} SET isdefault=0 WHERE ID<>%u', $id);
            xRoster_Query('UPDATE {xRoster_titles} SET isdefault=1 WHERE ID=%u', $id);
            redirect_header('main.php?op=Title_Editor', 1, _MD_TITLEUPDATED);
            break;
        default:
            $result = xRoster_Query('SELECT id, name, weight FROM {xRoster_titles} ORDER BY weight');
            $titles = $titles_assoc = array();
            while ($row = $db->fetchArray($result)) {
                $titles[]                 = $row;
                $titles_assoc[$row['id']] = $row['name'];
            }
            if (count($titles) > 0) {
                echo("<p><table cellspacing=0 cellpadding=8 class=\"outer\">");
                echo("<tr bgcolor=\"#cccccc\"><td>" . _MD_TITLENAME . "</td><td>" . _MD_WEIGHT . "</td><td>"
                    . _MD_ACTIONS . "</td></tr>");
                for ($j = 0; $j < count($titles); $j++) {
                    echo("<tr bgcolor=\"#eeeeee\">");
                    echo("<td>" . $titles[$j]['name'] . "</td>");
                    echo("<td>" . $titles[$j]['weight'] . "</td>");

                    echo("<td><a href=\"?op=Title_Editor&t_action=edit&id=" . $titles[$j]['id']  . "&name=" . $titles[$j]['name'] . "&weight=" . $titles[$j]['weight'] . "\">" . '<img src='
                        . $pathIcon16 . '/edit.png' . ' alt=' . _EDIT . ' title=' . _EDIT . ' />' . "</a>");
                    echo("<a href=\"?op=Title_Editor&t_action=delete&id=" . $titles[$j]['id'] . "\">" . '<img src='
                        . $pathIcon16 . '/delete.png' . ' alt=' . _DELETE . ' title=' . _DELETE . ' />' . "</a></td>");
                    echo("</tr>");
                }
                echo("</table>");
                // Default title
                echo '<form method="post"><input type="hidden" name="t_action" value="default">', _MD_DEFAULTTITLE, ':', xRoster_DropDown('id', $titles_assoc, xRoster_DefaultTitle(), true, null), ' <input type="submit" value="&gt;&gt;"></form>';
            } else {
                echo("<p align=\"center\">" . _MD_NOTITLES . "</p>");
            }
            break;
    }
}

/**************************************
 * Main - Admin SwitchBox
 *************************************/

if (!ini_get('register_globals')) { // hotfix for register_globals=off
    extract($_GET);
    extract($_POST);
}

//xRoster_AdminHeader();

//global $xoopsModule;
xoops_cp_header();


$op = isset($_POST['op']) ? $_POST['op'] : (isset($_GET['op']) ? $_GET['op'] : 'xRosterConfig');
switch ($op) {
    //case 'Title_Editor': Title_Editor($t_action='', $id=0, $name='', $weight=0); break;
    case 'Title_Editor':
        $t_action = isset($_REQUEST['t_action']) ? $_REQUEST['t_action'] : '';
        $id       = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        $name     = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $weight   = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : 0;
        Title_Editor($t_action, $id, $name, $weight);
        break;
    case 'Category_Editor':
        //Category_Editor($c_action='', $id=0, $name='', $weight=0, !isset($_REQUEST['active']) || (bool)$_REQUEST['active'] ? 1 : 0);
        $c_action = isset($_REQUEST['c_action']) ? $_REQUEST['c_action'] : '';
        $id       = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        $name     = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $weight   = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : 0;
        Category_Editor(
            $c_action, $id, $name, $weight, !isset($_REQUEST['active']) || (bool)$_REQUEST['active'] ? 1 : 0
        );
        break;
    case 'Group_Editor':
        $g_action = isset($_REQUEST['g_action']) ? $_REQUEST['g_action'] : '';
        $id       = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        Group_Editor($g_action, $id);
        break;
    case 'members_approve':
        if (@$_GET['action'] == 'approve' && (int)@$_GET['id']
        ) {
            Members_Approve($_GET['id'], isset($_GET['subaction']) ? (int)$_GET['subaction'] : 1);
        } else {
            Members_List(0);
        }
        break;
    case 'members_list':
        Members_List(1);
        break;
    case 'members_add':
        $id = 0;
    case 'members_edit':
        Members_Edit($id);
        break;
    case 'members_update':
        $realname            = xRoster_PostVar('realname');
        $membername          = xRoster_PostVar('membername');
        $email               = xRoster_PostVar('email');
        $age                 = (int)xRoster_PostVar('age');
        $gid                 = (int)xRoster_PostVar('gid');
        $cid                 = (int)xRoster_PostVar('cid');
        $location            = xRoster_PostVar('location');
        $connection          = xRoster_PostVar('connection');
        $ahours              = xRoster_PostVar('ahours');
        $pweapon             = xRoster_PostVar('pweapon');
        $sweapon             = xRoster_PostVar('sweapon');
        $clan_before         = (int)xRoster_PostVar('clan_before');
        $why_play            = xRoster_PostVar('why_play');
        $skills_talents      = xRoster_PostVar('skills_talents');
        $additional_comments = xRoster_PostVar('additional_comments');
        $tid                 = (int)xRoster_PostVar('tid');
        $picture             = xRoster_PostVar('picture');
        $sitename            = xRoster_PostVar('sitename');
        $siteurl             = xRoster_PostVar('siteurl');
        $impref              = xRoster_PostVar('impref');
        $imid                = xRoster_PostVar('imid');
        $additional_info     = xRoster_PostVar('additional_info');
        $member              = (int)xRoster_PostVar('member', 0);
        $id                  = (int)xRoster_PostVar('id', 0);
        if ($id) {
            //Todo: when I update, if the user was member=0, and it's approved (member=1), I should update the "since" field to time()
            $result = xRoster_Query(
                'UPDATE {xRoster} SET realname=%s, membername=%s, email=%s, age=%d, gid=%d, cid=%d, location=%s, connection=%s, ahours=%s, pweapon=%s,
        sweapon=%s, clan_before=%d, why_play=%s, skills_talents=%s, additional_comments=%s, tid=%d, picture=%s, sitename=%s, siteurl=%s, impref=%s, imid=%s, additional_info=%s, member=%d WHERE id = %d', $realname, $membername, $email, $age, $gid, $cid, $location, $connection, $ahours, $pweapon, $sweapon, $clan_before, $why_play, $skills_talents, $additional_comments, $tid, $picture, $sitename, $siteurl, $impref, $imid, $additional_info, $member, $id
            );
            redirect_header($member ? 'main.php?op=members_list' : 'main.php?op=members_approve', 1, _MD_MEMBERUPDATED);
        } else {
            $result = xRoster_Query(
                'INSERT INTO {xRoster}
        (realname, membername, email, age, gid, cid, location, connection, ahours, pweapon, sweapon, clan_before, why_play, skills_talents, additional_comments, tid, picture, sitename, siteurl, impref, imid, additional_info, member, since)
        VALUES (%s, %s, %s, %d, %d, %d, %s, %s, %s, %s, %s, %d, %s, %s, %s, %d, %s, %s, %s, %s, %s, %s, %d, %d)', $realname, $membername, $email, $age, $gid, $cid, $location, $connection, $ahours, $pweapon, $sweapon, $clan_before, $why_play, $skills_talents, $additional_comments, $tid, $picture, $sitename, $siteurl, $impref, $imid, $additional_info, $member, time()
            );
            redirect_header('main.php?op=members_list', 1, _MD_MEMBERADDED);
        }
        break;
    case 'members_delete':
        Members_Delete($id);
        break;
    case 'ConfigUpdate':
        ConfigUpdate();
        break;
}

//xoops_cp_footer();
include_once 'admin_footer.php';