<?php

define('_MI_xroster_NAME', 'xroster');
define('_MI_xroster_DESC', 'Build and display a roster.');
define('_MI_xroster_HEADING', 'Application Heading');
define('_MI_xroster_HEADING_DESC', 'Heading that will be displayed at the top of the application screen.');
define('_MD_xroster_APPLICATION', 'Application');
define('_MD_xroster_APPLICATION_DESC','This will turn the application link in the Main Menu on or off.');
define('_MD_xroster_VEMAIL', 'E-Mail Visablity');
define('_MD_xroster_VEMAIL_DESC', 'This will add an email link in the profile list.(Admins always show link)');
define('_MD_xroster_VNAME', 'Real Name Visablity');
define('_MD_xroster_VNAME_DESC', 'This will show real name in the profile list.(Admins always show)');
define('_MD_xroster_ADMINMAIL', 'Admin E-Mail');
define('_MD_xroster_ADMINMAIL_DESC', 'This will be the manager\'s email address.');
define('_MD_xroster_PPICPATH', 'Profile pictures folder pathname');
define('_MD_xroster_PPICPATH_DESC', 'This is the pathname that all the pictures reside in');
define('_MD_xroster_UGROUP', 'Use Groups');
define('_MD_xroster_UGROUP_DESC','This will turn the use of groups on or off.');
define('_MD_xroster_UTITLE', 'Use Titles');
define('_MD_xroster_UTITLE_DESC','This will turn the use of Titles on or off.');
define('_MD_xroster_BLOCK1_NAME', 'Newest Players');
define('_MD_xroster_BLOCK1_DESC', 'Players most recently added');
define('_MD_xroster_BLOCK2_NAME', 'Random Players');
define('_MD_xroster_BLOCK2_DESC', 'Random Players');
define('_MD_xroster_MODDESC', 'Simple application and roster page for people to be listed who are in your club / group, etc');
define('_MD_xroster_AGREEMENT', 'Conditions');
define('_MD_xroster_AGREEMENT_DESC', 'Expectations for applicant');
define('_MD_xroster_AGREEMENT2', 'Acknowlegement');
define('_MD_xroster_AGREEMENT2_DESC', 'Acknowlegement notice of conditions');
define('_MI_xroster_CONFCAT_OPTS', 'Options');
define('_MI_xroster_CONFCAT_OPTS_DESC', 'Module options');
define('_MI_xroster_CONFCAT_BASE', 'Visability');
define('_MI_xroster_CONFCAT_BASE_DESC', 'Visability of items when displayed to normal people');
define('_MD_xroster_UGROUPS', 'Roster Related Group');
define('_MD_xroster_UGROUPS_DESC', 'Group to add user to if Activated or remove from if deleted or deactivated<br>(You must refresh this module if you add or remove groups)');
define('_MD_xroster_MAIL2ADMIN', 'Send Admin an email on application submit?');
define('_MD_xroster_MAIL2ADMIN_DESC', 'Will send an email to the admin when application is submitted');
define('_MD_xroster_MAILONEDIT', 'Send Admin an email on information edit?');
define('_MD_xroster_MAILONEDIT_DESC', 'Will send an email to the admin when application is edited<br>(email on submit must be on as well for this to work)');
define('_MD_xroster_GROUPADD', 'Add user to site group');
define('_MD_xroster_GROUPADD_DESC', 'This will allow a player to be added to or removed from a group based on active status');
define('_MD_xroster_EDITDIRTY', 'Inactivate user after roster edit');
define('_MD_xroster_EDITDIRTY_DESC', 'Make player inactive on the roster if they edit their entry and was active.<br> But do not remove from site group.');
if (!defined('_MD_PREFERENCES')) { define('_MD_PREFERENCES', 'Preferences'); }
if (!defined('_MD_ADDMEMBER')) {define('_MD_ADDMEMBER', 'Add New Member'); }
if (!defined('_MD_NEWMEMBERS')) {define('_MD_NEWMEMBERS', 'Activate New Members'); }
if (!defined('_MD_MEMBERS')) {define('_MD_MEMBERS', 'Members List'); }
if (!defined('_MD_TITLEEDITOR')) {define('_MD_TITLEEDITOR', 'Title Editor'); }
if (!defined('_MD_ADDTITLE')) {define('_MD_ADDTITLE', 'Add Title'); }
if (!defined('_MD_GROUPEDITOR')) {define('_MD_GROUPEDITOR', 'Group Editor'); }
if (!defined('_MD_ADDGROUP')) {define('_MD_ADDGROUP', 'Add Group'); }
if (!defined('_MD_CATEGORYEDITOR')) {define('_MD_CATEGORYEDITOR', 'Category Editor'); }
if (!defined('_MD_ADDCATEGORY')) {define('_MD_ADDCATEGORY', 'Add Category'); }
?>