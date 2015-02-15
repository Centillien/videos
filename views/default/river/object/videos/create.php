<?php
/**
 * New videos river entry
 *	Licence : GNU2
 */
elgg_load_library('elgg:videos:embed');

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

$video_url = $object->video_url;

$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);
$video_url = str_replace("http://youtu.be","https://www.youtube.be",$video_url);



$guid = $object->guid;
/*
$params = array(
	'href' => $object->getURL(),
	'text' => $object->title,
);
$link = elgg_view('output/url', $params);

$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup) {
	$params = array(
		'href' => $container->getURL(),
		'text' => $container->name,
	);
	$group_link = elgg_view('output/url', $params);
	$group_string = elgg_echo('river:ingroup', array($group_link));
}

$link = elgg_echo('videos:river:created', array($link));

echo " $link $group_string";


if ($excerpt) {
	echo '<div class="elgg-river-content">';
	echo "<div style='width: 160px;float:left; '>";
	echo videoembed_create_embed_object($video_url, $guid,300); 
	echo "</div>";
	echo "<div style='margin:-100px 0 0 200px;float:left;width:500px;'>";
	echo $excerpt;
	echo '</div>';
	echo '</div>';
}
*/

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => videoembed_create_embed_object($video_url, $guid,300),
));
