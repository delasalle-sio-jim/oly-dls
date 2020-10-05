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
				<h1>Tableau des scores</h1>
			</div>

			<div class="mx-auto mt-5" style="width : 70%;">
				<table class="table table-striped table-hover">
					<?php
					// exécution de la requête  et récupération des données extraites
					$resultat = $cnx->query("select * FROM classement_general ORDER BY resultat DESC");
					$resultat->setFetchMode(PDO::FETCH_OBJ);

					// lecture de la première ligne du jeu d'enregistrements
					$ligne = $resultat->fetch();
					$classement = 1;
					// tant qu'il y a des lignes à lire
					?>
					<thead class="text-center">
						<th>Classement</th>
						<th>Equipe</th>
						<th>Nombre de point</th>
						<th>Jeu effectué</th>
						<th>Jeu bonus effectué</th>
					</thead>

					<?php
					// tant qu'il y a des lignes à lire
					while($ligne) { ?>
						<tr class="text-center">
							<td><?php echo $classement; ?></td>
							<td><?php echo utf8_encode($ligne->equi_nom); ?></td>
							<td><?php echo utf8_encode($ligne->resultat); ?></td>
							<td><?php echo utf8_encode($ligne->jeu_normal_effectue); ?></td>
							<td><?php echo utf8_encode($ligne->jeu_bonus_effectue); ?></td>
						</tr>
						<?php
						// lecture de la ligne suivante
						$classement += 1;
						$ligne = $resultat->fetch();
					}
					// fermeture du curseur associé à un jeu de résultats
					$resultat->closeCursor(); ?>
				</table>
			</div>

			<div class="mx-auto mt-5 mb-5 text-center" style="width : 100%;">
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
	</body>
</html>
