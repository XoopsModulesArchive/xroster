<?php

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xroster_index_template.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once dirname(__FILE__) . '/common.inc.php';

$op = isset($_GET['op']) ? $_GET['op'] : 'default';
$mid = isset($_GET['mid']) ? intval($_GET['mid']) : null;

if(!ini_get('register_globals')) { // hotfix for register_globals = off
  extract($_GET);
  extract($_POST);
}

switch ($op) {
  case 'Apply':
    $realname = '';
	$email='';
	$membername='';
	$editinstead=0;
	$buttonText="Submit Application";
	function getMemberByName($name) {
      $db =& Database::getInstance();
      $rs = xroster_Query('SELECT m.* FROM {xroster} m
        WHERE  m.membername = %s', $name);
    	$ret = $db->fetchArray($rs);
        if (count($ret)>1) $ret['since'] = formatTimestamp($ret['since'], 's');
    	return $ret;
    }
	
    global $xoopsModuleConfig, $xoopsUser; 
	if (is_object($xoopsUser)) {
	  $membername=$xoopsUser->getvar('uname') ;
	  $member=getMemberByName($membername);
      $xoopsTpl->assign('email', $xoopsUser->getvar('email'));
      $xoopsTpl->assign('realname', $xoopsUser->getvar('name'));	
	  $xoopsTpl->assign('membername', $membername);
	  if ($member) {
	    if ($xoopsModuleConfig['editdirty']) $member['member']=0;
	    $xoopsTpl->assign('editdirty', $xoopsModuleConfig['editdirty']);
	    $xoopsTpl->assign('bdate', $member['bdate']);
        $xoopsTpl->assign('exper', $member['exper']);
        $xoopsTpl->assign('school', $member['school']);
        $xoopsTpl->assign('phone', $member['phone']);
        $xoopsTpl->assign('address', $member['address']);
        $xoopsTpl->assign('city', $member['city']);
        $xoopsTpl->assign('pstate', $member['pstate']);
        $xoopsTpl->assign('zipcode', $member['zipcode']);
        $xoopsTpl->assign('jnumber', $member['jnumber']);
        $xoopsTpl->assign('picture', $member['picture']);
        $xoopsTpl->assign('id', $member['id']);
        $xoopsTpl->assign('member', $member['member']); 
        $xoopsTpl->assign('sweight', $member['sweight']); 		
        $xoopsTpl->assign('select_spositions', xroster_DropDown('spositions', $xrosterList_positions,$member['spositions']));
        $xoopsTpl->assign('select_sweight', xroster_DropDown('sweight', $xrosterList_weight, $member['sweight']));
        $xoopsTpl->assign('select_sheight', xroster_DropDown('sheight', $xrosterList_height, $member['sheight']));		
	  }
	  else {
	    $xoopsTpl->assign('select_spositions', xroster_DropDown('spositions', $xrosterList_positions));
        $xoopsTpl->assign('select_sweight', xroster_DropDown('sweight', $xrosterList_weight));
        $xoopsTpl->assign('select_sheight', xroster_DropDown('sheight', $xrosterList_height));
	  }
	 
	} 

    $xoopsTpl->assign('pop', 'apply');
	$xoopsTpl->assign('editinstead', $editinstead);
    $xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
	$xoopsTpl->assign('heading', $xoopsModuleConfig['heading']);
	$xoopsTpl->assign('agreement', $xoopsModuleConfig['agreement']);
    $xoopsTpl->assign('agreement2', $xoopsModuleConfig['agreement2']);
    $xoopsTpl->assign($lang_array_apply);
    $xoopsTpl->assign('lang_tagerror', _MD_AMSG_TAGERROR);
    $xoopsTpl->assign('buttonText', $buttonText);
    // select boxes	

    break;

  case 'Submit Application':

    function submit_application($id, $realname, $membername, $member, $bdate, $spositions, $sweight, $sheight, $exper, $school, $phone, $email, $address, $city, $pstate, $zipcode, $picture, $jnumber) {
      global $xoopsModuleConfig, $xoopsConfig;
      //$db =& Database::getInstance();
      //$myts =& MyTextSanitizer::getInstance();
      // quote parameters Took this out because it put extra 's on each side of everything
      // $params = array('realname', 'membername', 'bdate', 'spositions', 'sweight','sheight', 'exper', 'school', 'phone', 'email', 'address', 'city', 'pstate', 'zipcode');
      // foreach($params as $param)
      //  if(!is_numeric($$param))
      //    $$param = $db->quoteString($myts->stripSlashesGPC($$param));
	  if($id) {
		$gid = ''; 
		$cid = '';
		$tid = '';
        $result = xroster_Query('UPDATE {xroster} SET realname=%s, membername=%s, phone=%s,  email=%s,  gid=%d, cid=%d, tid=%d, picture=%s, member=%d, 
	    bdate=%s, spositions=%s, sheight=%s, sweight=%s, jnumber=%d, school=%s, address=%s, city=%s, pstate=%s, zipcode=%s, exper=%d WHERE id = %d',
        $realname, $membername, $phone,  $email, $gid, $cid, $tid, $picture, $member,
		$bdate, $spositions, $sheight, $sweight,  $jnumber, $school, $address, $city, $pstate, $zipcode, $exper, $id);
      } else {
        $result = xroster_Query('INSERT INTO {xroster}
        (realname, membername, phone,  email, gid, cid, tid, picture, member, since,
		bdate, spositions, sheight, sweight, jnumber, school, address, city, pstate, zipcode, exper)
        VALUES (%s, %s, %s,  %s, %d, %d, %d, %s,  %d, %d,
		%s, %s, %s, %s, %d, %s, %s, %s, %s, %s, %d )',
        $realname, $membername, $phone,  $email, $gid, $cid, $tid, $picture, $member, time(),
		$bdate, $spositions, $sheight, $sweight, $jnumber, $school, $address, $city, $pstate, $zipcode, $exper);
      }

      if(!($result)) {
        exit('SQL Error in ' . __FILE__ . " :: $sql :: " . $db->error());
        return false;
      }

      $notify_address = $xoopsModuleConfig['adminmail'];
	  if ($xoopsModuleConfig['mail2admin']) {
	    if ($ID || $xoopsModuleConfig['mailonedit']) {
          return mail($notify_address, //email notify
          sprintf(_MD_MAILNEWMEMBERSUBJECT, $xoopsConfig['sitename']),
          _MD_MAILNEWMEMBER,
          "From: $realname <$email>\r\nReply-To: $email\r\n"); 
		} else return true;
	  } else return true;
	   
    }
 
    function validateApplication($id, $realname, $membername, $member, $bdate, $spositions, $sweight, $sheight, $exper, $school, $phone, $email, $address, $city, $pstate, $zipcode, $picture, $jnumber) {
	  $msg='';
	  $realname=strip_tags(trim($realname));
	  if (strlen($realname) <6) $msg .= "You need to edit your account and give your real name before you can apply.<br>";
	  $bdate=strip_tags(trim($bdate));
	  if (strlen($bdate) <6) $msg .= "You need to enter your birthdate.<br>";
	  if (!$spositions) $msg .= "You need to choose your primary position.<br>";
	  if (!$sweight) $msg .= "You need to Select your weight.<br>";
	  if (!$sheight) $msg .= "You need to choose your height.<br>";
	  if  (!is_numeric($exper) || ($exper>20)) $msg .= "You need to enter your number of years pro and/or semipro<br>";
	  $school=strip_tags(trim($school));
	  if (strlen($school) <6) $msg .= "You need to enter your school (Highschool if you never attended college).<br>";
	  $phone=strip_tags(trim($phone));
	  if (strlen($phone) != 13) $msg .= "You need to enter your phone number in the proper format.<br>";
	  $address=strip_tags(trim($address));
	  if (strlen($address) < 8) $msg .= "You need to enter your Street number and name (And apt or room if applies).<br>";
	  $city=strip_tags(trim($city));
	  if (strlen($city) <4) $msg .= "You need to enter your city.<br>";
	  $pstate=strip_tags(trim($pstate));
	  if (strlen($pstate) != 2) $msg .= "You need to enter your 2 letter code for the state.<br>";
	  $zipcode=strip_tags(trim($zipcode));
	  if ((strlen($zipcode) !=5) && (strlen($zipcode) !=10)) $msg .= "You need to enter your zipcode in either xxxxx  or xxxxx-xxxx.<br>";
	  if (!$msg){
	     if(!submit_application($id, $realname, $membername, $member, $bdate, $spositions, $sweight, $sheight, $exper, $school, $phone, $email, $address, $city, $pstate, $zipcode, $picture, $jnumber)) {
      	  $msg .= 'Problem submitting application! Please recheck your entries and try to resubmit';
		} else $msg .= 'True';
	  }
	  return $msg;
	}
	
    $msg = validateApplication( $id, $realname, $membername, $member, $bdate, $spositions, $sweight, $sheight, $exper, $school, $phone, $email, $address, $city, $pstate, $zipcode, $picture, $jnumber); 
    if ($msg!="True") {
      $xoopsTpl->assign('pop', 'apply');
      $xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
      $xoopsTpl->assign('agreement', $xoopsModuleConfig['agreement']);
	  $xoopsTpl->assign('agreement2', $xoopsModuleConfig['agreement2']);
      $xoopsTpl->assign('heading', $xoopsModuleConfig['heading']);
      $xoopsTpl->assign($lang_array_apply);
      $xoopsTpl->assign('membername', $membername);
      $xoopsTpl->assign('realname', $realname);
	  $xoopsTpl->assign('bdate', $bdate);
      $xoopsTpl->assign('exper', $exper);
      $xoopsTpl->assign('school', $school);
      $xoopsTpl->assign('phone', $phone);
      $xoopsTpl->assign('email', $email);
      $xoopsTpl->assign('address', $address);
      $xoopsTpl->assign('city', $city);
      $xoopsTpl->assign('pstate', $pstate);
      $xoopsTpl->assign('zipcode', $zipcode);	  
      $xoopsTpl->assign('lang_tagerror', _MD_AMSG_TAGERROR);
	  $xoopsTpl->assign('msg', $msg);
      // select boxes

	$xoopsTpl->assign('select_spositions', xroster_DropDown('spositions', $xrosterList_positions, $spositions));
    $xoopsTpl->assign('select_sweight', xroster_DropDown('sweight', $xrosterList_weight, $sweight));
    $xoopsTpl->assign('select_sheight', xroster_DropDown('sheight', $xrosterList_height, $sheight));
    } else {
        $xoopsTpl->assign('pop', 'applied');
        $xoopsTpl->assign('lang_applied', _MD_AMSG_APPLIED);
	}
    break;

  case 'View':

    function getMember($id) {
      $db =& Database::getInstance();
      $rs = xroster_Query('SELECT m.* FROM {xroster} m
        WHERE m.member=1 AND m.id = %u', $id);
    	$ret = $db->fetchArray($rs);
      $ret['since'] = formatTimestamp($ret['since'], 's');
    	return $ret;
    }
	

    $xoopsTpl->assign('pop', 'view_member');
    $xoopsTpl->assign('opt2', @$xoopsModuleConfig['hidemail']);
    $xoopsTpl->assign('ppath', $xoopsModuleConfig['ppicpath']);
    $member= array();
    $member=getMember($id);
    if ($member['picture']) {
	  $temp_path=XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['ppicpath'] . $member['picture'];
      $member['picture']=XOOPS_URL . "/" . $xoopsModuleConfig['ppicpath'] . $member['picture'];
	  
      if(!file_exists($temp_path)) {
        $member['picture']= '';
      }
     }      
    
    
    $xoopsTpl->assign('member', $member);
    $xoopsTpl->assign($lang_array_view);
    break;

  default:

    function getMembers() {
      $db =& Database::getInstance();
      $rs = xroster_Query('SELECT m.id, m.member, m.realname, m.spositions, m.sheight, m.sweight, m.city, m.pstate, m.jnumber FROM {xroster} m
        WHERE m.member = 1 ORDER BY  m.jnumber');
      $members = array();
      while($row = $db->fetchArray($rs)) {
      $members[] = $row;
      }
      return $members;
    }
	$xoopsTpl->assign('xrosterapplication', $xoopsModuleConfig['xrosterapplication']);
	$xoopsTpl->assign('adminmail', $xoopsModuleConfig['adminmail']);
    $xoopsTpl->assign('pop', 'list_members');
    $xoopsTpl->assign(array('lang_name'=>_MD_NAME, 'lang_title'=>_MD_TITLE, 'lang_since'=>_MD_SINCE, 'lang_nomembers'=>_MD_NOMEMBERS));
    $members = array();
    foreach(getMembers() as $row)
      @$members[ $row['game'] ][ $row['xgroup'] ][] = array(
        'id'=>$row['id'],
        'realname'=>$row['realname'],
        'spositions'=>$row['spositions'],
		'sheight'=>$row['sheight'],
		'sweight'=>$row['sweight'],
	    'city'=>$row['city'],
	    'pstate'=>$row['pstate'],
	    'jnumber'=>$row['jnumber']	
	);


    $xoopsTpl->assign('members', $members);
	$xoopsTpl->assign('utitle', $xoopsModuleConfig['usetitle']);
	$xoopsTpl->assign('ugroup', $xoopsModuleConfig['usegroup']);
	
}

$xoopsTpl->assign('xoops_showrblocks', 0);
require_once XOOPS_ROOT_PATH . '/footer.php';

?>