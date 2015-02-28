<?php
$site_name = elgg_get_site_entity()->name;

if ($_GET['q'] && $_GET['maxResults']) {
  
   //Maximize the number of results whatever a user enters in the URL
	if ($_GET['maxResults'] > "10") {
		$_GET['maxResults'] = "10";
	}

  // Call set_include_path() as needed to point to your client library.
    require_once(elgg_get_plugins_path() . "videos/vendors/google/Google_Client.php");
    require_once(elgg_get_plugins_path() . "videos/vendors/google/contrib/Google_YouTubeService.php");

  /* Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
  Google APIs Console <http://code.google.com/apis/console#access>
  Please ensure that you have enabled the YouTube Data API for your project. */
  $DEVELOPER_KEY = elgg_get_plugin_setting('developer_key', 'videos');

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  $youtube = new Google_YoutubeService($client);

  try {
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $_GET['q'],
      'maxResults' => $_GET['maxResults'],
	  'safeSearch' => 'strict',
    ));

    $videos = '';
    $channels = '';
    $playlists = '';

    foreach ($searchResponse['items'] as $searchResult) {
	
	$title = $searchResult['snippet']['title'];	
	$title = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9\_|+.-]/', ' ', urldecode(html_entity_decode(strip_tags($title))))));
	$desc = $searchResult['snippet']['description'];
	$desc = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9\_|+.-]/', ' ', urldecode(html_entity_decode(strip_tags($desc))))));
	$video_url = "https://www.youtube.com/watch?v=" . $searchResult['id']['videoId'];	
	
	
	if(elgg_is_logged_in()) {
	
      switch ($searchResult['id']['kind']) {
      case 'youtube#video':
	  $videos .= "</br><a href='/videos/add/$user->guid?title=$title&desc=$desc&video_url=$video_url'>Add this video:</a> ". $searchResult['snippet']['title'];
      $videos .= "</br>";
	  $videos .=  "<iframe width='450' height='320' src='https://www.youtube.com/embed/";
      $videos .= $searchResult['id']['videoId'];  
	  $videos .= "' frameborder='0'></iframe>";
	  $videos .= "</br>";
	  $videos .= $searchResult['snippet']['title'];
	  $videos .= "</a></br>";
	  
      break;
      }
    }else{
	
	  switch ($searchResult['id']['kind']) {
      case 'youtube#video':
	  $videos .= "</br>";
	  $videos .= $searchResult['snippet']['title'];
	  $videos .=  "<iframe width='200' height='150' src='https://www.youtube.com/embed/";
      $videos .= $searchResult['id']['videoId'];  
	  $videos .= "' frameborder='0'></iframe>";
	  $videos .= "</a></br>";
      break;
      }
	  }
	  }
	  

  } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('videos'), 'videos/featured');

elgg_register_title_button();

$offset = (int)get_input('offset', 0);
$content = $videos;

$title = elgg_echo('videos:youtube');

$body = elgg_view_layout('content', array(
        'filter_context' => 'all',
        'content' => $content,
        'title' => $title,
        'filter_override' => elgg_view('videos/nav', array('selected' => $vars['page'])),
        'sidebar' => elgg_view('videos/sidebar'),
));

echo elgg_view_page($title, $body);


