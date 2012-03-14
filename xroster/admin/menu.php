<?php

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

xoops_loadLanguage('admin', $dirname);
$i = 0;

// Index
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU0;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/home.png';
$i++;

$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU1;
$adminmenu[$i]['link'] = 'admin/main.php?op=members_add';
$adminmenu[$i]["icon"] = $pathIcon32.'/add.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU2;
$adminmenu[$i]['link'] = 'admin/main.php?op=members_approve';
$adminmenu[$i]["icon"] = $pathIcon32.'/button_ok.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU3;
$adminmenu[$i]['link'] = 'admin/main.php?op=members_list';
$adminmenu[$i]["icon"] = $pathIcon32.'/search.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU4;
$adminmenu[$i]['link'] = 'admin/main.php?op=Group_Editor';
$adminmenu[$i]["icon"] = $pathIcon32.'/users.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU5;
$adminmenu[$i]['link'] = 'admin/main.php?op=Title_Editor';
$adminmenu[$i]["icon"] = $pathIcon32.'/manage.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU6;
$adminmenu[$i]['link'] = 'admin/main.php?op=Category_Editor';
$adminmenu[$i]["icon"] = $pathIcon32.'/category.png';

$i++;
$adminmenu[$i]['title'] = _MI_XROSTER_ADMENU7;
$adminmenu[$i]['link'] =  "admin/about.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/about.png';

