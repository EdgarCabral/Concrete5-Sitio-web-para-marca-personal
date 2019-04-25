/**
 *   CKAwesome
 *   =========
 *   http://blackdevelop.com/io/ckawesome/
 *
 *   Copyright (C) 2017 by Blackdevelop.com
 *   Licence under GNU GPL v3.
 */

CKEDITOR.on('instanceReady',function () { CKEDITOR.document.appendStyleSheet(CKEDITOR.plugins.getPath('ckawesome') + 'resources/select2/select2.full.min.css');   });
CKEDITOR.on('instanceReady',function () { CKEDITOR.document.appendStyleSheet(CKEDITOR.plugins.getPath('ckawesome') + 'dialogs/ckawesome.css');   });
CKEDITOR.scriptLoader.load(CKEDITOR.plugins.getPath('ckawesome') + 'resources/select2/select2.full.min.js');
CKEDITOR.dtd.$removeEmpty.span = 0;
CKEDITOR.plugins.add('ckawesome', {
    // CHANGES
    // requires: 'colordialog',
    // END CHANGES
    icons: 'ckawesome',

    init: function(editor) {
    	var config = editor.config;
        // CHANGES
        // editor.fontawesomePath = config.fontawesomePath ? config.fontawesomePath : CKEDITOR.plugins.getPath('ckawesome') + 'fontawesome/css/font-awesome.min.css';
        // - hard coded font-awesome.css path
    	editor.fontawesomePath = CCM_REL + '/concrete/css/font-awesome.css';
        // END CHANGES

    	CKEDITOR.document.appendStyleSheet(editor.fontawesomePath);
    	editor.addContentsCss(editor.fontawesomePath);

        CKEDITOR.dialog.add('ckawesomeDialog', this.path + 'dialogs/ckawesome.js');
        editor.addCommand( 'ckawesome', new CKEDITOR.dialogCommand( 'ckawesomeDialog', { allowedContent: 'span[class,style]{color,font-size}(*);' }));
        editor.ui.addButton( 'ckawesome', {
              label: 'Insert CKAwesome',
              command: 'ckawesome',
              toolbar: 'insert',
        });
    }
});
