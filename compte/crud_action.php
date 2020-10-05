<?php session_start();
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");

if(isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2 && isset($_GET['type']))
{
  if ($_GET['type'] == 'compte')
  {
    if (isset($_POST['new_login']))
    {
      $i = 0;
      foreach ($_POST['new_login'] as $rien)
      {
        $req_pre = $cnx->prepare("INSERT INTO compte (com_login, com_mdp, com_num_privilege) VALUES (:com_login, :com_mdp, :com_num_privilege)");
        $req_pre->bindValue(':com_login', $_POST['new_login'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':com_mdp', $_POST['new_mdp'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':com_num_privilege', $_POST['new_priv'][$i], PDO::PARAM_INT);
        $req_pre->execute();

        $i++;
      }
    }
    if (!isset($_GET['action']))
    {
      $i = 0;
      foreach ($_POST['id'] as $id)
      {
        $req_pre = $cnx->prepare("UPDATE compte set com_login = :com_login, com_mdp = :com_mdp, com_num_privilege = :com_num_privilege where com_id = :com_id");
        $req_pre->bindValue(':com_id', $id, PDO::PARAM_INT);
        $req_pre->bindValue(':com_login', $_POST['login'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':com_mdp', $_POST['mdp'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':com_num_privilege', $_POST['priv'][$i], PDO::PARAM_INT);
        $req_pre->execute();

        $i++;
      }
    }
    if (isset($_GET['action']) && $_GET['action'] == 'del')
    {
      $req_pre = $cnx->prepare("DELETE FROM compte WHERE com_id = :com_id");
      $req_pre->bindValue(':com_id', $_GET['id'], PDO::PARAM_INT);
      $req_pre->execute();

      header('refresh:0; url=crud.php?type=compte');
      ob_flush();
    }
  }
  else if ($_GET['type'] == 'jeu')
  {
    if (isset($_POST['new_nom']))
    {
      $i = 0;
      foreach ($_POST['new_nom'] as $rien)
      {
        $req_pre = $cnx->prepare("INSERT INTO jeu (jeu_nom, jeu_regle, jeu_type) VALUES (:jeu_nom, :jeu_regle, :jeu_type)");
        $req_pre->bindValue(':jeu_nom', $_POST['new_nom'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':jeu_regle', $_POST['new_regle'][$i], PDO::PARAM_STR);
        $req_pre->bindValue(':jeu_type', $_POST['new_type'][$i], PDO::PARAM_STR);
        $req_pre->execute();

        $i++;
      }
    }
    if (!isset($_GET['action']))
    {
      $i = 0;
      foreach ($_POST['id'] as $id)
      {
        $req_pre = $cnx->prepare("UPDATE jeu set jeu_nom = :jeu_nom, jeu_regle = :jeu_regle, jeu_type = :jeu_type where jeu_id = :jeu_id");
        $req_pre->bindValue(':jeu_id', $id, PDO::PARAM_INT);
        $req_pre->bindValue(':jeu_nom', utf8_encode($_POST['nom'][$i]), PDO::PARAM_STR);
        $req_pre->bindValue(':jeu_regle', utf8_encode($_POST['regle'][$i]), PDO::PARAM_STR);
        $req_pre->bindValue(':jeu_type', $_POST['type'][$i][$id], PDO::PARAM_STR);
        $req_pre->execute();

        $i++;
      }
    }
    if (isset($_GET['action']) && $_GET['action'] == 'del')
    {
      $req_pre = $cnx->prepare("DELETE FROM jeu WHERE jeu_id = :jeu_id");
      $req_pre->bindValue(':jeu_id', $_GET['id'], PDO::PARAM_INT);
      $req_pre->execute();

      header('refresh:0; url=crud.php?type=jeu');
      ob_flush();
    }
  }
  else if ($_GET['type'] == 'equipe')
  {
    if (isset($_POST['new_nom']))
    {
      $i = 0;
      foreach ($_POST['new_nom'] as $rien)
      {
        $req_pre = $cnx->prepare("INSERT INTO equipe (equi_nom) VALUES (:equi_nom)");
        $req_pre->bindValue(':equi_nom', $_POST['new_nom'][$i], PDO::PARAM_STR);
        $req_pre->execute();

        $i++;
      }
    }
    if (!isset($_GET['action']))
    {
      $i = 0;
      foreach ($_POST['id'] as $id)
      {
        $req_pre = $cnx->prepare("UPDATE equipe set equi_nom = :equi_nom where equi_id = :equi_id");
        $req_pre->bindValue(':equi_id', $id, PDO::PARAM_INT);
        $req_pre->bindValue(':equi_nom', utf8_encode($_POST['nom'][$i]), PDO::PARAM_STR);
        $req_pre->execute();

        $i++;
      }
    }
    if (isset($_GET['action']) && $_GET['action'] == 'del')
    {
      $req_pre = $cnx->prepare("DELETE FROM equipe WHERE equi_id = :equi_id");
      $req_pre->bindValue(':equi_id', $_GET['id'], PDO::PARAM_INT);
      $req_pre->execute();

      header('refresh:0; url=crud.php?type=equipe');
      ob_flush();
    }
  }

  if (! isset($_GET['action']))
  {
    header('refresh:0; url=index.php');
    ob_flush();
  }
}
else
{
  header('refresh:0; url=../index.php?action=1');
  ob_flush();
}
