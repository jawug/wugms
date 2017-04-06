<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <?php
        echo "<title>" . $PageEntity->getShortSiteName() . " - " . $PageEntity->getShortName() . "</title>";
        include($PageEntity->getServerBase() . '/header_required.php');
        ?>
    </head>
    <body>
        <div id="wrapper">

