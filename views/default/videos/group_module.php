<?php
/**
 * List most recent videos on group profile page
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

$group = elgg_get_page_owner_entity();

if ($group->videos_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "videos/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'videos',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('videos:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "videos/add/$group->guid",
	'text' => elgg_echo('videos:add'),
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('videos:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
