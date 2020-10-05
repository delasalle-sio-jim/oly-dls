<?php session_start();
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");

if(isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2)
{
  if(isset($_GET['id']) && isset($_POST['jeu_id']) && isset($_POST['hor_id']))
  {
    $req_pre = $cnx->prepare("DELETE FROM corewqqc_oly_dls_bdd.match WHERE mat_equipe = :mat_equipe;");
    // liaison de la variable à la requête préparée
    $req_pre->bindValue(':mat_equipe', $_GET['id'], PDO::PARAM_INT);
    $req_pre->execute();

    for($i = 0; $i < 8; $i++)
    {
      $req_pre = $cnx->prepare("INSERT INTO corewqqc_oly_dls_bdd.match VALUES (:mat_jeu, :mat_equipe, :mat_horaire, null);");
      // liaison de la variable à la requête préparée
      $req_pre->bindValue(':mat_jeu', $_POST['jeu_id'][$i], PDO::PARAM_INT);
      $req_pre->bindValue(':mat_equipe', $_GET['id'], PDO::PARAM_INT);
      $req_pre->bindValue(':mat_horaire', $_POST['hor_id'][$i], PDO::PARAM_INT);
      $req_pre->execute();
    }
  }

  header('refresh:0; url=gestion_match.php?id=' . $_GET['id']);
  ob_flush();
}
else
{
  header('refresh:0; url=../index.php?action=1');
  ob_flush();
}
