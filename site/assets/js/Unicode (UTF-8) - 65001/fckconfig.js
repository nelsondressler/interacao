<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

FCKConfig.CustomConfigurationsPath = '' ;

FCKConfig.EditorAreaCSS = FCKConfig.BasePath + 'css/fck_editorarea.css' ;
FCKConfig.EditorAreaStyles = '' ;
FCKConfig.ToolbarComboPreviewCSS = '' ;

FCKConfig.DocType = '' ;

FCKConfig.BaseHref = '' ;

FCKConfig.FullPage = false ;

// The following option determines whether the "Show Blocks" feature is enabled or not at startup.
FCKConfig.StartupShowBlocks = false ;

FCKConfig.Debug = false ;
FCKConfig.AllowQueryStringDebug = true ;

FCKConfig.SkinPath = FCKConfig.BasePath + 'skins/default/' ;
FCKConfig.SkinEditorCSS = '' ; // FCKConfig.SkinPath + "|<minified css>" ;
FCKConfig.SkinDialogCSS = '' ; // FCKConfig.SkinPath + "|<minified css>" ;

FCKConfig.PreloadImages = [ FCKConfig.SkinPath + 'images/toolbar.start.gif', FCKConfig.SkinPath + 'images/toolbar.buttonarrow.gif' ] ;

FCKConfig.PluginsPath = FCKConfig.BasePath + 'plugins/' ;

FCKConfig.AutoGrowMax = 400 ;

FCKConfig.DefaultLanguage = 'pt-br' ;
FCKConfig.ContentLangDirection = 'ltr' ;

FCKConfig.ProcessHTMLEntities = true ;
FCKConfig.IncludeLatinEntities = true ;
FCKConfig.IncludeGreekEntities = true ;

FCKConfig.ProcessNumericEntities = false ;

FCKConfig.AdditionalNumericEntities = '' ; // Single Quote: "'"

FCKConfig.FillEmptyBlocks = true ;

FCKConfig.FormatSource = true ;
FCKConfig.FormatOutput = true ;
FCKConfig.FormatIndentator = ' ' ;

FCKConfig.StartupFocus = false ;
FCKConfig.ForcePasteAsPlainText = false ;
FCKConfig.AutoDetectPasteFromWord = true ; // IE only.
FCKConfig.ShowDropDialog = true ;
FCKConfig.ForceSimpleAmpersand = false ;
FCKConfig.TabSpaces = 0 ;
FCKConfig.ShowBorders = true ;
FCKConfig.SourcePopup = false ;
FCKConfig.ToolbarStartExpanded = true ;
FCKConfig.ToolbarCanCollapse = true ;
FCKConfig.IgnoreEmptyParagraphValue = true ;
FCKConfig.PreserveSessionOnFileBrowser = false ;
FCKConfig.FloatingPanelsZIndex = 10000 ;
FCKConfig.HtmlEncodeOutput = false ;

FCKConfig.TemplateReplaceAll = true ;
FCKConfig.TemplateReplaceCheckbox = true ;

/*
 * Insere os plugins de movie e media
 */
FCKConfig.Plugins.Add( 'movie','en,zh-cn')



FCKConfig.ToolbarLocation = 'In' ;

FCKConfig.ToolbarSets["NeodreamPlus"] = [
 ['Source'],['Paste','PasteText','PasteWord'],
 ['Find','Replace'],['Link','Unlink','Anchor'],
 ['Image','Movie','Table','Rule','SpecialChar'],['OrderedList','UnorderedList','Outdent','Indent'],'/',

 ['Style','TextColor','BGColor','RemoveFormat'],
 ['Bold','Italic','Underline','StrikeThrough'],['Subscript','Superscript'],
 ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull']
];

FCKConfig.EnterMode = 'p' ; // p | div | br
FCKConfig.ShiftEnterMode = 'br' ; // p | div | br

FCKConfig.Keystrokes = [
 [ CTRL + 65 , true ],
 [ CTRL + 67 , true ],
 [ CTRL + 70 , true ],
 [ CTRL + 83 , true ],
 [ CTRL + 84 , true ],
 [ CTRL + 88 , true ],
 [ CTRL + 86 , 'Paste' ],
 [ SHIFT + 45 , 'Paste' ],
 [ CTRL + 88 , 'Cut' ],
 [ SHIFT + 46 , 'Cut' ],
 [ CTRL + 90 , 'Undo' ],
 [ CTRL + 89 , 'Redo' ],
 [ CTRL + SHIFT + 90 , 'Redo' ],
 [ CTRL + 76 , 'Link' ],
 [ CTRL + 66 , 'Bold' ],
 [ CTRL + 73 , 'Italic' ],
 [ CTRL + 85 , 'Underline' ],
 [ CTRL + SHIFT + 83 , 'Save' ],
 [ CTRL + ALT + 13 , 'FitWindow' ]
] ;

FCKConfig.ContextMenu = ['Generic','Link','Anchor','Image','Flash','Select','Textarea','Checkbox','Radio','TextField','HiddenField','ImageButton','Button','BulletedList','NumberedList','Table','Form'] ;
FCKConfig.BrowserContextMenuOnCtrl = false ;

