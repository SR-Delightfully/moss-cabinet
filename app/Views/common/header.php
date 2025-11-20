<?php

use App\Helpers\UserContext;

$currentUser = UserContext::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en" data-theme="lights-on">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/00-Global-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/01-Authorization-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/02-Home-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/03-Profile-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/04-Cart-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/05-Categories-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/06-Collections-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/07-Products-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/08-Product-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/09-Settings-Styles.css">
    <link rel="stylesheet" href="./public/assets/css/10-Admin-Styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Bilbo+Swash+Caps&family=Bonheur+Royale&family=Corinthia:wght@400;700&family=Eagle+Lake&family=Edu+NSW+ACT+Cursive:wght@400..700&family=Manufacturing+Consent&family=Moon+Dance&family=Playwrite+NL:wght@100..400&family=Qwigley&display=swap" rel="stylesheet">
</head>

<body>
    <header id="top-bar">
    </header>
