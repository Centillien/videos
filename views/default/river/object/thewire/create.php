<?php
/**
 * Youtube viewer 
 */

$object = $vars['item']->getObjectEntity();
		$youtube = elgg_get_plugin_setting('youtube', 'videos'); 
if ($youtube == 1)
{
		
$excerpt = strip_tags($object->description);
$excerpt = str_replace("feature=player_embedded&amp;", "", $excerpt);
$excerpt = str_replace("feature=player_detailpage&amp;", "", $excerpt);
$excerpt = str_replace("http:","https:",$excerpt);

$parse = parse_url($excerpt);


$excerpt =  preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width='300' height='250' src='https://www.youtube.com/embed/$1' frameborder='0'></iframe>",$excerpt);
$excerpt = thewire_filter($excerpt);



if ($parse['host'] == 'www.vimeo.com')
            {
            $excerpt =  preg_replace('#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i', '<object width="auto" height="auto"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="https://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="https://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object>', $excerpt);
            }

			else if ($parse['host'] == 'vimeo.com')
            {

            $excerpt =  preg_replace('#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i', '<object width="auto" height="auto"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="https://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="https://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object>',$excerpt);
            }
}
else
{
    $excerpt = strip_tags($object->description);
	$excerpt = thewire_filter($excerpt);
    
}


$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$subject->username",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'summary' => $summary,
));
