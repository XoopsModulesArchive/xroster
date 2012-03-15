<?php
// English version.

define('_MD_CANTDELECATEGORY', 'You cannot delete that category until you update %u member(s) and change their category.');
define('_MD_CATEGORYDELETED', 'Category has been deleted.');
define('_MD_CATEGORYUPDATED', 'Category has been updated.');
define('_MD_CATEGORYINSERTED', 'Category has been added.');
define('_MD_NOCATEGORIES', 'There are no categories defined yet.');
define('_MD_CATEGORYNAME', 'Category Name');
define('_MD_ACTIVE', 'Active');
define('_MD_TITLEUPDATED', 'Title has been updated.');
define('_MD_TITLEINSERTED', 'Title has been added.');
define('_MD_TITLEDELETED', 'Title has been deleted.');
define('_MD_DEFAULTTITLE', 'Default title for new applicants');
define('_MD_GROUPUPDATED', 'Group has been updated.');
define('_MD_GROUPINSERTED', 'Group has been added.');
define('_MD_GROUPDELETED', 'Group has been deleted.');
define('_MD_MEMBERUPDATED', 'Member has been updated.');
define('_MD_MEMBERDELETED', 'Member has been deleted.');
define('_MD_MEMBERADDED', 'Member has been added.');
define('_MD_NOTE1', 'Extra Info');
define('_MD_NOTE3', 'Why Play');
define('_MD_NOTE4', 'Skills & Talents');
define('_MD_NOTE5', 'Additional Info');
define('_MD_APPROVED', 'Approved?');
define('_MD_ADMINWELCOME', 'Welcome to the %s Administration center.');
define('_MD_PREFERENCES', 'Preferences');
define('_MD_ADDMEMBER', 'Add New Member');
define('_MD_NEWMEMBERS', 'Approve New Members');
define('_MD_MEMBERS', 'Members List');
define('_MD_TITLEEDITOR', 'Title Editor');
define('_MD_ADDTITLE', 'Add Title');
define('_MD_GROUPEDITOR', 'Group Editor');
define('_MD_ADDGROUP', 'Add Group');
define('_MD_CATEGORYEDITOR', 'Category Editor');
define('_MD_ADDCATEGORY', 'Add Category');
define('_MD_MEMBERNAME', 'Member Name');
define('_MD_MEMBERTITLE', 'Title');
define('_MD_EDIT', 'Edit');
define('_MD_APPROVE', 'Approve');
define('_MD_DISAPPROVE', 'Disapprove');
define('_MD_DISABLE', 'Disable');
define('_MD_DELETE', 'Delete');
define('_MD_UPDATE', 'Update');
define('_MD_INSERT', 'Insert');
define('_MD_NOAPPLICANTS', 'There are no new applicants yet.');
define('_MD_NOMEMBERS', 'There are no members yet.');
define('_MD_NAME', 'Member Name');
define('_MD_SINCE', 'Member Since');
define('_MD_TITLE', 'Title');
define('_MD_CATEGORY', 'Game');
define('_MD_GROUP', 'Group');
define('_MD_REALNAME', 'Real Name');
define('_MD_IMAGEPATH', 'Image Path');
define('_MD_LOCATION', 'Location');
define('_MD_EMAIL', 'Email');
define('_MD_AGE', 'Age');
define('_MD_WEBSITENAME', 'Web Site Name');
define('_MD_WEBSITEURL', 'Web Site URL');
define('_MD_GAMES', 'Games');
define('_MD_IMNETWORK', 'IM Network');
define('_MD_IMID', 'IM ID');
define('_MD_CONNECTION', 'Connection');
define('_MD_AVAILABLEHOURS', 'Available Hours');
define('_MD_PRIMARYWEAPON', 'Primary Weapon');
define('_MD_SECONDARYWEAPON', 'Secondary Weapon');
define('_MD_CLANBEFORE', 'Has this Applicant been in a Clan before?');
define('_MD_TAG', 'Tag');
define('_MD_CANTDELETETITLE', 'You cannot delete that title until you update %u member(s) and change their title.');
define('_MD_TITLENAME', 'Title Name');
define('_MD_WEIGHT', 'Weight');
define('_MD_NOTITLES', 'There are no titles yet.');
define('_MD_CANTDELETEGROUP', 'You cannot delete that group until you update %u member(s) and change their group.');
define('_MD_GROUPNAME', 'Group Name');
define('_MD_NOGROUPS', 'There are no groups yet.');
define('_MD_MAILNEWMEMBERSUBJECT', '%s Application.');
define('_MD_MAILNEWMEMBER', 'A new member has applied.');
define('_MD_PICKONE', 'Pick One');
define('_MD_OTHER', 'Other');
define('_MD_TOOMANYHOURS', 'Too Many To Say');

define('_MD_GAME', 'Game');
define('_MD_NEWGAME', '&lt;- If game not in list, enter its name in the box.');

global $lang_array_apply;
$lang_array_apply = array(
  'lang_formtitle'=>'Application Form',
  'lang_realname'=>'Please provide your real name',
  'lang_callsign'=>'Please provide your Call Sign',
  'lang_email'=>'Please provide a valid email address',
  'lang_age'=>'Please provide us your age',
  'lang_impref'=>'Please provide us your IM Network',
  'lang_imid'=>'Please provide us your IM ID',
  'lang_game'=>'Game',
  'lang_location'=>'Where are you located geographically?',
  'lang_speed'=>'What speed is your Internet connection?',
  'lang_ahours'=>'How many hours a day do you play online?',
  'lang_ahours1'=>'Less than every day',
  'lang_pweapon'=>'Primary weapon of choice?',
  'lang_sweapon'=>'Secondary weapon of choice?',
  'lang_clanbefore'=>'Have you ever been in a Clan before?',
  'lang_whyplay'=>'Why do you want to be part of a clan?',
  'lang_skillstalents'=>'What skill, or talent will you bring to the clan?',
  'lang_additional'=>'Any additional comments or things we should know?',
  'lang_tag'=>'Are you willing to wear the <u>' . $GLOBALS['xoopsConfig']['sitename'] . '</u> tag at all times?',
  'lang_submit'=>'Submit Application',
);

define('_MD_AMSG_ERROR', 'There were some mandatory fields not filled out correctly.');
define('_MD_AMSG_TAGERROR', 'We regret if you can not commit to wearing our clan tag at all times, we cannot accept your application.');
define('_MD_AMSG_ENAME', 'You must enter your real name.');
define('_MD_AMSG_ECALLSIGN', 'You must enter your call sign.');
define('_MD_AMSG_EEMAIL', 'You must enter a valid email address.');
define('_MD_AMSG_EAGE', 'You must enter your age.');
define('_MD_AMSG_ERROR_STOVR', 'Please Start Over.');
define('_MD_AMSG_APPLIED', 'Thank your for applying. We will review your application and let you know.');

define('_MD_ACTIONS', 'Actions');


global $lang_array_view;
$lang_array_view = array(
  'lang_title'=>'Title',
  'lang_group'=>'Group',
  'lang_realname'=>'Real Name',
  'lang_location'=>'Location',
  'lang_age'=>'Age',
  'lang_website'=>'Website',
  'lang_connection'=>'Connection',
  'lang_games'=>'Games',
  'lang_IM'=>'IM',
  'lang_IM_on'=>'on',
  'lang_IM_none'=>'none',
  'lang_info'=>'Info',
  'lang_addinfo'=>'Additional Info',
  'lang_back'=>'Back to Roster',
  'lang_skillstalents'=>'Skills and Talents',
  'lang_whyplay'=>'I want to be part of a clan because',
  'lang_since'=>'Member Since',
);