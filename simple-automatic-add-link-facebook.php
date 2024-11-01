<?php

/*
Plugin Name: simple automatic add link facebook
Plugin URI: http:///wordpress-plugins.damses.com
Description: This plugin automatic tell facebook what title, description and image must show when you add an url in the timeline, it is not need a configuration
Version: 1.0
Author: David Alcaraz Moreno
Author URI: http://damses.com
License: GPLv2 or later
*/
class Facebook_Show_My_Data {

    public function __construct() {
        define('FACEBOOK_DESCRIPTION_MAX_LENGH', 600);
        add_action('wp_head', array($this,'tell_facebook'));
    }
    
    public function tell_facebook(){
        $id = get_the_ID();
        $post=get_post($id);        
        $this->setSite();
        $this->setTitle($post->post_title);
        $this->setDescription($post->post_content);
        $this->setType();
        $this->setImage($id);
        $this->setUrl();
                
        
        
    }
    public function setTitle($title){
        echo '<meta property="og:title" content="'.$title.'" />';
    }
    
    public function setDescription($description){
        $description = strip_tags(strip_shortcodes($description));
        $description = trim(substr($description, 0, FACEBOOK_DESCRIPTION_MAX_LENGH)).'...';
        echo '<meta property="og:description" content="'.$description.'" />';
    }
    
    public function setSite(){
        echo '<meta property="og:site_name" content="'.get_bloginfo( 'name' ).'"/>';
    }
    public function setImage($id){
        $meta = get_post_meta ($id, '_thumbnail_id', true);
        if($meta){
            $post=get_post($meta); 
            if($post){
                echo '<meta property="og:image" content="'.$post->guid.'" />';
            }
        }
        
    }
    public function setType(){
        echo '<meta property="og:type" content="article" />';
    }
    public function setUrl(){
        echo '<meta property="og:url" content="'.home_url(add_query_arg(array())).'" />';
    }
    
}
return new Facebook_Show_My_Data();