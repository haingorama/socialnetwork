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
    include "../models/UserManager.php";
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordRetype'])) {
      $errorMsg = NULL;
      if (!IsNicknameFree($_POST['username'])) {
        $errorMsg = "Nickname already used.";
      } else if ($_POST['password'] != $_POST['passwordRetype']) {
        $errorMsg = "Passwords are not the same.";
      } else if (strlen(trim($_POST['password'])) < 8) {
        $errorMsg = "Your password should have at least 8 characters.";
      } else if (strlen(trim($_POST['username'])) < 4) {
        $errorMsg = "Your nickame should have at least 4 characters.";
      }
      if ($errorMsg) {
        include "../views/RegisterForm.php";
      } else {
        $userId = CreateNewUser($_POST['username'], $_POST['password']);
        $_SESSION['userId'] = $userId;
        header('Location: ?action=display');
      }
    } else {
      include "../views/RegisterForm.php";
    }
    break;

  case 'logout':
    if (isset($_SESSION['userId'])) {
      unset($_SESSION['userId']);
    }
    header('Location: ?action=display');
    break;

  case 'login':
    include "../models/UserManager.php";
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $userId = GetUserIdFromUserAndPassword($_POST['username'], $_POST['password']);
      if ($userId > 0) {
        $_SESSION['userId'] = $userId;
        header('Location: ?action=display');
      } else {
        $errorMsg = "Wrong login and/or password.";
        include "../views/LoginForm.php";
      }
    } else {
      include "../views/LoginForm.php";
    }
    break;

  case 'newMsg':
    include "../models/PostManager.php";
    if (isset($_SESSION['userId']) && isset($_POST['msg'])) {
      CreateNewPost($_SESSION['userId'], $_POST['msg']); //s'il veut créer un nouveau message 
    }
    header('Location: ?action=display'); //redirige vers page d'accueil
    break;

  case 'newComment':
    // code...
    break;

  case 'display': //si aucune des valeur correspond à ces actes il va directement ici 
  default:

    //Exercice 2 Modif search
    include "../models/PostManager.php";
    if (isset($_GET['search'])) {
      $posts = SearchInPosts($_GET['search']);
    } else {
      $posts = GetAllPosts();
    }

    //Exercice 1 Modif commentaires
    /*include "../models/PostManager.php"; //si de base la requette est envoyer en Get > inclue le post fichier manager
    $posts = GetAllPosts();*/

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
