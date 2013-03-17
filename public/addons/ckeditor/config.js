/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];
    config.extraPlugins = 'pbckcode';

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript';

    config.pbckcode  = {
        'cls'         : 'prettyprint linenums', // the class(es) added to the pre tag, useful if you use a syntax highlighter (here it is Google Prettify)
        'modes'       : [ 
            ["C/C++"        , "c_pp"],
            ["Clojure"      , "clojure"],
            ["CoffeeScript" , "coffee"],
            ["C#"           , "csharp"],
            ["CSS"          , "css"],
            ["Groovy"       , "groovy"],
            ["HTML"         , "html"],
            ["Java"         , "java"],
            ["JavaScript"   , "javascript"],
            ["JSX"          , "jsx"],
            ["LaTeX"        , "latex"],
            ["LESS"         , "less"],
            ["Lua"          , "lua"],
            ["Markdown"     , "markdown"],
            ["Perl"         , "perl"],
            ["PHP"          , "php"],
            ["Python"       , "python"],
            ["R"            , "ruby"],
            ["SCSS/Sass"    , "scss"],
            ["SH"           , "sh"],
            ["SQL"          , "sql"],
            ["Text"         , "text"],
            ["XML"          , "xml"],
            ["YAML"         , "yaml"] ], // all the languages you want to deal with in the plugin
        'defaultMode' : 'php', // the default value for the mode select. Well in fact it is the first value of the mode array
        'theme' : 'solarized_light' // the theme of the code editor
    };
};
