<?php
/**
 * Elgg videos plugin everyone page
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

$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($page_owner->name);

elgg_register_title_button();

$title = elgg_echo('videos:owner', array($page_owner->name));

$offset = (int)get_input('offset', 0);
$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'videos',
	'container_guid' => $page_owner->guid,
	'limit' => 20,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false
));

if (!$content) {
	$title = elgg_echo('videos:owner:none', array($page_owner->name));
	$content = elgg_echo('videos:none');
}


$filter_context = '';
if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
	'sidebar' => elgg_view('videos/sidebar'),
);

// don't show filter if out of filter context
if ($page_owner instanceof ElggGroup) {
	$vars['filter'] = false;
}

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);
