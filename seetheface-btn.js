function seetheface_insert(postid) {
	
	if(window.tinyMCE) {
		var postnumber;
		
		if (postid == 'seeme') postnumber = document.getElementById('post_ID').value;
		else postnumber = (postid == 0) ? document.getElementsByName('temp_ID')[0].value : postid;
		
		var template = new Array();

		template['file'] = tinyMCE.baseURL + '/../../../wp-content/plugins/seetheface/seethefacelist2.php';
		template['width'] = 820;
		template['height'] = 470;

		args = {
			resizable : 'yes',
			scrollbars : 'yes',
			inline : 'no'
		};

		tinyMCE.openWindow(template, args);
		return true;
	} else {
		window.alert('This function is only available in the WYSIWYG editor');
		return true;
	}
}

function ev_insertVideoCode(linktext) {
	var text = '[seetheface id="'+ linktext + '"] ';
	
	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, text);
		tinyMCE.execCommand("mceCleanup");
		tinyMCE.selectedInstance.repaint();
	} else {
		edInsertContent(edCanvas, text);
	}
	
	return true;
}


function init() {
	tinyMCEPopup.resizeToInnerSize();
}