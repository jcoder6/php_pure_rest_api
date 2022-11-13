<?php
// HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Intantiate a Database and Connect With it.
$database = new Database();
$db = $database->connect();

//Instantiat a blog post object.
 $post = new Post($db);

 //Get ID
 $post->id = isset($_GET['id']) ? $_GET['id'] : die();

 //Get Post Single
 $post->read_single();

 //Create an Array 
 $post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'author' => $post->author,
    'body' => $post->body,
    'category_name' => $post->category_name,
    'category_id' => $post->category_id
 );

 // Make Json
 print_r(json_encode($post_arr));