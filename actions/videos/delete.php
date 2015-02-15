<?php
/**
 * Delete a video
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

$guid = get_input('guid');
$video = get_entity($guid);

if (elgg_instanceof($video, 'object', 'videos') && $video->canEdit()) {
	$container = $video->getContainerEntity();
	if ($video->delete()) {
		system_message(elgg_echo("videos:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("videos/group/$container->guid/owner");
		} else {
			forward("videos/owner/$container->username");
		}
	}
}

register_error(elgg_echo("videos:delete:failed"));
forward(REFERER);
