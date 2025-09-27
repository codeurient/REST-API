<?php
$connect = mysqli_connect('localhost', 'root', '', 'api_tester');

function getPosts($connect) {
    $posts = mysqli_query($connect, "SELECT * FROM `posts`");
    $postsList = [];

    while ($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
    }

    // 1) JSON formatında ekrana göstər
    echo "<h3>JSON formatı:</h3><pre>";
    echo json_encode($postsList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "</pre>";

    // 2) XML formatına çevir
    $xml = new SimpleXMLElement('<posts/>');

    foreach ($postsList as $post) {
        $postNode = $xml->addChild('post');
        $postNode->addChild('id', $post['id']);
        // htmlspecialchars() qoyuruq ki, < > & kimi simvollar XML-i pozmasın
        $postNode->addChild('title', htmlspecialchars($post['title']));
        $postNode->addChild('body', htmlspecialchars($post['body']));
    }

    // Fayla yaz və qovluqda save et. (C:\laragon\www\REST-API\posts.xml kimi olacaq)
    $xml->asXML(__DIR__ . "/posts.xml");

    echo "<h3>XML faylı yaradıldı:</h3>";
    echo "<a href='posts.xml' target='_blank'>posts.xml faylını aç</a>";
}

getPosts($connect);
