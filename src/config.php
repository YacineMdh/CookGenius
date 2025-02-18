<?php
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$langFile = __DIR__ . "/lang/" . $_SESSION['lang'] . ".php"; 

if (file_exists($langFile)) {
    $lang = include $langFile;
    if (!is_array($lang)) {
        die("Erreur : Le fichier de langue ne retourne pas un tableau valide !");
    }
} 
?>
