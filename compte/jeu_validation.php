<?php session_start();
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");

if(isset($_SESSION['connect']) && $_SESSION['connect'] && ($_SESSION['com_num_privilege'] == 2 || $_SESSION['com_num_privilege'] == 1))
{
  if (isset ($_GET['action']))
  {
    if ($_GET['action'] == 'jeu_n')
    {
      if(isset($_POST['resultat']))
      {
        foreach($_POST['resultat'] as $resultat)
        {
          // préparation de la requête
      		$req_pre = $cnx->prepare("UPDATE corewqqc_oly_dls_bdd.match set mat_nb_point = :mat_nb_point where mat_equipe = :mat_equipe and mat_jeu = :mat_jeu");
      		// liaison de la variable à la requête préparée
      		$req_pre->bindValue(':mat_nb_point', $resultat[key($resultat)], PDO::PARAM_INT);
      		$req_pre->bindValue(':mat_equipe', key($resultat), PDO::PARAM_INT);
      		$req_pre->bindValue(':mat_jeu', $_GET['id'], PDO::PARAM_INT);
      		$req_pre->execute();
        }
      }

      header('refresh:0; url=index.php');
      ob_flush();
    }
    if ($_GET['action'] == 'jeu_b')
    {
      if (isset($_POST['equipe']) && isset($_POST['resultat']))
      {
        // préparation de la requête
        $req_pre = $cnx->prepare("insert into participer values (:par_jeu, :par_equipe, :par_nb_point)");
        // liaison de la variable à la requête préparée
        $req_pre->bindValue(':par_jeu', $_GET['id'], PDO::PARAM_INT);
        $req_pre->bindValue(':par_equipe', $_POST['equipe'], PDO::PARAM_INT);
        $req_pre->bindValue(':par_nb_point', $_POST['resultat'], PDO::PARAM_INT);
        $req_pre->execute();
      }

      if (isset($_GET['equi_id']) && $_SESSION['com_num_privilege'] == 2)
      {
        // préparation de la requête
        $req_pre = $cnx->prepare("delete from participer where par_jeu = :par_jeu AND par_equipe = :par_equipe");
        // liaison de la variable à la requête préparée
        $req_pre->bindValue(':par_jeu', $_GET['id'], PDO::PARAM_INT);
        $req_pre->bindValue(':par_equipe', $_GET['equi_id'], PDO::PARAM_INT);
        $req_pre->execute();
      }

      header('refresh:0; url=index.php');
      ob_flush();
    }
  }
  else
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
