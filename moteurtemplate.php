<?php
// gestion des templates avec Twig
require_once('./twig/vendor/autoload.php');
//indique que le loader sera présent dans le dossier Views du dossier 
$loader = new \Twig\Loader\FilesystemLoader('Views');
$twig = new \Twig\Environment($loader, ['cache' => false, 'debug' => true]);
$twig->addGlobal("session",$_SESSION);
$twig->addGlobal("post",$_POST);
$twig->addExtension(new \Twig\Extension\DebugExtension());

?>