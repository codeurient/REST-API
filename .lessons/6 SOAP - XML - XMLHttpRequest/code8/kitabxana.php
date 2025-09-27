<?php
// XML faylını DOM ilə yükləyirik
$doc = new DOMDocument();
$doc->load("kitabxana.xml");

// "kitab" elementlərini alırıq
$kitablar = $doc->getElementsByTagName("kitab");

foreach ($kitablar as $kitab) {
    // "ad" elementini tapırıq
    $ads = $kitab->getElementsByTagName("ad");
    if ($ads->length > 0) {
        $ad = $ads->item(0)->nodeValue;
        echo "Kitab adi: " . $ad . "\n";
    }
}