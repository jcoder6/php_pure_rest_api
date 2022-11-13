<?php
// HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Intantiate a Database and Connect With it.
$database = new Database();
$db = $database->connect();

//Instantiat a blog post object.
 $post = new Post($db);

 // Get the raw posted data.
 $data = json_decode(file_get_contents('php://input'));

 $post->title = $data->title;
 $post->author = $data->author;
 $post->body = $data->body;
 $post->category_id = $data->category_id;

 // Create a post
 if($post->create()){
     echo json_encode(
         array('message' => 'Post Created')
     );
 } else {
     echo json_encode(
        array('message' => 'Post Not Created')
     );    
 }