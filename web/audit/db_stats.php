<?php
$timing = microtime(true);
$ServerArray = filter_input_array(INPUT_SERVER);
include($ServerArray['DOCUMENT_ROOT'] . '/../src/bwcfw.classes.php');
$db_stats = new bwcfw_util();
$db_stats->getDAOTableInformation();
if ($db_stats->hasDAOTableInformation()) {
    $db_stats->loadDAOTableInformation();
    $db_stats->loadDAOTableStats60();
    $db_stats->loadDAOTableStatsDD();
    $db_stats->loadDAOTableStatsMO();
}
