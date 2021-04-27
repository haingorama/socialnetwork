<?php

//Version opération terner
//$action = $_GET["action"] ?? "display";
/*$action = "display";
if (isset($_GET["action"])) {
  $action = $_GET["action"];
}*/
$action = isset($_GET["action"]) ? $_GET["action"] : "display"; //opérateur coallesc c'est la même chose

switch ($action) {

  case 'register': //si $action vaut enregistrer il va là
    // code...
    break;

  case 'logout': //si $action vaut logout il va ici 
    // code...
    break;

  case 'login': //si $action vaut login il va ici ainsi desuite pour le reste
    // code...
    break;

  case 'newMsg':
    // code...
    break;

  case 'newComment':
    // code...
    break;

  case 'display': //si aucune des valeur correspond à ces actes il va directement ici 
  default:
    include "../models/PostManager.php"; //si de base la requette est envoyer en Get > inclue le post fichier manager
    $posts = GetAllPosts();

    include "../models/CommentManager.php"; // écrit tous les commentaires du tableau çi-dessous
    $comments = array();

    foreach ($posts as $onePost) { //va réitérer sur chacun des éléments
      $postId = $onePost['id'];
      $commentsForThisPostId = GetAllCommentsFromPostId($postId);
      $comments[$postId] = $commentsForThisPostId;
    }
    include "../views/DisplayPosts.php"; // après les commentaires il va faire au fichier DisplayPost.php pour y mettre les faux commentaires
    break;
}
