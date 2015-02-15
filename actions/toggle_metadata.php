<?php

        gatekeeper();

        $guid = (int) get_input("guid");
        $metadata = get_input("metadata");
	
	$video = get_entity($guid);

        if(!empty($guid) && !empty($metadata)){
                if(($entity = get_entity($guid)) && $entity->canEdit()){
                        if(elgg_instanceof($entity, "object", "videos")){
			   if(elgg_is_admin_logged_in()){
                                $old = $entity->$metadata;

                                if(empty($entity->$metadata)){
                                        $entity->$metadata = true;
                                } else {
                                        unset($entity->$metadata);
                                }

                                if($old != $entity->$metadata){
                                        system_message(elgg_echo("videos:action:toggle_metadata:success"));
                                } else {
                                        register_error(elgg_echo("videos:action:toggle_metadata:error"));
                                }
                        } else {
                                register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "Videos")));
                        }
                } else {
                        //register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
                        register_error(elgg_echo("professional:onlyowncontent", array($guid)));
                }
        } else {
                register_error(elgg_echo("InvalidParameterException:MissingParameter"));
        }
}
        forward(REFERER);

