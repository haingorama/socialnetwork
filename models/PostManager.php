<?php
include_once "PDO.php";

function GetOnePostFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM post WHERE id = $id");
  return $response->fetch();
}

function GetAllPosts()
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "  //récup tous les Posts avec les utilisateurs
      . "FROM post LEFT JOIN user on (post.user_id = user.id) " //joint les tableaux de droite (post et comment) vers user(utilisateurs)
      . "ORDER BY post.created_at DESC" //trie par ordre de date décroissant
  );
  return $response->fetchAll();
}

function GetAllPostsFromUserId($userId) //se référer à la partie Commentaire dans controller.php pour mettre les commentaires
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM post WHERE user_id = $userId ORDER BY created_at DESC");
  return $response->fetchAll();
}

function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like '%$search%' "
      . "ORDER BY post.created_at DESC"
  );
  return $response->fetchAll();
}

function CreateNewPost($userId, $msg)
{
  global $PDO;
  $PDO->exec("INSERT INTO post(user_id, content) values ($userId, '$msg')");
}
