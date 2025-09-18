<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once('../core/initialize.php');
$post = new Post($db);

// Sorğudan göndərilən HTTP metodunu götürürük: GET, POST, PUT, PATCH, DELETE yaxud OPTIONS. 
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Tək post
            $post->id = $_GET['id'];
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
        } else {
            // Hamısı
            $result = $post->read();
            $num = $result->rowCount();

            if($num > 0) {
                $post_arr = array();
                $post_arr['data'] = array();

                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $post_item = array(
                        'id'     => $id,
                        'title'  => $title,
                        'body'   => html_entity_decode($body),
                        'author' => $author,
                        'category_id'   => $category_id,
                        'category_name' => $category_name,
                    );
                    
                    array_push($post_arr['data'], $post_item);
                }
                echo json_encode($post_arr);
            } else {
                echo json_encode(array('message' => 'No posts found.'));
            }
        }
        break;
        

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $post->title        = $data->title;
        $post->body         = $data->body;
        $post->author       = $data->author;
        $post->category_id  = $data->category_id;

        if($post->create()) {
            echo json_encode(
                array('message' => 'Post created.')
            );
        } else {
        echo json_encode(
                array('message' => 'Post not created.')
            );
        }
        break;

    case 'PUT':
    case 'PATCH':
        $data = json_decode(file_get_contents("php://input"));

        $post->id           = $_GET['id']           ?? null;
        $post->title        = $data->title          ?? null;
        $post->body         = $data->body           ?? null;
        $post->author       = $data->author         ?? null;
        $post->category_id  = $data->category_id    ?? null;

        if ($post->update()) {
            echo json_encode(['message' => 'Post updated']);
        } else {
            echo json_encode(['message' => 'Post not updated']);
        }
        break;

    case 'DELETE':
        $post->id = $_GET['id'] ?? null;

        if($post->delete()) {
            echo json_encode(
                array('message' => 'Post deleted.')
            );
        } else {
        echo json_encode(
                array('message' => 'Post not deleted.')
            );
        }
        break;

    case 'OPTIONS':
        http_response_code(200);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
