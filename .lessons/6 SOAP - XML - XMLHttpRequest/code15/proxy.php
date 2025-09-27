<?php
header("Content-Type: application/xml; charset=UTF-8");
echo file_get_contents("https://www.tcmb.gov.tr/kurlar/today.xml");
