<?php
// Callback funksiyalar
function startElement($parser, $name, $attrs) {
    echo "<pre>";
        echo "Start element: $name\n";
    echo "</pre>";
}

function endElement($parser, $name) {
    echo "<pre>";
        echo "End element: $name\n";
    echo "</pre>";
}

function characterData($parser, $data) {
    $trimmed = trim($data);
    if (!empty($trimmed)) {
        echo "<pre>";
            echo "Characters: $trimmed\n";
        echo "</pre>";
    }
}

// Parser yaradırıq
$parser = xml_parser_create();

// Callback-ləri təyin edirik
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");

// XML faylını açırıq
$fp = fopen("kitabxana.xml", "r");

while ($data = fread($fp, 4096)) {
    xml_parse($parser, $data, feof($fp)) or
        die(sprintf("XML error: %s at line %d",
            xml_error_string(xml_get_error_code($parser)),
            xml_get_current_line_number($parser)));
}

// Parseri azad edirik
xml_parser_free($parser);
?>