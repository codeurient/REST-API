<?php
$xml = '
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetBookByIdResponse>
      <Book>
        <title>Clean Code</title>
        <author>Robert C. Martin</author>
        <year>2008</year>
      </Book>
    </GetBookByIdResponse>
  </soap:Body>
</soap:Envelope>';

$doc = simplexml_load_string($xml);

// Əvvəlcə soap namespace içində Envelope və Body-ə giririk
$body = $doc->children("http://schemas.xmlsoap.org/soap/envelope/")->Body;

// Body içində namespace yoxdur, ona görə sadəcə children() deyirik
$response = $body->children()->GetBookByIdResponse;

// Response içində Book var
$book = $response->Book;

echo "Title: " . $book->title . '<br>';
echo "Author: " . $book->author . '<br>';
echo "Year: " . $book->year . '<br>';
