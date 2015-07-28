<?php 

$youtube = $vars['entity']->youtube;

echo "<div>";

echo elgg_echo('youtube:question1');

echo elgg_view('input/dropdown',array('name' => 'params[youtube]', 'options_values'=> array( '0' => '  ', '1'=>'Yes','2'=>'No'),'value'=> $youtube));

echo "</div><br><br><div>";

$search_contexts = $vars['entity']->search_contexts;

echo elgg_echo('youtube:question2');

echo elgg_view('input/text', array('name'=>'params[search_contexts]', 'value'=> $search_contexts));

echo "</div>";

echo "</div><br><br><div>";

$developer_key = $vars['entity']->developer_key;

echo elgg_echo('youtube:question3');

echo elgg_view('input/text', array('name'=>'params[developer_key]', 'value'=> $developer_key));

echo "</div><br><br><div>";

$client_id = $vars['entity']->client_id;

echo elgg_echo('youtube:question4');

echo elgg_view('input/text', array('name'=>'params[client_id]', 'value'=> $client_id));

echo "</div><br><br><div>";

$client_secret = $vars['entity']->client_secret;

echo elgg_echo('youtube:question5');

echo elgg_view('input/text', array('name'=>'params[client_secret]', 'value'=> $client_secret));

echo "</div>";