FCKConfig.EnableMoreFontColors = true ;
FCKConfig.FontColors = '000000,993300,333300,003300,003366,000080,333399,333333,800000,FF6600,808000,808080,008080,0000FF,666699,808080,FF0000,FF9900,99CC00,339966,33CCCC,3366FF,800080,999999,FF00FF,FFCC00,FFFF00,00FF00,00FFFF,00CCFF,993366,C0C0C0,FF99CC,FFCC99,FFFF99,CCFFCC,CCFFFF,99CCFF,CC99FF,FFFFFF' ;

FCKConfig.FontFormats = 'p;h1;h2;h3;h4;h5;h6;pre;address;div' ;
FCKConfig.FontNames = 'Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana' ;
FCKConfig.FontSizes = 'smaller;larger;xx-small;x-small;small;medium;large;x-large;xx-large' ;

FCKConfig.StylesXmlPath = FCKConfig.EditorPath + 'fckstyles.xml' ;
FCKConfig.TemplatesXmlPath = FCKConfig.EditorPath + 'fcktemplates.xml' ;

FCKConfig.SpellChecker = 'ieSpell' ; // 'ieSpell' | 'SpellerPages'
FCKConfig.IeSpellDownloadUrl = 'http://www.iespell.com/download.php' ;
FCKConfig.SpellerPagesServerScript = 'server-scripts/spellchecker.php' ; // Available extension: .php .cfm .pl
FCKConfig.FirefoxSpellChecker = false ;

FCKConfig.MaxUndoLevels = 15 ;

FCKConfig.DisableObjectResizing = false ;
FCKConfig.DisableFFTableHandles = true ;

FCKConfig.LinkDlgHideTarget = false ;
FCKConfig.LinkDlgHideAdvanced = false ;

FCKConfig.ImageDlgHideLink = false ;
FCKConfig.ImageDlgHideAdvanced = false ;

FCKConfig.FlashDlgHideAdvanced = false ;

FCKConfig.ProtectedTags = '' ;

// This will be applied to the body element of the editor
FCKConfig.BodyId = '' ;
FCKConfig.BodyClass = '' ;

FCKConfig.DefaultStyleLabel = '' ;
FCKConfig.DefaultFontFormatLabel = '' ;
FCKConfig.DefaultFontLabel = '' ;
FCKConfig.DefaultFontSizeLabel = '' ;

FCKConfig.DefaultLinkTarget = '' ;

// The option switches between trying to keep the html structure or do the changes so the content looks like it was in Word
FCKConfig.CleanWordKeepsStructure = false ;

// Only inline elements are valid.
FCKConfig.RemoveFormatTags = 'b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var' ;

// Attributes that will be removed
FCKConfig.RemoveAttributes = 'class,style,lang,width,height,align,hspace,valign' ;

FCKConfig.CustomStyles = '';


FCKConfig.CoreStyles =
{
 // Basic Inline Styles.
 'Bold' : { Element : 'strong', Overrides : 'b' },
 'Italic' : { Element : 'em', Overrides : 'i' },
 'Underline' : { Element : 'u' },
 'StrikeThrough' : { Element : 'strike' },
 'Subscript' : { Element : 'sub' },
 'Superscript' : { Element : 'sup' },

 // Basic Block Styles (Font Format Combo).
 'p' : { Element : 'p' },
 'div' : { Element : 'div' },
 'pre' : { Element : 'pre' },
 'address' : { Element : 'address' },
 'h1' : { Element : 'h1' },
 'h2' : { Element : 'h2' },
 'h3' : { Element : 'h3' },
 'h4' : { Element : 'h4' },
 'h5' : { Element : 'h5' },
 'h6' : { Element : 'h6' },

 // Other formatting features.
 'FontFace' :
 {
 Element : 'span',
 Styles : { 'font-family' : '#("Font")' },
 Overrides : [ { Element : 'font', Attributes : { 'face' : null } } ]
 },

 'Size' :
 {
 Element : 'span',
 Styles : { 'font-size' : '#("Size","fontSize")' },
 Overrides : [ { Element : 'font', Attributes : { 'size' : null } } ]
 },

 'Color' :
 {
 Element : 'span',
 Styles : { 'color' : '#("Color","color")' },
 Overrides : [ { Element : 'font', Attributes : { 'color' : null } } ]
 },

 'BackColor' : { Element : 'span', Styles : { 'background-color' : '#("Color","color")' } },

 'SelectionHighlight' : { Element : 'span', Styles : { 'background-color' : 'navy', 'color' : 'white' } }
};


FCKConfig.IndentLength = 40 ;
FCKConfig.IndentUnit = 'px' ;


FCKConfig.IndentClasses = [] ;


FCKConfig.JustifyClasses = [] ;


var _FileBrowserLanguage = 'php' ; // asp | aspx | cfm | lasso | perl | php | py
var _QuickUploadLanguage = 'php' ; // asp | aspx | cfm | lasso | perl | php | py


var _FileBrowserExtension = _FileBrowserLanguage == 'perl' ? 'cgi' : _FileBrowserLanguage ;
var _QuickUploadExtension = _QuickUploadLanguage == 'perl' ? 'cgi' : _QuickUploadLanguage ;


FCKConfig.ImageBrowser = false ;
FCKConfig.ImageBrowserURL = FCKConfig.BasePath + 'filemanager1/browser/default/imagem_box.php';
FCKConfig.ImageBrowserWindowWidth = 600;
FCKConfig.ImageBrowserWindowHeight = 500;

FCKConfig.BackgroundBlockerColor = '#ffffff' ;
FCKConfig.BackgroundBlockerOpacity = 0.50 ;
