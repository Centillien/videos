<?php
/**
 *      Author : Gerard Kanters
 *      @package Videos
 *	Licence : GNU2
 */

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => 'videos',
	'owner_guid' => elgg_get_page_owner_guid(),
));

