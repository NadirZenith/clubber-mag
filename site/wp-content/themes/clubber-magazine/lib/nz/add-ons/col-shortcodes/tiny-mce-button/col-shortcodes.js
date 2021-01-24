
(function () {
    tinymce.create('tinymce.plugins.Wptuts', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {
            ed.addButton('colshortcodes', {
                title: 'colshortcodes',
                cmd: 'colshortcodes',
                image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAACISURBVCjPY/zPgB8wMVCqgAVElP//x/AHDKczMjBE/f/F8JvhFxDuBfIY/xNjQsH/P0A9ILgYqMfn/y8GCDxDtAmp/3+Dbf3NsAGoxw5uwi2iTYiE69kP1KMP9cVvhudEm+ANN+EsUI/i/99QP30m2gTb/z/B+n8z3AbqEQWaAAnXP8SYQDCyACM6Tx8bGCIyAAAAAElFTkSuQmCC'
            });

            ed.addCommand('colshortcodes', function () {
                var shortcode;

                shortcode = '[cm-col col-1-3] [/cm-col]';
                ed.execCommand('mceInsertContent', 0, shortcode);
                return;

            });
        },
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl: function (n, cm) {
            return null;
        },
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo: function () {
            return {
                longname: 'col-shortcodes Button',
                author: 'Nz',
                authorurl: 'http://nadirzenith.net',
                infourl: 'http://nadirzenith.net',
                version: "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('colshortcodes', tinymce.plugins.Wptuts);
})();
/*
 * src: http://code.tutsplus.com/tutorials/guide-to-creating-your-own-wordpress-editor-buttons--wp-30182
 */