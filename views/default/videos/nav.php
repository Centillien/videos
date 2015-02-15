<?php
/**
 * Videos navigation
 */
if(!elgg_is_logged_in()){
$tabs = array(
         'all' => array(
                'title' => elgg_echo('all'),
                'url' => "videos/all",
         ),
         'featured' => array(
                'title' => elgg_echo('videos:featured'),
                'url' => "videos/featured",
         ),
         'mostviewed' => array(
                'title' => elgg_echo('videos:mostviewed'),
                'url' => "videos/mostviewed",
         ),
         'playlist' => array(
                'title' => elgg_echo('youtube:playlist:tab'),
                'url' => "videos/playlist",
         ),
   );

}else{

$user = elgg_get_logged_in_user_entity();

$tabs = array(
         'all' => array(
                'title' => elgg_echo('all'),
                'url' => "videos/all",
         ),
	'mine' => array(
                'title' => elgg_echo('mine'),
                'url' => "videos/owner/{$user->username}",
                ),
	'friends'  => array(
                'title' => elgg_echo('friends'),
                'url' => "videos/friends/{$user->username}",
                ),
        'featured' => array(
                'title' => elgg_echo('videos:featured'),
                'url' => "videos/featured",
         ),
         'mostviewed' => array(
                'title' => elgg_echo('videos:mostviewed'),
                'url' => "videos/mostviewed",
         ),
         'playlist' => array(
                'title' => elgg_echo('youtube:playlist:tab'),
                'url' => "videos/playlist",
         ),
   );
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
