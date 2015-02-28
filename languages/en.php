<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'videos' => "Videos",
	'videos:add' => "Add video",
	'videos:user' => "%s's videos",
	'videos:embed' => "Embed video",
	'videos:embedurl' => "Enter video URL",
	'videos:edit' => "Edit video",
	'videos:owner' => "%s's videos",
	'videos:owner:none' => "%s has not published any videos",
	'videos:mine' => "My company videos",
	'videos:friends' => "Connections videos",
	'videos:user:friends' => "Videos from connections",
	'videos:everyone' => "All site videos",
	'videos:all' => "All",
	'videos:this:group' => "Videos in %s",
	'videos:morevideos' => "More videos",
	'videos:more' => "More",
	'videos:with' => "Share with",
	'videos:new' => "A new video",
	'videos:via' => "via videos",
	'videos:none' => 'No videos',
	
	
        'videos:featured' => "Featured videos",
	'videos:youtube' => "Search Results",
        'videos:toggle:feature' => "Feature",
        'videos:mostviewed' => "Most viewed videos",
        'videos:popular' => "Most appreciated videos",
        'videos:toggle:unfeature' => "Unfeature",
	'videos:title:featured' => 'Featured videos',
	
	// actions
        'videos:action:toggle_metadata:error' => "An unknown error occured while editing the entity, please try agian",
        'videos:action:toggle_metadata:success' => "The feature video toggle was successful",

	'videos:delete:confirm' => "Are you sure you want to delete this video?",

	'videos:numbertodisplay' => 'Number of videos to display',

	'videos:shared' => "videos shared",
	'videos:recent' => "Recent videos",

	'videos:river:created' => 'added video %s',
	'videos:river:annotate' => 'a comment on this video',
	'videos:river:item' => 'an item',
	'river:commented:object:videos' => 'a video',

	'river:create:object:videos' => '%s added a video %s',
	'river:comment:object:videos' => '%s commented on a video %s',
	'videos:river:annotate' => 'a comment on this video',
	'videos:river:item' => 'an item',
	
	
	
	'item:object:videos' => 'Videos',

	'videos:group' => 'Group videos',
	'videos:enablevideos' => 'Enable group videos',
	'videos:nogroup' => 'This group does not have any videos yet',
	'videos:more' => 'More videos',

	'videos:no_title' => 'No title',
	'videos:file' => 'Select the video file to upload',

	//Youtube  
        'youtube' => 'Youtube',
        'youtube:playlist' => 'Your playlist on Youtube',
        'youtube:playlist:tab' => 'Youtube Playlist',
        'youtube:question1' => 'Do you want to view Youtube videos in content ?',
        'youtube:question2' => 'In which context should we show the search e.g (videos,blog,thewire) ?',
        'youtube:question3' => 'Put your Youtube developer key below, to enable search. A key can be requested at <a href="https://console.developers.google.com" target="_blank">Google developers</a>',

	/**
	 * Widget
	 */
	'videos:widget:description' => "Display your latest videos.",

	/**
	 * Status messages
	 */

	'videos:save:success' => "Your video was successfully saved.",
	'videos:delete:success' => "Your video item was successfully deleted.",

	/**
	 * Error messages
	 */

	'videos:save:failed' => "Your video could not be saved. Make sure you've entered a title and description and then try again.",
	'videos:delete:failed' => "Your video could not be deleted. Please try again.",
	'videos:noembedurl' => 'Video URL empty',
	 /**
	  * Temporary loading of Cash's Video languages
	  */
	  'embedvideo:novideo' => 'No video',
	  'embedvideo:unrecognized' => 'Unrecognised video',
	  'embedvideo:parseerror' => 'Error processing the video',
);

add_translation('en', $english);
