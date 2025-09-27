<?php
// TCMB valyuta xml faylı
$url = "https://www.tcmb.gov.tr/kurlar/today.xml";

// XML-i yüklə
$xml = simplexml_load_file($url);

// XML-də bütün <Currency> elementlərini al
$currencies = $xml->Currency;

// ümumi valyuta sayını öyrənək
$total = count($currencies);

// for ilə dövrə salaq və sadəcə 1 ilə 3 cü indekslərdə olan dəyərləri əldə edək.
// for ($i = 0; $i < $total; $i++) {
//     // yalnız cur[1] və cur[3]-ü çıxardaq
//     if ($i == 1 || $i == 3) {
//         echo "cur[$i] - Kod: "  . $currencies[$i]['Kod']            . "<br>";
//         echo "Adı: "            . $currencies[$i]->Isim             . "<br>";
//         echo "Forex Buying: "   . $currencies[$i]->ForexBuying      . "<br>";
//         echo "Forex Selling: "  . $currencies[$i]->ForexSelling     . "<br>";
//     }
// }



// for ilə bütün dəyərləri əldə edək.
for ($i = 0; $i < $total; $i++) {
        echo "Adı: "            . $currencies[$i]->Isim             . "<br>";
        echo "Forex Buying: "   . $currencies[$i]->ForexBuying      . "<br>";
        echo "............................. <br>";
}