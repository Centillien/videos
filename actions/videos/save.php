<?php
/**
* Elgg videos save action
 *	Author : Sarath C | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : webgalli@gmail.com
 *	Web	: http://webgalli.com | http://plugingalaxy.com
 *	Skype : 'team.webgalli' or 'drsanupmoideen'
 *	@package Elgg-videos
 * 	Plugin info : Upload/ Embed videos. Save uploaded videos in youtube and save your bandwidth and server space
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */

gatekeeper();
$title = strip_tags(get_input('title'));
$description = get_input('description');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');
$share = get_input('share');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());
//set the action type to be embed in GPL Version. This will allow easier upgrade to commercial version
$action_type =  'embed';
$video_url = get_input('video_url');

$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);
$video_url = str_replace("http://", "https://", $video_url);



elgg_make_sticky_form('videos');


if (!$title || !$description || !$video_url) {
	register_error(elgg_echo('videos:save:failed'));
	forward(REFERER);
}

if ($guid == 0) {
		$video = new ElggObject;
		$video->subtype = "videos";
		$video->container_guid = (int)get_input('container_guid', $_SESSION['user']->guid);
		$video->variant = $action_type;
		$new = true;
	} else {
		$video = get_entity($guid);
		if (!$video->canEdit()) {
			system_message(elgg_echo('videos:save:failed'));
			forward(REFERRER);
		}
	}
	$tagarray = string_to_tag_array($tags);
	$video->title = $title;
	$video->description = $description;
	$video->access_id = $access_id;
	$video->tags = $tagarray;
	$video->video_url = $video_url;

if ($video->save()) {
	elgg_clear_sticky_form('videos');
	system_message(elgg_echo('videos:save:success'));
	//add to river only if new
	if ($new) {
		elgg_create_river_item(array(
                	'view' => 'river/object/videos/create',
                        'action_type' => 'create',
                        'subject_guid' => elgg_get_logged_in_user_guid(),
                        'object_guid' => $video->guid,
                         ));
	}
	forward($video->getURL());
} else {
	register_error(elgg_echo('videos:save:failed'));
	forward("videos");
}
