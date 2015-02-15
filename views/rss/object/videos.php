<?php
/**
 * Elgg video rss view
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

$title = $vars['entity']->title;
if (empty($title)) {
	$title = substr($vars['entity']->description,0,32);
	if (strlen($vars['entity']->description) > 32)
		$title .= " ...";
}

?>

<item>
  <guid isPermaLink='true'><?php echo $vars['entity']->getURL(); ?></guid>
  <pubDate><?php echo date("r",$vars['entity']->time_created) ?></pubDate>
  <link><?php echo $vars['entity']->getURL(); ?></link>
  <title><![CDATA[<?php echo $title; ?>]]></title>
  <description><![CDATA[<?php echo (elgg_autop($vars['entity']->description)); ?>]]></description>
</item>
