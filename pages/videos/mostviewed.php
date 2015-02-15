<?php
/**
 * Elgg videos plugin everyone page
 *	Licence : GNU2
 */

elgg_push_breadcrumb(elgg_echo('videos:mostviewed'));

elgg_register_title_button();

$offset = (int)get_input('offset', 0);


$options = array(
        'types' => 'object',
        'subtypes' => 'videos',
        'limit' => 10,
        'annotation_names' => array('views_counter'),
        'calculation' => 'sum',
        'order_by' => 'annotation_calculation desc',
        'full_view' => false,
);


$content = elgg_list_entities_from_annotation_calculation($options);

$title = elgg_echo('videos:mostviewed');

$body = elgg_view_layout('content', array(
	'filter_context' => 'Most Viewed',
	'content' => $content,
	'title' => $title,
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
	'sidebar' => elgg_view('videos/sidebar'),
));

echo elgg_view_page($title, $body);
