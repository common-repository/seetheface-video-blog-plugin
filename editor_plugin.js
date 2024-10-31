var temp = tinyMCE.settings['language'];
tinyMCE.settings['language'] = 'en';

tinyMCE.importPluginLanguagePack('seetheface', 'en');

tinyMCE.settings['language'] = temp;

var TinyMCE_seethefacePlugin = {
	getInfo : function() {
		return {
			longname : 'seetheface',
			author : 'Unknown',
			authorurl : 'www.myurl.com',
			infourl : 'www.myurl.com',
			version : "1.0"
		};
	},
	getControlHTML : function(cn) {
		switch (cn) {
			case "seetheface":
				return tinyMCE.getButtonHTML(cn, 'lang_seetheface_title', '{$pluginurl}/seetheface-button.png', 'mce_seetheface');
		}
		return "";
	},
	execCommand : function(editor_id, element, command, user_interface, value) {
		switch (command) {
			case "mce_seetheface":
				seetheface_insert('seeme');
				return true;
		}
		return false;
	}
};


tinyMCE.addPlugin('seetheface', TinyMCE_seethefacePlugin);