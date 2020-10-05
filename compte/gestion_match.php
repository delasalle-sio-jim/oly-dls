<?php session_start();
// connexion à la base de données
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");
?>
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
		<?php
		include("../include/navbar.php");

		if (isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2)
		{
			?>
			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<h1 id="titre">Gestion des matchs</h1>
			</div>

			<div class="mx-auto mt-5 text-center" style="width : 20%;">
        <label for="equi_id">Equipe</label>
        <?php
        //	on récupère toutes les lignes de la table Compte
        $resultat = $cnx->query("select * FROM equipe;");
        //le résultat est récupéré sous forme d'objet
        $resultat->setFetchMode(PDO::FETCH_OBJ);

        $Chaine = "";
        $Select='<select class="form-control" id="equi_id">';
        // tant qu'il y a des niveaux
        while ($ligne = $resultat->fetch() )	{
          $Chaine = $Chaine."<option value=".$ligne->equi_id.">".utf8_encode($ligne->equi_nom)."</option>";
        }
        echo $Select.$Chaine.'</select>';
        ?>

        </br>

        <button type="button" class="btn btn-info" onclick="rediriger();">Sélectionner</button>
			</div>

      <?php
      if(isset($_GET['id']))
      {
        ?>
        <form action="gestion_match_action.php?&id=<?php echo $_GET['id'] ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">

					<div class="mx-auto mt-5" style="width : 70%;">
		  			<table class="table table-striped">
		  				<?php
		  				// exécution de la requête  et récupération des données extraites
		  				$req_pre = $cnx->prepare("select * FROM corewqqc_oly_dls_bdd.match where mat_equipe = :mat_equipe ORDER BY mat_horaire DESC");
		          $req_pre->bindValue(':mat_equipe', $_GET['id'], PDO::PARAM_INT);
		          $req_pre->execute();
		  				$req_pre->setFetchMode(PDO::FETCH_OBJ);

		  				// lecture de la première ligne du jeu d'enregistrements
		  				$ligne = $req_pre->fetch();
		  				$match = 1;
		  				// tant qu'il y a des lignes à lire
		  				?>
		  				<thead>
		  					<th>Match</th>
		  					<th>Jeu</th>
		  					<th>Horaire</th>
		  				</thead>

		  				<?php
		          // Match déjà crée
		  				// tant qu'il y a des lignes à lire
		  				while($ligne) { ?>
		  					<tr>
		  						<td><b><?php echo $match; ?></b></td>
		  						<td>
		                <?php
		                //	on récupère toutes les lignes de la table Compte
		                $resultat = $cnx->query("select * FROM jeu where jeu_type = 'N';");
		                //le résultat est récupéré sous forme d'objet
		                $resultat->setFetchMode(PDO::FETCH_OBJ);

		                $Chaine = "";
		                $Select='<select class="form-control" id="jeu_id' . $match . '" name="jeu_id[]">';
		                // tant qu'il y a des niveaux
		                while ($row = $resultat->fetch())	{
		                  $Chaine = $Chaine."<option value=".$row->jeu_id.">".utf8_encode($row->jeu_nom)."</option>";
		                }
		                echo $Select.$Chaine.'</select>';
		                ?>
		              </td>
		  						<td>
		                <?php
		                //	on récupère toutes les lignes de la table Compte
		                $resultat = $cnx->query("select * FROM horaire;");
		                //le résultat est récupéré sous forme d'objet
		                $resultat->setFetchMode(PDO::FETCH_OBJ);

		                $Chaine = "";
		                $Select='<select class="form-control" id="hor_id' . $match . '" name="hor_id[]">';
		                // tant qu'il y a des niveaux
		                while ($row = $resultat->fetch())	{
		                  $Chaine = $Chaine."<option value=".$row->hor_id.">".utf8_encode($row->hor_heure)."</option>";
		                }
		                echo $Select.$Chaine.'</select>';
		                ?>
		              </td>
		  					</tr>
		  					<?php
		  					// lecture de la ligne suivante
		  					$match += 1;
		  					$ligne = $req_pre->fetch();
		  				}
		          // Séparation entre la partie match crée et match à créer
		          ?>
		          <tr>
		            <td style="height: 40px;"></td>
		            <td style="height: 40px;"></td>
		            <td style="height: 40px;"></td>
		          </tr>
		          <?php
		          // Match à créer
		          while($match <= 8)
		          {
		            ?>
		            <tr>
		              <td><b><?php echo $match; ?></b></td>
		              <td>
		                <?php
		                //	on récupère toutes les lignes de la table Compte
		                $resultat = $cnx->query("select * FROM jeu where jeu_type = 'N';");
		                //le résultat est récupéré sous forme d'objet
		                $resultat->setFetchMode(PDO::FETCH_OBJ);

		                $Chaine = "";
		                $Select='<select class="form-control" name="jeu_id[]">';
		                // tant qu'il y a des niveaux
		                while ($row = $resultat->fetch())	{
		                  $Chaine = $Chaine."<option value=".$row->jeu_id.">".utf8_encode($row->jeu_nom)."</option>";
		                }
		                echo $Select.$Chaine.'</select>';
		                ?>
		              </td>
		              <td>
		                <?php
		                //	on récupère toutes les lignes de la table Compte
		                $resultat = $cnx->query("select * FROM horaire;");
		                //le résultat est récupéré sous forme d'objet
		                $resultat->setFetchMode(PDO::FETCH_OBJ);

		                $Chaine = "";
		                $Select='<select class="form-control" name="hor_id[]">';
		                // tant qu'il y a des niveaux
		                while ($row = $resultat->fetch())	{
		                  $Chaine = $Chaine."<option value=".$row->hor_id.">".utf8_encode($row->hor_heure)."</option>";
		                }
		                echo $Select.$Chaine.'</select>';
		                ?>
		              </td>
		            </tr>
		            <?php
		            // lecture de la ligne suivante
		            $match += 1;
		          }
		  				// fermeture du curseur associé à un jeu de résultats
		  				$resultat->closeCursor(); ?>
		  			</table>
					</div>

					<div class="mx-auto mt-5 text-center" style="width : 100%;">
						<button class="btn btn-info" type="submit" onClick="return confirm('Etes-vous sûr de vouloir valider ces matchs ?');">Valider les matchs</button>
					</div>
        </form>
        <?php
      }
      ?>

			<div class="mx-auto mt-3 mb-5 text-center" style="width : 100%;">
				<a href="index.php" role="button" class="btn btn-secondary">Retour</a>
			</div>

			<?php
		}
		else {
			header('refresh:5; url=../index.php?action=1');
			ob_flush();
			?>
			<div class="alert alert-danger">
				<strong>Erreur :</strong> vous devez être connecté en tant qu'administrateur !
			</div>
			<?php
		} ?>

    <script>
      <?php
      if(isset($_GET['id']))
      {
        ?>
        (function() {
          <?php
          // exécution de la requête  et récupération des données extraites
          $req_pre = $cnx->prepare("select * FROM corewqqc_oly_dls_bdd.match where mat_equipe = :mat_equipe ORDER BY mat_horaire");
          $req_pre->bindValue(':mat_equipe', $_GET['id'], PDO::PARAM_INT);
          $req_pre->execute();
          $req_pre->setFetchMode(PDO::FETCH_OBJ);

          // lecture de la première ligne du jeu d'enregistrements
          $ligne = $req_pre->fetch();
          $match = 1;
          while($ligne)
          {
            ?>
            document.getElementById("jeu_id" + <?php echo $match ?>).value = <?php echo $ligne->mat_jeu ?>;
            document.getElementById("hor_id" + <?php echo $match ?>).value = <?php echo $ligne->mat_horaire ?>;
            <?php
            $match++;
            $ligne = $req_pre->fetch();
          }
          ?>
          document.getElementById("equi_id").value = <?php echo $_GET['id'] ?>;
          document.getElementById("titre").innerHTML = "Gestion des matchs - " + document.getElementById("equi_id").options[document.getElementById("equi_id").selectedIndex].text;
        })();
        <?php
      }
      ?>

      function rediriger() {
        document.location.href="gestion_match.php?id=" + document.getElementById("equi_id").value;
      }
    </script>
	</body>
</html>
