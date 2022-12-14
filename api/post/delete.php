<?php
// HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

 // Set the id to be DELETED.
 $post->id = $data->id;

 // Delete a post
 if($post->destroy()){
     echo json_encode(
         array('message' => 'Post Deleted')
     );
 } else {
     echo json_encode(
        array('message' => 'Post Not Deleted')
     );    
 }