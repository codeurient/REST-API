<?php
// TCMB valyuta xml faylı
$url = "http://localhost/REST-API/posts.xml";

// XML-i yüklə
$xml = simplexml_load_file($url);

// XML-də bütün <post> elementlərini al. NOT: <Post> ilə <post> fərqlidir. 
$posts = $xml->post;

// ümumi post sayını öyrənək
$post = count($posts);



// for ilə bütün dəyərləri əldə edək.
for ($i = 0; $i < $post; $i++) {
        echo "id: "      . $posts[$i]->id       . "<br>";
        echo "Title: "   . $posts[$i]->title    . "<br>";
        echo "Body: "    . $posts[$i]->body     . "<br>";
        echo "............................. <br>";
}