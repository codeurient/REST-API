<?php

require 'connect.php';

$posts = mysqli_query($connect, "SELECT * FROM `posts`");

print_r($posts);