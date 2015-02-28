<?php
/**
 * Elgg videos plugin
 *	@package Elgg-videos
 */


elgg_register_event_handler('init', 'system', 'videos_init');
/**
 * video init
 */
function videos_init() {

        // add a site navigation item
        $item = new ElggMenuItem('video', elgg_echo('videos'), 'videos/all');
        elgg_register_menu_item('site', $item);

	elgg_register_library('elgg:videos', elgg_get_plugins_path() . 'videos/lib/videos.php');

	elgg_register_library('elgg:videos:embed', elgg_get_plugins_path() . 'videos/lib/embed_video.php');
	elgg_register_library('elgg:youtube_api', elgg_get_plugins_path() . 'videos/lib/youtube_functions.php');
	$action_path =  elgg_get_plugins_path() ."videos/actions/videos";
	elgg_register_action('videos/save', "$action_path/save.php");
	elgg_register_action('videos/delete', "$action_path/delete.php");



	//extend owner block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'videos_owner_block_menu');

	//Add menu's in sidebar
	elgg_register_plugin_hook_handler('register', 'menu:page', 'videos_page_menu');
	
	$context =  elgg_get_context();
	$contexts = elgg_get_plugin_setting('search_contexts','videos');
	$contexts = explode(",", $contexts);
	
        if(in_array($context, $contexts))  {
        elgg_extend_view('page/elements/sidebar', 'page/elements/search','400');
        }

	 // get items in video menu
        elgg_register_plugin_hook_handler("register", "menu:entity", "videos_entity_menu_setup");
	
	 // register actions
        elgg_register_action("videos/toggle_metadata", dirname(__FILE__) . "/actions/toggle_metadata.php");
	
	elgg_register_page_handler('videos', 'videos_page_handler');
	elgg_extend_view('css/elgg', 'videos/css');
	elgg_register_widget_type('videos', elgg_echo('videos'), elgg_echo('videos:widget:description'));

        if (function_exists('elgg_get_version(true)')) {
                elgg_register_notification_event('object', 'videos');
        } else {
                register_notification_object('object', 'videos', elgg_echo('videos:new'));
        }

	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'videos_notify_message');

        // Register a URL handler for video posts
        elgg_register_plugin_hook_handler('entity:url', 'object', 'videos_url_handler');

	elgg_register_entity_type('object', 'videos');
	add_group_tool_option('videos', elgg_echo('videos:enablevideos'), true);
	elgg_extend_view('groups/tool_latest', 'videos/group_module');
	$views = array('output/longtext','output/plaintext');
	foreach($views as $view){
		elgg_register_plugin_hook_handler("view", $view, "videos_view_filter", 500);
	}	
}


/**
 * Process the Elgg views for a matching video URL
*/
function videos_view_filter($hook, $entity_type, $returnvalue, $params){
	elgg_load_library('elgg:videos:embed');
	$patterns = array(	'#(((https?://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i',
						'#(((https?://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i',
						'/(https?:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/',
						'/(https?:\/\/)(www\.)?(metacafe\.com\/watch\/)([0-9a-zA-Z_-]*)(\/[0-9a-zA-Z_-]*)(\/)/',
						'/(https?:\/\/www\.dailymotion\.com\/.*\/)([0-9a-z]*)/',
						);
	$regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
	if(preg_match_all($regex, $returnvalue, $matches, PREG_SET_ORDER)){
 		foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$returnvalue = str_replace($match[0], videoembed_create_embed_object($match[2], uniqid('videos_embed_'), 350), $returnvalue);
				}				
			}
		}
	}
	return $returnvalue;
}	
/**
 * Dispatcher for videos.
 * URLs take the form of
 *  All videos:        videos/all
 *  User's videos:     videos/owner/<username>
 *  Friends' videos:   videos/friends/<username>
 *  View video:        videos/view/<guid>/<title>
 *  New video:         videos/add/<guid> (container: user, group, parent)
 *  Edit video:        videos/edit/<guid>
 *  Group videos:      videos/group/<guid>/owner
 * Title is ignored
 * @param array $page
 */
function videos_page_handler($page) {
	elgg_load_library('elgg:videos');
	elgg_push_breadcrumb(elgg_echo('videos'), 'videos/mostviewed');
	elgg_push_context('videos');
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		if ($entity = get_entity($guid)) {
			videos_url_forwarder($page);
		}
	}
	$user = get_user_by_username($page[0]);
	if ($user) {
		videos_url_forwarder($page);
	}
	$pages = dirname(__FILE__) . '/pages/videos';
	switch ($page[0]) {
		case "all":
			include "$pages/all.php";
			break;
		case "owner":
			include "$pages/owner.php";
			break;
		case "friends":
			include "$pages/friends.php";
			break;
		 case "playlist":
             		include "$pages/playlist.php";
        		break;
		case "read":
		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;
		case "add":
			gatekeeper();
			include "$pages/add.php";
			break;
		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;
		case 'featured':
			include "$pages/featured.php";
                        break;
                case 'youtube':
                        include "$pages/youtube.php";
                        break;
		case 'mostviewed':
			include "$pages/mostviewed.php";
                        break;
		case 'popular':
                        file_register_toggle();
                        include "$pages/popular.php";
                        break;
		case 'group':
			group_gatekeeper();
			include "$pages/owner.php";
			break;
		default:
			return false;
	}
	elgg_pop_context();
	return true;
}
/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
function videos_url_forwarder($page) {
	global $CONFIG;
	if (!isset($page[1])) {
		$page[1] = 'items';
	}
	switch ($page[1]) {
		case "read":
			$url = "{$CONFIG->wwwroot}videos/view/{$page[2]}/{$page[3]}";
			break;
		case "inbox":
			$url = "{$CONFIG->wwwroot}videos/inbox/{$page[0]}";
			break;
		case "friends":
			$url = "{$CONFIG->wwwroot}videos/friends/{$page[0]}";
			break;
		case "add":
			$url = "{$CONFIG->wwwroot}videos/add/{$page[0]}";
			break;
		case "items":
			$url = "{$CONFIG->wwwroot}videos/owner/{$page[0]}";
			break;
	}
	register_error(elgg_echo("changebookmark"));
	forward($url);
}

