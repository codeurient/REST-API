<?php
$xml = simplexml_load_file("kitabxana.xml");

foreach ($xml->kitab as $kitab) {
    echo "Kitab adi: " . $kitab->ad . "\n";
}
?>