<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
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
