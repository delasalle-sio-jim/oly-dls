<?php
include("../include/_inc_parametres.php");
include("../include/_inc_connexion.php");
?>
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
		<?php
		include("../include/navbar.php");

		//	on récupère toutes les lignes de la table Compte
		$resultat = $cnx->prepare("select * FROM planning WHERE equi_id = :equi_id order by hor_heure;");
		$resultat->bindValue(':equi_id', $_POST['identifiant'], PDO::PARAM_INT);
		//le résultat est récupéré sous forme d'objet
		$resultat->execute();
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		$ligne = $resultat->fetch();
		?>
		<div class="mx-auto mt-5" style="width : 70%;">
			<h1><?php if(isset($ligne->equi_nom)) echo $ligne->equi_nom ?></h1>
			<br>
			<table class="table table-hover table-striped">
				<thead>
					<th width="50%">Jeu</th>
					<th width="50%">Horaire</th>
					<?php /* <th>Lieu</th> */ ?>
				</thead>

				<?php
				// tant qu'il y a des lignes à lire
				while($ligne) { ?>
					<tr>
						<td><?php echo utf8_encode($ligne->jeu_nom); ?></td>
						<td><?php echo utf8_encode($ligne->hor_heure); ?></td>
						<?php /* <td><?php echo utf8_encode($ligne->jeu_lieu); ?></td>*/ ?>
					</tr>
					<?php
					$ligne = $resultat->fetch();
				}
				// fermeture du curseur associé à un jeu de résultats
				$resultat->closeCursor();
				?>
			</table>
		</div>
		<?php /*
		</br></br>

			<img src="../images/dls-olympiade.png" alt="plan" />

		</br></br> */
		?>

		<div class="mx-auto mt-5 text-center" style="width : 100%;">
			<a href="../" role="button" class="btn btn-secondary">Retour</a>
		</div>
	</body>
</html>
