<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$dutch = array(

	/**
	 * Menu items and titles
	 */
	'videos' => "Videos",
	'videos:add' => "Toevoegen video",
	'videos:user' => "%s's videos",
	'videos:embed' => "Invoegen video",
	'videos:embedurl' => "Geef video URL",
	'videos:edit' => "Wijzig video",
	'videos:owner' => "%s's videos",
	'videos:owner:none' => "%s heeft nog geen videos geplaatst",
	'videos:mine' => "Mijn videos",
	'videos:friends' => "Videos van connecties",
	'videos:user:friends' => "Videos van connections",
	'videos:everyone' => "Alle videos",
	'videos:all' => "Alle",
	'videos:this:group' => "Videos in %s",
	'videos:morevideos' => "Meer videos",
	'videos:more' => "Meer",
	'videos:with' => "Delen met",
	'videos:new' => "Een nieuwe video",
	'videos:via' => "via videos",
	'videos:none' => 'Geen videos',
	
	
        'videos:featured' => "Uitgelichte videos",
	'videos:youtube' => "Zoek resultaten",
        'videos:toggle:feature' => "Uitlichten",
        'videos:mostviewed' => "Meest bekeken videos",
        'videos:popular' => "Meest gewaardeerde videos",
        'videos:toggle:unfeature' => "Normaal",
	'videos:title:featured' => 'Uitgelichte videos',
	
	// actions
        'videos:action:toggle_metadata:error' => "Een onbekende fout opgetreden, probeer het opnieuw",
        'videos:action:toggle_metadata:success' => "Omzetten van uitlichten gelukt",

	'videos:delete:confirm' => "Weet u zeker dat u deze video wilt verwijderen?",

	'videos:numbertodisplay' => 'Aantal videos om te tonen',

	'videos:shared' => "video gedeeld ",
	'videos:recent' => "Recente videos",

	'videos:river:created' => 'Video %s toegevoegd',
	'videos:river:annotate' => 'een reactie gegeven op deze video',
	'videos:river:item' => 'een item',
	'river:commented:object:videos' => 'een video',

	'river:create:object:videos' => '%s heeft een video %s toegevoegd',
	'river:comment:object:videos' => '%s heeft een reactie gegeven op %s',
	'videos:river:annotate' => 'een reactie op deze video',
	'videos:river:item' => 'een item',
	
	
	
	'item:object:videos' => 'Videos',

	'videos:group' => 'Groeps videos',
	'videos:enablevideos' => 'Enable group videos',
	'videos:nogroup' => 'Deze groep heeft momenteel nog geen videos',
	'videos:more' => 'Meer videos',

	'videos:no_title' => 'Geen titel',
	'videos:file' => 'Selecteer het video bestand om te uploaden',

	//Youtube  
        'youtube' => 'Youtube',
        'youtube:playlist' => 'Uw playlist op Youtube',
        'youtube:playlist:tab' => 'Youtube Playlist',
        'youtube:question1' => 'Do you want to view Youtube videos in content ?',
        'youtube:question2' => 'In which context should we show the search e.g (videos,blog,thewire) ?',
        'youtube:question3' => 'Put your Youtube developer key below, to enable search. A key can be requested at <a href="https://console.developers.google.com" target="_blank">Google developers</a>',

	/**
	 * Widget
	 */
	'videos:widget:description' => "Toon uw laatste videos.",

	/**
	 * Status messages
	 */

	'videos:save:success' => "Uw videos is succesvol opgeslagen.",
	'videos:delete:success' => "Uw videos is succesvol verwijderd.",

	/**
	 * Error messages
	 */

	'videos:save:failed' => "Uw video kon niet worden opgeslagen, heeft u zowel een titel als beschrijving opgenomen ?",
	'videos:delete:failed' => "Uw video kon niet worden verwijderd.",
	'videos:noembedurl' => 'Video URL leeg',
	 /**
	  * Temporary loading of Cash's Video languages
	  */
	  'embedvideo:novideo' => 'Geen video',
	  'embedvideo:unrecognized' => 'Onbekende video',
	  'embedvideo:parseerror' => 'Fout tijdens het verwerken van de video',
);

add_translation('nl', $dutch);
