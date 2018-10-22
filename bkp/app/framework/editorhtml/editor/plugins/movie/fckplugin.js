/*********************************************************************************************************/
/**
 * Movie Player Plugin For Fckeditor (Support: Lajox ; Email: lajox@19www.com)
 */
/*********************************************************************************************************/

// Register the related commands.
FCKCommands.RegisterCommand(
	'Movie',
	new FCKDialogCommand(
		'Movie',
		FCKLang['MoviePlayerDlgTitle'],
		FCKConfig.PluginsPath + 'movie/movieplayer.html',
		450, 270
	)
);
 
// Create the toolbar button.
var oMoviePlayerItem = new FCKToolbarButton(
	'Movie', 
	FCKLang['MoviePlayerBtn'], 
	FCKLang['MoviePlayerTooltip'],
	null, 
	false, true);
oMoviePlayerItem.IconPath = FCKConfig.PluginsPath + 'movie/filmreel.gif'; 
FCKToolbarItems.RegisterItem('Movie', oMoviePlayerItem);