/**
 * Returns the URL from a video entity
 *
 * @param string $hook   'entity:url'
 * @param string $type   'object'
 * @param string $url    The current URL
 * @param array  $params Hook parameters
 * @return string
 */
function videos_url_handler($hook, $type, $url, $params) {
    $entity = $params['entity'];

    // Check that the entity is a video object
    if ($entity->getSubtype() !== 'videos') {
        // This is not a video object, so there's no need to go further
        return;
    }

    return "videos/view/{$entity->guid}/". elgg_get_friendly_title($entity->title);
}


/**
 * Add a menu item to an ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function videos_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "videos/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('videos', elgg_echo('videos'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->videos_enable != 'no') {
			$url = "videos/group/{$params['entity']->guid}/owner";
			$item = new ElggMenuItem('videos', elgg_echo('videos:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}

/**
 * Returns the body of a notification message
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function videos_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'videos')) {
		$descr = $entity->description;
		$title = $entity->title;
		global $CONFIG;
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		if ($method == 'sms') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $url . ' (' . $title . ')';
		}
		if ($method == 'email') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
		if ($method == 'web') {
			$owner = $entity->getOwnerEntity();
			return $owner->name . ' ' . elgg_echo("videos:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
	}
	return null;
}

function videos_page_menu($hook, $type, $return, $params) {
        // only show buttons in videos pages. Changed to videos1 to remove all menus
        //if (elgg_in_context('videos')) {
        if (elgg_in_context('videos1')) {
             if (elgg_is_logged_in()) {
                        $user = elgg_get_logged_in_user_entity();
                        $page_owner = elgg_get_page_owner_entity();
                        if (!$page_owner) {
                                $page_owner = elgg_get_logged_in_user_entity();
                        }

                        if ($page_owner != $user) {
                                $usertitle = elgg_echo('videos:user', array($page_owner->name));
                                $return[] = new ElggMenuItem('1user', $usertitle, 'videos/owner/' . $page_owner->username);
                                $friendstitle = elgg_echo('videos:friends', array($page_owner->name));
                                $return[] = new ElggMenuItem('2userfriends', $friendstitle, 'videos/friends/' . $page_owner->username);
                        }

                        $return[] = new ElggMenuItem('1mostviewed', elgg_echo('videos:mostviewed'), 'videos/mostviewed');
                        $return[] = new ElggMenuItem('2featured', elgg_echo('videos:featured'), 'videos/featured');
                        $return[] = new ElggMenuItem('3mine', elgg_echo('videos:mine'), 'videos/owner/' . $user->username);
                        $return[] = new ElggMenuItem('4friends', elgg_echo('videos:friends'), 'videos/friends/' . $user->username);
                 	$return[] = new ElggMenuItem('5all', elgg_echo('videos:everyone'), 'videos/all');

                  }else{
		//$return[] = new ElggMenuItem('1mostviewed', elgg_echo('videos:mostviewed'), 'videos/mostviewed');
                //$return[] = new ElggMenuItem('2featured', elgg_echo('videos:featured'), 'videos/featured');
            }
        return $return;
        }
}

function videos_entity_menu_setup($hook, $entity_type, $returnvalue, $params){
                $result = $returnvalue;
		
		if (elgg_in_context("widgets")) {
                        return $result;
                }


if(!empty($params) && is_array($params)){
			 $page_owner = elgg_get_page_owner_entity();
                        if(($entity = elgg_extract("entity", $params)) && elgg_instanceof($entity, "object", "videos")){
                                if(elgg_is_admin_logged_in()){

                                        // feature link
                                        if(!empty($entity->featured)){
                                                $text = elgg_echo("videos:toggle:unfeature");
                                        } else {
                                                $text = elgg_echo("videos:toggle:feature");
                                        }

                                        $options = array(
                                                "name" => "featured",
                                                "text" => $text,
                                                "href" => elgg_get_site_url() . "action/videos/toggle_metadata?guid=" . $entity->guid . "&metadata=featured",
                                                "is_action" => true,
                                                "priority" => 175
                                        );

                                        $result[] = ElggMenuItem::factory($options);
					
                                }
                        }
                }

                return $result;
}


