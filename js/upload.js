var kMsgInterrupt = 'Téléversement interrompu. Veuillez réessayer en sélectionnant à nouveau votre fichier.';
var kMsgFail = 'Une erreur est survenue lors du chargement.';
var kMsgWrongType = 'Mauvais type de fichier. Les formats suivants sont acceptés : ';
var kImageLoading = 'i/loading.gif';
var kImageSuccess = 'i/ok.png';
var kImageError = 'i/error.png';
var kProgressUnknown = 'Chargement...';
var kColorProgressComplete = '#888888';
var kLabelComplete = 'OK';

if (!Array.indexOf){
	Array.prototype.indexOf = function(obj){
		for (var i=0; i<this.length; i++){
			if (this[i]==obj) return i;
		}
		return -1;
	}
}

function json_decode(str) {
	return eval('('+str+')');
}

function fileSelected(fieldID) {
	var file = document.getElementById('f'+fieldID).files[0];
	var allowedTypes = json_decode(document.getElementById('allowedTypes'+fieldID).innerHTML);
	if (allowedTypes.length > 0 && allowedTypes.indexOf(file.type)==-1) {
		alert(kMsgWrongType+allowedTypes+" ("+file.type+")");
		document.getElementById('f'+fieldID).value='';
	}
	else {
		var fileSize = 0;
		if (file.size > 1024*1024)
			fileSize = (Math.round(file.size * 100 / (1024*1024)) / 100).toString() + 'MB';
		else
			fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
		document.getElementById('f'+fieldID).style.display = 'none';
		document.getElementById('t'+fieldID).style.display = 'block';
		document.getElementById('info'+fieldID).innerHTML = fileSize+' ('+file.type+')';
		document.getElementById('icon'+fieldID).src = kImageLoading;
		uploadFile(fieldID, file);
	}
}

function uploadFile(fieldID, file) {
	var fd = new FormData();
	fd.append('fileName', file.name);
	fd.append(document.getElementById('f'+fieldID).name, file);

	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener('progress', function(evt){uploadProgress(evt,fieldID)}, false);
	xhr.addEventListener('load', function(evt){uploadComplete(evt,fieldID)}, false);
	xhr.addEventListener('error', function(evt){uploadFailed(evt,fieldID)}, false);
	xhr.addEventListener('abort', function(evt){uploadCanceled(evt,fieldID)}, false);
	xhr.open('post', '/edit/upload.php?n='+document.getElementById('fNamePolicy'+fieldID).value);
	xhr.send(fd);
}

function uploadProgress(evt,fieldID) {
	if (evt.lengthComputable) {
		var bytesUploaded = evt.loaded;
		var bytesTotal = evt.total;
		var percentComplete = Math.round(evt.loaded*100/evt.total);
		var norm, unit;
		if (bytesUploaded > 100*1024) {
			norm = (1024*1024);
			unit = 'Mo';
		}
		else {
			norm = (1024);
			unit = 'Ko';
		}
		document.getElementById('progressLabel'+fieldID).innerHTML = (Math.round(bytesUploaded * 10/norm)/10).toString()+'/'+(Math.round(bytesTotal * 10/norm)/10).toString()+' '+unit;
		document.getElementById('progressBar'+fieldID).style.width = percentComplete.toString()+'%';
	}
	else {
		document.getElementById('progressBar'+fieldID).innerHTML = kProgressUnknown;
	}
}

function uploadComplete(evt,fieldID) {
	var uploadResponse = eval('('+evt.target.responseText+')');
	if (uploadResponse['status']==1) {
		document.getElementById('f'+fieldID).style.display = 'none';
		document.getElementById('fc'+fieldID).innerHTML = '';
		document.getElementById('progressLabel'+fieldID).innerHTML = kLabelComplete;
		document.getElementById('icon'+fieldID).src = kImageSuccess;
		document.getElementById('fFileName'+fieldID).value = uploadResponse['file'];
		document.getElementById('info'+fieldID).innerHTML = uploadResponse['file'];
		document.getElementById('progressBar'+fieldID).style.background = kColorProgressComplete;
	}
	else {
		document.getElementById('icon'+fieldID).src = kImageError;
		alert(uploadResponse['msg']);
	}

}

/* Unknown error ********************************************************************************************/
function uploadFailed(evt,fieldID) {
	alert(kMsgFail);
}

/* The upload has been canceled by the user or the browser dropped the connection. **************************/
function uploadCanceled(evt,fieldID) {
	alert(kMsgInterrupt);
}