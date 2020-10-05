<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Olympiades</title>
  </head>
  <body>
    <?php include("../include/navbar.php");?>

    <div class="container">
    <?php
        /* il faut que toutes les variables du formulaire existent*/
        if(isset($_POST['identifiant']) && isset($_POST['mdp']))
        {
            /*il faut que tous les champs soient renseignes*/
            if($_POST['mdp'] != "")
            {

              include("../include/_inc_parametres.php");
              include("../include/_inc_connexion.php");
                /* on verifie qu'un membre a bien ce login et ce mot de passe*/
                $req = $cnx->prepare('SELECT * FROM compte WHERE com_id = :com_id AND com_mdp = :com_mdp ');
                $req->bindValue(':com_id', $_POST['identifiant'], PDO::PARAM_INT);
                $req->bindValue(':com_mdp', $_POST['mdp'], PDO::PARAM_STR);
                //le résultat est récupéré sous forme d'objet
                $req->execute();
                $req->setFetchMode(PDO::FETCH_OBJ);
                $resultat = $req->fetch();

                /*s'il n'y a pas de resultat, on renvoie a la page de connexion*/

                if(!$resultat)
                {
                  header('refresh:1; url=../index.php?action=1');
                  ob_flush();
                  ?>
                  <div class="alert alert-danger mt-5">
                      <strong>Erreur :</strong> Mot de passe erroné !
                  </div>
                  <?php
                }
                else
                {
                    /* on cree les variables de session du membre qui lui serviront pendant sa session*/
                    $_SESSION['com_id'] = $resultat->com_id;
                    $_SESSION['com_login'] = $resultat->com_login;
                    $_SESSION['com_num_privilege'] = $resultat->com_num_privilege;
                    $_SESSION['connect'] = true;
                    ?>
                        <div class="alert alert-success mt-5">
                            <strong>Succès :</strong> Vous êtes à présent connecté !
                        </div>
                        
                        <a href="index.php">Allez au menu</a>
                    <?php
                    $req->closeCursor();
                    /*header('refresh:1; url=index.php');
                    ob_flush();*/
                }
            }
            else {
              header('refresh:5; url=../index.php?action=1');
              ob_flush();
              ?>
              <div class="alert alert-danger mt-5">
                  <strong>Erreur :</strong> Il faut remplir tous les champs !
              </div>
              <?php
            }
        }
        else
        {
          header('refresh:5; url=../index.php?action=1');
          ob_flush();
          ?>
          <div class="alert alert-danger mt-5">
              <strong>Erreur :</strong> Une erreur s'est produite !
          </div>
          <?php
        } ?>
    </div> <!-- /container -->
  </body>
</html>