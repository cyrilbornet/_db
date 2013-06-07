<?php

	include_once('_phptoolbox.php');


	$GLOBALS['ctrl_id'] = 0;	// Unique identifier for form controles, mainly used for JS

	function beginForm($method='get', $action='', $multipart=false) {
		print('<form id="'.('form'.$GLOBALS['ctrl_id']).'" method="'.$method.'" action="'.($action=''?$_SERVER['PHP_SELF']:'').'" '.($multipart?' enctype="multipart/form-data"':'').'>');
	}
	function endForm() {
		print('</form>');
	}

	function printRadioInput($title, $field, $default, $options, $style='form', $comment='', $script='') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'">'.$title.' </label>'); }
		$i = 0;
		foreach ($options as $option => $label) {
			$opt_idb_sd = $GLOBALS['ctrl_id'].'_'.$i;
				print('<input type="radio" id="i'.$opt_id.'" name="'.$field.'" value="'.htmlspecialchars($option).'" '.($option==$default?' checked="checked"':'').' '.str_replace('$ID', $opt_id, $script).'/>');
				print('<p style="display:inline; margin-right:10px;" class="'.$style.'">'.$label.'</p>');
			if ($comment != '') { print('<span class="form_comment">'.$comment.'</span>'); }
			$i++;
		}
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printCustomRadioInput($title, $field, $default, $options, $comment='', $script='') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="form">'.$title.' </label>'); }
		$i = 0;
		print('<div style="margin-left:110px;">');
		foreach ($options as $option => $label) {
			$opt_id = $GLOBALS['ctrl_id'].'_'.$i;
			print('<div style="float:left; '.(count($options)==1?'':'width:150px;').'">');
				print('<input type="radio" id="i'.$opt_id.'" class="styled" name="'.$field.'" value="'.htmlspecialchars($option).'" '.($option==$default?' checked="checked"':'').' '.str_replace('$ID', $opt_id, $script).'/>');
				print('<p style="display:inline; margin-right:10px;" class="form">'.$label.'</p>');
			print('</div>');
			if ($comment != '') { print('<span class="form_comment">'.$comment.'</span>'); }
			$i++;
		}
		print('</div><div style="clear:both;"></div>');
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printTextInput($title, $field, $default, $size, $maxchars=0, $style='form', $comment='', $script='') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'" for="i'.$GLOBALS['ctrl_id'].'">'.$title.' </label>'); }
		print('<input type="text" class="'.$style.'" id="i'.$GLOBALS['ctrl_id'].'" name="'.$field.'" value="'.htmlspecialchars($default).'" size="'.$size.'" '.($maxchars>0?'maxlength="'.$maxchars.'"':'').' '.str_replace('$ID', $GLOBALS['ctrl_id'], $script).'/>');
		if ($comment != '') { print('<span class="form_comment">'.$comment.'</span>'); }
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printPasswordInput($title, $field, $default, $size, $maxchars=0, $style='form', $comment='') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'" for="i'.$GLOBALS['ctrl_id'].'">'.$title.' </label>'); }
		print('<input type="password" id="i'.$GLOBALS['ctrl_id'].'" name="'.$field.'" value="'.htmlspecialchars($default).'" size="'.$size.'" '.($maxchars>0?'maxlength="'.$maxchars.'"':'').'/>');
		if ($comment != '') { print('<span class="form_comment">'.$comment.'</span>'); }
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printStaticInput($title, $content, $size, $style='form') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'">'.$title.' </label>'); }
		print('<input type="text" value="'.htmlspecialchars($content).'" size="'.$size.'" disabled="disabled" />');
		return 'i'.$GLOBALS['ctrl_id'];
	}


	function printTextArea($title, $field, $default, $cols, $rows, $style='form') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="form" for="i'.$GLOBALS['ctrl_id'].'">'.$title.' </label>'); }
		print('<textarea id="i'.$GLOBALS['ctrl_id'].'" name="'.$field.'" cols="'.$cols.'" rows="'.$rows.'" class="'.$style.'">'.stripslashes($default).'</textarea>');
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printSelectInput($title, $field, $default, $options, $style='form', $autosubmit=false) {
		print(makeSelectInput($title, $field, $default, $options, $style, $autosubmit));
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function makeSelectInput($title, $field, $default, $options, $style='form', $autosubmit=false) {
		$select = '';
		$GLOBALS['ctrl_id']++;
		if ($title!='') { $select.=('<label class="'.$style.'" for="i'.$GLOBALS['ctrl_id'].'">'.$title.'</label> '); }
		$select.=('<select id="i'.$GLOBALS['ctrl_id'].'" class="styled" name="'.$field.'"'.($autosubmit?' onchange="javascript:this.form.submit();"':'').'>');
		foreach ($options as $option => $label) {
			$select.=('<option value="'.htmlspecialchars($option).'" '.($option==$default?' selected="selected"':'').'>'.$label.'</option>');
		}
		$select.=('</select>');
		return $select;
	}

	function printCheckInput($title, $field, $defaults, $options, $style='form', $script='') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'"'.(count($options)==1?' for="i'.$GLOBALS['ctrl_id'].'_0"':'').'>'.$title.' </label>'); }
		$i=0;
		print('<div style="margin-left:'.($title==''?0:110).'px;">');
		foreach ($options as $option => $label) {
			$check = '';
			foreach ($defaults as $default) {
				if ($option==$default) $check = ' checked="checked"';
			}
			print('<div style="float:left; '.(count($options)==1?'':'width:200px;').'">');
				print('<input type="checkbox" id="i'.$GLOBALS['ctrl_id'].'_'.$i.'" name="'.$field.'[]" value="'.htmlspecialchars($option).'" '.$check.' '.str_replace('$ID', $GLOBALS['ctrl_id'], $script).'/>');
				print('<label for="i'.$GLOBALS['ctrl_id'].'_'.$i.'" style="display:inline; margin-right:10px;">'.$label.'</label>');
			print('</div>');
			$i++;
		}
		print('</div><div style="clear:both;"></div>');
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printCustomCheckInput($title, $field, $defaults, $options, $style='form', $script='') {
		if (!$GLOBALS['page_has_check_script']) {
			print('<div style="display:none;"><img src="i/check_0.png" alt="" /><img src="i/check_0t.png" alt="" /><img src="i/check_1.png" alt="" /><img src="i/check_1t.png" alt="" /></div>');
			printJS('
				var check_down = "";
				function readState(id) { return (document.getElementById("cbv_"+id).name=="-")?0:1; }
				function checkDown(id) { check_down=id; document.getElementById("cb_"+id).src="i/check_"+readState(id)+"t.png"; }
				function checkUp(id) { if (check_down==id) { checkState(id,"toggle"); } else { checkState(id,"revert"); } check_down=""; }
				function checkState(id, set_state) {
					if (set_state=="on") {
						document.getElementById("cbv_"+id).name = document.getElementById("f_"+id).value+"[]";
					}
					else if (set_state=="off") {
						document.getElementById("cbv_"+id).name = "-";
					}
					else if (set_state=="toggle") {
						if (readState(id)=="0") { checkState(id,"on"); } else { checkState(id,"off"); }
					}
					else {
						if (readState(id)=="0") { checkState(id,"off"); } else { checkState(id,"on"); }
					}
					document.getElementById("cb_"+id).src="i/check_"+readState(id)+".png";
				}
			');
			$GLOBALS['page_has_check_script'] = true;
		}
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'">'.$title.' </label>'); }
		$i=0;
		$checkBoxIDs = array();
		print('<div style="margin-left:110px;">');
		foreach ($options as $option => $label) {
			$check = '';
			$state = '0';
			foreach ($defaults as $default) {
				if ($option==$default) $state = '1';
			}
			$cb_id = ($GLOBALS['ctrl_id']*100)+$i;
			print('<div style="float:left; '.(count($options)==1?'':'width:150px;').'">');
				print('<input type="hidden" id="cbv_'.$cb_id.'" name="'.($state=='0'?'-':$field.'[]').'" value="'.htmlspecialchars($option).'" />');
				print('<input type="hidden" id="f_'.$cb_id.'" value="'.$field.'"/>');
				print('<img src="i/check_'.$state.'.png" id="cb_'.$cb_id.'" width="16" height="16" alt="[]" class="checkbox" onmousedown="javascript:checkDown('.$cb_id.');" onmouseup="javascript:checkUp('.$cb_id.')" />');
				print('<label style="display:inline; margin-right:10px;" onmousedown="javascript:checkDown('.$cb_id.');" onmouseup="javascript:checkUp('.$cb_id.');">'.$label.'</label>');
			print('</div>');
			$checkBoxIDs[] = $cb_id;
			$i++;
		}
		print('</div><div style="clear:both;"></div>');
		return $checkBoxIDs;
	}

	function printUploadInput($title, $field, $default='', $allowedTypes=array(), $path='./', $autoRename=true, $comment='', $style='form') {
		$id = ++$GLOBALS['ctrl_id'];
		if ($title!='') { print('<label for="i'.$GLOBALS['ctrl_id'].'">'.$title.' </label>'); }
		if ($default != '') {
			if (!isset($GLOBALS['js_ul'])) {
				$GLOBALS['js_ul'] = '
				function showUploadSelect(id, field) {
					document.getElementById("del"+id).value=field;
					document.getElementById("i"+id).style.display="none";
					document.getElementById("sel"+id).style.display="inline";
				}';
				printJS($GLOBALS['js_ul']);
			}
			print('<div id="i'.$GLOBALS['ctrl_id'].'" class="fu">');
				print('<div class="field">');
				if ($path!='') {
					if (!strstr($default, '.jpg')&&!strstr($default, '.png')&&!strstr($default, '.gif')) { print('<a href="'.$path.'/'.$default.'">'.$default.'</a>'); }
					else { print('<a href="'.$path.'/'.$default.'" rel="lightbox">'.$default.'</a>'); }
				}
				else { print($default); }
				print('</div>');
				print('<input type="hidden" id="del'.$GLOBALS['ctrl_id'].'" name="deleteFile[]" value="" />');
				print('<input type="button" value="Replace" onclick="showUploadSelect(\''.$GLOBALS['ctrl_id'].'\',\''.$field.'\');" style="float:right;" class="'.$style.'" />');
			print('</div>');
			print('<span id="sel'.$GLOBALS['ctrl_id'].'" style="float:left;display:none;">');
		}
		else {
			print('<span>');
		}
		print('<div class="fu" id="'.$id.'">');
			// Parameters _____________________________________________
			print('<span class="hidden" id="allowedTypes'.$id.'">'.json_encode($allowedTypes).'</span>');
			print('<input type="hidden" id="fNamePolicy'.$GLOBALS['ctrl_id'].'" value="'.($autoRename?'auto':'file').'" />');
			print('<input id="fFileName'.$id.'" type="hidden" name="'.$field.'" value="" />');
			print('<input id="fFileType'.$id.'" type="hidden" name="'.$field.'_T" value="" />');
			// File select + infos ____________________________________
			print('<span id="fc'.$id.'"><input type="file" name="fileToUpload" id="f'.$id.'" onchange="fileSelected(\''.$id.'\');"/></span>');	# multiple="multiple"
			print('<div id="info'.$id.'" class="fu_fileInfo"></div>');
			// Upload monitor _________________________________________
			print('<div id="t'.$id.'" class="fu_progress">');
				print('<img id="icon'.$id.'" src="" width="16" height="16" alt="..." />');
				print('<div id="progressLabel'.$id.'" class="progressValue">&nbsp;</div>');
				print('<div class="progressBar"><div id="progressBar'.$id.'" class="progressLevel"></div></div>');
			print('</div>');
		print('</div>');
		print('</span>');
		return 'fFileName'.$id;	#'i'.$GLOBALS['ctrl_id']
	}

	function printFileInput($title, $field, $default='', $path='./', $comment='', $style='form') {
		$GLOBALS['ctrl_id']++;
		if ($title!='') { print('<label class="'.$style.'" for="i'.$GLOBALS['ctrl_id'].'">'.$title.' </label>'); }
		if ($default != '') {
			if (!isset($GLOBALS['js_file'])) {
				$GLOBALS['js_file'] = '
				function showFileSelect(id, field) {
					document.getElementById("del"+id).value=field;
					document.getElementById("i"+id).style.display="none";
					document.getElementById("sel"+id).style.display="inline";
				}';
				printJS($GLOBALS['js_file']);
			}
			print('<div id="i'.$GLOBALS['ctrl_id'].'" style="width:400px; height:23px; overflow:hidden; border:2px solid #FFFFFF; background:#CCCCCC;">');
				print('<div style="width:300px; height:17px; overflow:hidden; float:left; background:#FFFFFF; margin:2px; padding-left:3px; border-left:1px solid #999999; border-top:1px solid #999999;">');
				if ($path!='') {
					if (!strstr($default, '.jpg')&&!strstr($default, '.png')&&!strstr($default, '.gif')) { print('<a href="'.$path.'/'.$default.'">'.$default.'</a>'); }
					else { print('<a href="'.$path.'/'.$default.'" class="highslide" onclick="return hs.expand(this);">'.$default.'</a>'); }
				}
				else { print($default); }
				print('</div>');
				print('<input type="hidden" id="del'.$GLOBALS['ctrl_id'].'" name="deleteFile[]" value="" />');
				print('<input type="button" value="Remplacer" onclick="javascript:showFileSelect(\''.$GLOBALS['ctrl_id'].'\',\''.$field.'\');" style="float:right;" class="'.$style.'" />');
			print('</div>');
			print('<span id="sel'.$GLOBALS['ctrl_id'].'" style="display:none;"><input type="file" name="'.$field.'" class="'.$style.'" /></span>');
		}
		else {
			print('<input type="file" id="i'.$GLOBALS['ctrl_id'].'" name="'.$field.'" class="'.$style.'" /><span class="form_comment">'.$comment.'</span>');
		}
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printHiddenInput($field, $value) {
		$GLOBALS['ctrl_id']++;
		print('<input type="hidden" id="i'.$GLOBALS['ctrl_id'].'" name="'.$field.'" value="'.htmlspecialchars($value).'" />');
		return 'i'.$GLOBALS['ctrl_id'];
	}

	function printSubmitInput($field, $title, $alignLabel=false, $style='form') {
		if ($alignLabel) { print('<label class="'.$style.'">&nbsp;</label>'); }
		print('<input type="submit" name="'.$field.'" value="'.htmlspecialchars($title).'" class="'.$style.'" />');
	}

	function printDeleteInput($field, $title, $id, $message='Do you really want to delete this item ?', $target_page='', $style='form') {
		if (!isset($GLOBALS['js_delete'])) {
			$GLOBALS['js_delete'] = '
			function confirmDelete(id, field, message) {
				if (confirm(message)) { window.top.location.href = "'.$target_page.'?"+field+"="+id; }
			}';
			printJS($GLOBALS['js_delete']);
		}
		if ($title=='') {
			print('<div class="input" onmouseup="javascript:confirmDelete(\''.$id.'\', \''.$field.'\', \''.addslashes($message).'\');"><img src="i/delete.png" alt="[DELETE]" width="16" height="16" /></div>');
		}
		else {
			print('<input type="button" name="'.$field.'" value="'.htmlspecialchars($title).'" onclick="javascript:confirmDelete(\''.$id.'\', \''.$field.'\', \''.addslashes($message).'\');" class="'.$style.'" />');
		}
	}

	function printLinkButton($link, $title, $inNewWindow=false) {
		if ($inNewWindow) {
			print('<input type="button" value="'.$title.'" onclick="javascript:open(\''.$link.'\',\'new\',\'width=1040,height=1000,toolbar=yes,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes\')" />');
#			print('<div class="input" onmouseup="javascript:open(\''.$link.'\',\'new\',\'width=1040,height=1000,toolbar=yes,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes\');">'.$title.'</div>');
		}
		else {
			print('<input type="button" value="'.$title.'" onclick="javascript:window.top.location.href=\''.$link.'\'" />');
#			print('<div class="input" onmouseup="javascript:window.top.location.href=\''.$link.'\'">'.$title.'</div>');
		}
	}

?>