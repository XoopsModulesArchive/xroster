<?php
$i = 0;

// $adminmenu[0]['title'] = _MD_PREFERENCES;
// $adminmenu[0]['link'] = '../system/admin.php?fct=preferences&op=showmod&mod=12';
$i++;
$adminmenu[$i]['title'] = _MD_ADDMEMBER;
$adminmenu[$i]['link'] = 'admin/index.php?op=members_add';
$i++;
$adminmenu[$i]['title'] = _MD_NEWMEMBERS;
$adminmenu[$i]['link'] = 'admin/index.php?op=members_approve';
$i++;
$adminmenu[$i]['title'] = _MD_MEMBERS;
$adminmenu[$i]['link'] = 'admin/index.php?op=members_list';
/*$i++;
$adminmenu[$i]['title'] = _MD_TITLEEDITOR;
$adminmenu[$i]['link'] = 'admin/index.php?op=Title_Editor';
$i++;
$adminmenu[$i]['title'] = _MD_ADDTITLE;
$adminmenu[$i]['link'] = 'admin/index.php?op=Title_Editor&t_action=add';
$i++;
$adminmenu[$i]['title'] = _MD_GROUPEDITOR;
$adminmenu[$i]['link'] = 'admin/index.php?op=Group_Editor';
$i++;
$adminmenu[$i]['title'] = _MD_ADDGROUP;
$adminmenu[$i]['link'] = 'admin/index.php?op=members_add';
$i++;
$adminmenu[$i]['title'] = _MD_CATEGORYEDITOR;
$adminmenu[$i]['link'] = 'admin/index.php?op=Category_Editor';
$i++;
$adminmenu[$i]['title'] = _MD_ADDCATEGORY;
$adminmenu[$i]['link'] = 'admin/index.php?Category_Editor&c_action=add'; */
?>