<?php
/**
 * View a video
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
$video = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "videos/group/$page_owner->guid/owner");
} else {
	elgg_push_breadcrumb($crumbs_title, "videos/owner/$page_owner->username");
}

$title = $video->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($video, array('full_view' => true));
$content .= elgg_view_comments($video);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	//'filter' => '',
	'header' => '',
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
));

echo elgg_view_page($title, $body);
