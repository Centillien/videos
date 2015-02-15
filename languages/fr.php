<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'videos' => "Videos",
	'videos:add' => "Ajouter un video",
	'videos:embed' => "Intégrez un video",
	'videos:embedurl' => "Entrez l URL du video",
	'videos:edit' => "Editez le video",
	'videos:owner' => "%s's videos",
	'videos:friends' => "Videos de connexions",
	'videos:everyone' => "Tout les videos du site",
	'videos:this:group' => "Videos en %s",
	'videos:morevideos' => "Plus de videos",
	'videos:more' => "Plus",
	'videos:with' => "Partagez avec",
	'videos:new' => "Un nouveau video",
	'videos:via' => "Videos via",
	'videos:none' => 'Pas de videos',

	'videos:delete:confirm' => "Êtes vous certain de vouloir supprimer ce video?",

	'videos:numbertodisplay' => 'Nombre de videos à démontrer',

	'videos:shared' => "Videos partagés",
	'videos:recent' => "Video récent",

	'videos:river:created' => 'Video ajouté %s',
	'videos:river:annotate' => 'un commentaire sur ce video',
	'videos:river:item' => 'un item',
	'river:commented:object:videos' => 'un video',

	'river:create:object:videos' => '%s à ajouté un video %s',
	'river:comment:object:videos' => '%s à commenté sur un video %s',
	'videos:river:annotate' => 'un commentaire sur ce video',
	'videos:river:item' => 'un item',
	
	
	
	'item:object:videos' => 'Videos',

	'videos:group' => 'Groupe de videos',
	'videos:enablevideos' => 'Activer groupe videos',
	'videos:nogroup' => 'Ce groupe n à pas encore de videos',
	'videos:more' => 'Plus de videos',

	'videos:no_title' => 'Pas de titre',
	'videos:file' => 'Choisir le fichier video à télécharger',

	/**
	 * Widget
	 */
	'videos:widget:description' => "Affichez vos derniers videos.",

	/**
	 * Status messages
	 */

	'videos:save:success' => "Votre video à été sauvegardé avec succes.",
	'videos:delete:success' => "Votre video à été supprimé avec succes.",

	/**
	 * Error messages
	 */

	'videos:save:failed' => "Votre vidéo ne peut être sauvé. Assurez-vous que vous avez entré un titre et une description, puis essayez à nouveau.",
	'videos:delete:failed' => "Votre vidéo ne peut être supprimé. S'il vous plaît essayez de nouveau.",
	'videos:noembedurl' => 'URL du vidéo manquante',
	 /**
	  * Temporary loading of Cash's Video languages
	  */
	  'embedvideo:novideo' => 'Pas de video',
	  'embedvideo:unrecognized' => 'Video inconnue',
	  'embedvideo:parseerror' => 'Une erreure dans le processuce du vidéo',
);

add_translation('fr', $french);
