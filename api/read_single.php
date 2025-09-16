<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: aaplication/json');

include_once('../core/initialize.php');

$post = new Post($db);

$post->id = isset( $_GET['id'] )  ?  $_GET['id']  :  die();

$post->read_single();



  

  

$post_arr = array(
    'id'     => $post->id,
    'title'  => $post->title,
    'body'   => html_entity_decode($post->body),
    'author' => $post->author,
    'category_id'   => $post->category_id,
    'category_name' => $post->category_name,
);
    
print_r(json_encode($post_arr));