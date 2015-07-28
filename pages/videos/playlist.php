<?php

// Call set_include_path() as needed to point to your client library.

    include_once(elgg_get_plugins_path() . "videos/vendors/google/Google_Client.php");
    include_once(elgg_get_plugins_path() . "videos/vendors/google/contrib/Google_YouTubeService.php");

$user = elgg_get_logged_in_user_entity();

$OAUTH2_CLIENT_ID = elgg_get_plugin_setting('client_id', 'videos');
$OAUTH2_CLIENT_SECRET = elgg_get_plugin_setting('client_secret', 'videos');


$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$redirect = elgg_get_site_url() . 'videos/playlist';
$client->setRedirectUri($redirect);
$site_name = elgg_get_site_entity()->name; 

$youtube = new Google_YoutubeService($client);

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  try {
    $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
      'mine' => 'true',
    ));

    $htmlBody = '';
    foreach ($channelsResponse['items'] as $channel) {
      $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];

      $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
        'playlistId' => $uploadsListId,
        'maxResults' => 10
      ));

      $htmlBody .= "<h3>Your uploaded videos on Youtube usable on '. $site_name . ' for user: <strong>$user->name </strong></h3><ul><br><br>";
	 
      foreach ($playlistItemsResponse['items'] as $playlistItem) {
	
	elgg_load_js('addthis_widget');
	$title = $playlistItem['snippet']['title'];	
	$desc =  urldecode(html_entity_decode(strip_tags($playlistItem['snippet']['description'])));
	$video_url = "https://www.youtube.com/watch?v=" . $playlistItem['snippet']['resourceId']['videoId'];	
	$tags = $playlistItem['snippet']['tags'];

	if(elgg_is_logged_in()) {
	$htmlBody .= 'You are logged in as <strong>'. $user->name .'</strong>, choose a video and click on "Add this video" to share on $site_name<br><br>';
	$htmlBody .= "<strong>Title: </strong>";
	$htmlBody .= $playlistItem['snippet']['title'];	
	$htmlBody .= "</br><strong>Add this video: </strong><a href='/videos/add/$user->guid?title=$title&description=$desc&video_url=$video_url'>";
	$htmlBody .= "https://www.youtube.com/watch?v=";
	$htmlBody .= $playlistItem['snippet']['resourceId']['videoId'];	
	$htmlBody .= "</a></br><br><strong>Description: </strong>";
	$htmlBody .= $playlistItem['snippet']['description'];	
	$htmlBody .= "</br><br>";
	$htmlBody .= "<iframe width='425' height='350' src='https://www.youtube.com/embed/";
	$htmlBody .= $playlistItem['snippet']['resourceId']['videoId'];
	$htmlBody .= "' frameborder='0'></iframe>";
	$htmlBody .= "</br>";
    $htmlBody .='<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="right:10px;top:220px;">
	<a class="addthis_button_linkedin_counter" li:counter="top"></a>
	<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
	<a class="addthis_button_tweet" tw:count="vertical"></a>
	<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
	</div>
	<!-- AddThis Button END -->';
	}else{
	$htmlBody .= "You you are no logged in, and therefore cannot add videos from your playlist. <a href= '/login' title='Login'>Login</a> or <a href= '/register' title='Register'>register</a> first<br><br>";
	$htmlBody .= "<strong>Title: </strong>";
	$htmlBody .= $playlistItem['snippet']['title'];	
	$htmlBody .= "</a></br><br><strong>Description: </strong>";
	$htmlBody .= $playlistItem['snippet']['description'];	
	$htmlBody .= "</br><br>";
	$htmlBody .= "<iframe width='425' height='350' src='https://www.youtube.com/embed/";
	$htmlBody .= $playlistItem['snippet']['resourceId']['videoId'];
	$htmlBody .= "' frameborder='0'></iframe>";
	$htmlBody .= "</br>";
    $htmlBody .='<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="right:10px;top:220px;">
	<a class="addthis_button_linkedin_counter" li:counter="top"></a>
	<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
	<a class="addthis_button_tweet" tw:count="vertical"></a>
	<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
	</div>
	<!-- AddThis Button END -->';
	}


      }
      $htmlBody .= '</ul>';
    }
  } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }

  $_SESSION['token'] = $client->getAccessToken();
 } else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();

   $htmlBody .= '<br><br><h3><strong>Authorization required</strong></h3>';
   $htmlBody .= '<br><p><a href="'. $authUrl .'" title="Click to retrieve your videos from Youtube"><img alt="Authenticate to Youtube" src="/mod/videos/graphics/youtube.jpg" width="32" style="border-width: 0px"></a> <a href="'. $authUrl .'" title="Click to retrieve your videos from Youtube">Click</a> on the button to allow '. $site_name . ' access to your Youtube playlist .<p>';
   $htmlBody .= '<strong>Privacy:</strong> We will not create an account and do not use your account to publish on Youtube, only to retrieve your videos and show them in this page. The videos will not be saved. This page is for fun and to help you select which video you want to share<br><br>';
   $htmlBody .= "Watch the video below to see what Youtube is and how to upload videos. If no videos are uploaded to Youtube, you won't see anything.";
   if(elgg_is_logged_in()) {
   $htmlBody .= " <br><br>You are logged in as <strong>$user->name</strong> right now, so you can upload videos directly using <a href= '/file/owner/$user->name' title='Video files'>files</a>. <br><br>";
   }else{
   $htmlBody .= " <br><br><strong>You are not logged in</strong> right now. You need to <a href= '/login' title='Login'>login</a> or <a href= '/register' title='Register a business account'>register</a> to upload videos directly to '. $site_name . '. You don't need Youtube for that.<br><br>";
   }	
   
}

$title = elgg_echo('youtube:playlist');

elgg_register_title_button();

$body = elgg_view_layout('content', array(
        'content' => $htmlBody,
        'title' => $title,
        'sidebar' => elgg_view('videos/sidebar'),
	'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
));

echo elgg_view_page($title, $body);

?>

