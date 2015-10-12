<?php
/**
 * Elgg video view
 *	Licence : GNU2
 *	Copyright : 
 */
elgg_load_library('elgg:videos:embed');

$mobile = detectmobile();

$full = elgg_extract('full_view', $vars, FALSE);
$video = elgg_extract('entity', $vars, FALSE);

if (!$video) {
	return;
}

$owner = $video->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $video->getContainerEntity();
$categories = elgg_view('output/categories', $vars);


$video_url = $video->video_url;
$video_id = $video->youtube_id;

$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);

$description = elgg_view('output/longtext', array('value' => $video->description, 'class' => 'pbl'));
$owner_link = elgg_view('output/url', array(
	'href' => "videos/owner/{$owner->username}",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $video->tags));
$date = elgg_view_friendly_time($video->time_created);

$comments_count = $video->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $video->getURL() . '#comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'videos',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $categories $comments_link";

if (elgg_is_active_plugin('elggx_fivestar')) {
    $subtitle .= elgg_view('elggx_fivestar/voting', array('entity'=> $vars['entity'], 'min' => true));
}


// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {
	$header = elgg_view_title($video->title);

	$params = array(
		'entity' => $video,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	$video_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$video_info
HTML;
?>

<div class="video elgg-content mts">
	<div style="margin-left:10px;">
	<?php 
        if($mobile) {
        	echo videoembed_create_embed_object($video_url, $video->guid,280);
        }else{
        	echo videoembed_create_embed_object($video_url, $video->guid,700);
        }
	?>
	<br>
	<?php echo '<span itemprop="description">'. $description . '</span>'; ?>
	</div>
</div>
<?php
} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
	<div class="videos-gallery-item">
	<h3>$video->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
	// brief view
	$excerpt = elgg_get_excerpt($video->description);
	if ($excerpt) {
		$excerpt = "$excerpt";
	}
	$video_icon = videoembed_create_embed_object($video_url, $video->guid,450); 

	$content = "$excerpt";

	$params = array(
		'text' => $video->title,
		'href' => 'videos/view/' . $video->guid,
		'is_trusted' => true,
	);
	$title_link = myvox_view('output/url', $params);

	$params = array(
		'entity' => $video,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content,
		'title' => $title_link,
	);

	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	if ($mobile == true || (elgg_get_context() == widgets)){
		$video_icon = videoembed_create_embed_object($video_url, $video->guid,280);
		echo elgg_view_image_block($video_icon,"");
		echo elgg_view_image_block($list_body,"");
	}else { 
		echo elgg_view_image_block($video_icon, $list_body);
	}	
}
