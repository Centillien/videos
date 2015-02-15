<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *      Licence : GNU2
 */

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('videos:add');
elgg_push_breadcrumb($title);
// create form
$form_vars = array();

$vars = videos_prepare_form_vars();
$content = elgg_view_form('videos/save', $form_vars, $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
