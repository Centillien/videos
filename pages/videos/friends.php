<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($owner->name, "videos/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('videos:friends');

$content = list_user_friends_objects($owner->guid, 'videos', 10, false);

if (!$content) {
	$content = elgg_echo('videos:none');
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
