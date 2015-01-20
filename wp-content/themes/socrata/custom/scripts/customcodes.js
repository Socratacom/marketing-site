(function() {
    tinymce.create('tinymce.plugins.youtube', {
        init : function(ed, url) {
            ed.addButton('youtube', {
                title : 'Add YouTube Video',
                image : url+'/youtube.gif',
                onclick : function() {
                     ed.selection.setContent('[youtube id="PASTE ID HERE"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('youtube', tinymce.plugins.youtube);
})();
(function() {
    tinymce.create('tinymce.plugins.wistia', {
        init : function(ed, url) {
            ed.addButton('wistia', {
                title : 'Add Wistia Video',
                image : url+'/wistia.gif',
                onclick : function() {
                     ed.selection.setContent('[wistia id="PASTE ID HERE"]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('wistia', tinymce.plugins.wistia);
})();