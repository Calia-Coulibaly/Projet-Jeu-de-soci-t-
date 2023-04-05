<?php
session_start();  // utilisation des sessions
require 'moteurtemplate.php'; // paramètres TWIG
include "connect.php"; // connexion au SGBD
include "Controllers/jeuxController.php";
include "Controllers/membresController.php";
include "Controllers/notesController.php";
include "Controllers/commentairesController.php";
$jeuxController = new JeuController($bdd, $twig);
$membresController = new MembreController($bdd, $twig);
$notesController = new NoteController ($bdd, $twig);
$commentaireController = new CommentaireController($bdd,$twig);
?>

<?php

// ============================== connexion / deconnexion - sessions ==================
$message = "";
if (!isset($_SESSION['acces'])) {
  $_SESSION['acces'] = 'non';
}

if (!isset($_SESSION['admin'])) {
  $_SESSION['admin'] = 'non';
}

if (isset($_GET["page"])  && $_GET["page"] == "inscription") {
  $membresController->membreFormInsc();
}

if (isset($_POST["valider"])) {
  $membresController->membreAjout();
}

if (isset($_GET["page"])  && $_GET["page"] == "connect") {
  $membresController->membreFormulaire();
}

if (isset($_POST["connexion"])) {
  $membresController->membreConnexion($_POST);
}

if (isset($_GET["page"]) && $_GET['page'] == "deconnect") {
  $message = $membresController->membreDeconnexion();
}

if (isset($_POST["connexion"])) {
  $message = $membresController->membreConnexion($_POST);
}

// ============================== pages "Jeux" affichant les jeux sous forme de liste ==================

              // ============================== Page d'accueil ==================

if (isset($_GET["page"]) && $_GET["page"] == "accueil") {
  $jeuxController->listeJeux();
}

              // ============================== Page "Jeux" ==================

    if (isset($_GET["page"]) && $_GET["page"]=="jeux" && !isset($_GET["nom"])) {
      $jeuxController->rechercheForm($_POST);
    }

// ============================== page "Noter" du jeux selectionné en étant connecté ==================

if (isset($_GET["noter"])) {
  $notesController->noteFormAdd($_SESSION["pseudo"]);
  
}

if (isset($_POST["valider_note"])){
  $notesController->ajoutNote();
}

if (isset($_POST["valider_commentaire"])){
  $commentaireController->ajoutCommentaire();
}



// ============================== Detail jeux ==================

    if (isset($_GET["nom"]) && $_GET["page"]=="jeux") {
      $jeuxController->detailJeu($_GET["nom"]);
    }

// ============================== Recherche ==================


if (isset($_GET["action"]) && $_GET["action"] == "jeurecherche"){
  $jeuxController->rechercheJeu($_POST);
}



// ============================== Ajout / Modification / Suppression des jeux ==================

              // ============================== Ajouter ==================
    if (isset($_GET["action"]) && $_GET["action"] == "ajouter") {
      $jeuxController->jeuxFormAdd($_SESSION["pseudo"]);
    } 

    if (isset($_POST["valider_ajout"])){
      $jeuxController->ajoutJeux();
      $jeuxController->connectJeu($_SESSION["pseudo"]);
    }
   
// ============================== page "Createur de jeu" affichant les informations des jeux ajoutés ==================

if (isset($_GET["page"]) && $_GET["page"] == "createur" && isset($_GET["nom"])) {
  $membresController->createurJeux($_GET["nom"]);
}

// ============================== page "Profil" affichant les informations du membre connecté ==================

if (isset($_GET["page"]) && $_GET["page"] == "profil" && !isset($_GET["profil"])) {
  $membresController->profilMembre($_SESSION["pseudo"]);
}

// ============================== page "Mes jeux" affichant les jeux du membre connecté ==================

if (isset($_GET["page"]) && $_GET["page"] == "mesjeux" && !isset($_GET["mesjeux"])) {
  $jeuxController->connectJeu($_SESSION["pseudo"]);
}




//  ============================== page d'accueil ==================
if (substr($_SERVER["REQUEST_URI"], -5) === 'Jeux/' || substr($_SERVER["REQUEST_URI"], -9) === 'index.php' && $_GET == null) {
  $jeuxController->listeJeux();
}


?>