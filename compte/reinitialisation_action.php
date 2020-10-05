<?php session_start();
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");

if(isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2)
{
  if(isset($_POST['mdp']))
  {
    // préparation de la requête
		$req_pre = $cnx->prepare("select com_mdp from compte where com_id = :com_id");
		// liaison de la variable à la requête préparée
		$req_pre->bindValue(':com_id', $_SESSION['com_id'], PDO::PARAM_INT);
		$req_pre->execute();
    $req_pre->setFetchMode(PDO::FETCH_OBJ);
    $resultat = $req_pre->fetch();

    if($_POST['mdp'] == $resultat->com_mdp)
    {
      // préparation de la requête
      $req_pre = $cnx->query("call vider_scores()");
      // exécution
      $req_pre->execute();
    }
  }

  header('refresh:0; url=index.php');
  ob_flush();
}
else
{
  header('refresh:0; url=../index.php?action=1');
  ob_flush();
}
