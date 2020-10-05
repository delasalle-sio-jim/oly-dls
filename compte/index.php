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
		<?php include("../include/navbar.php");?>

		<?php
		if (isset($_SESSION['connect']) && $_SESSION['connect'])
		{
			?>

			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<?= '<h1>'.utf8_encode($_SESSION['com_login']).' <h1>'; ?>
			</div>

			<?php
			if ($_SESSION['com_num_privilege'] == 2) {
				?>

				<div class="mx-auto mt-5 mb-5 text-center" style="width : 20%;">

					<a href="crud.php?type=compte" role="button" class="btn btn-info btn-block">Gestion Compte</a></br>

					<a href="crud.php?type=jeu" role="button" class="btn btn-info btn-block">Gestion Jeu</a></br>

					<a href="crud.php?type=equipe" role="button" class="btn btn-info btn-block">Gestion Equipe</a></br>

					<a href="gestion_match.php" role="button" class="btn btn-info btn-block">Gestion Match</a></br>

					<a href="modification_score.php" role="button" class="btn btn-info btn-block">Modification Score</a></br>

					<a href="score.php" role="button" class="btn btn-info btn-block">Tableau des scores</a></br>

					<a href="reinitialisation.php" role="button" class="btn btn-info btn-block">Réinitialisation</a>
				</div>
				 <?php
			}
			else if ($_SESSION['com_num_privilege'] == 1) {
				?>
				<div class="mx-auto mt-5" style="width : 100%;">
					<table class="table table-borderless">
						<?php
							// exécution de la requête  et récupération des données extraites
							$resultat = $cnx->query("select * FROM jeu where jeu_type = 'N' order by jeu_nom");
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							// lecture de la première ligne du jeu d'enregistrements
							$ligne = $resultat->fetch();
							// tant qu'il y a des lignes à lire
							?>

							<thead class="text-center">
								<th>Jeu</th>
							</thead>

							<?php
							// tant qu'il y a des lignes à lire
							while($ligne) { ?>
								<tr class="text-center">
									<td><a href="jeu_normal.php?id=<?php echo utf8_encode($ligne->jeu_id) ?>" style="color: black;text-decoration : none;"><?php echo utf8_encode($ligne->jeu_nom); ?></a></td>
								</tr>
								<?php
								// lecture de la ligne suivante
								$ligne = $resultat->fetch();

							}
							// fermeture du curseur associé à un jeu de résultats
							$resultat->closeCursor(); ?>
						</table>

						</br></br>

						<table class="table table-borderless">
							<?php
								// exécution de la requête  et récupération des données extraites
								$resultat = $cnx->query("select * FROM jeu where jeu_type = 'B' order by jeu_nom");
								$resultat->setFetchMode(PDO::FETCH_OBJ);

								// lecture de la première ligne du jeu d'enregistrements
								$ligne = $resultat->fetch();
								// tant qu'il y a des lignes à lire
								?>

								<thead class="text-center">
									<th>Jeu Bonus</th>
								</thead>

								<?php
								// tant qu'il y a des lignes à lire
								while($ligne) { ?>
									<tr class="text-center">
										<td><a href="jeu_bonus.php?id=<?php echo utf8_encode($ligne->jeu_id) ?>" style="color: black;text-decoration : none;"><?php echo utf8_encode($ligne->jeu_nom); ?></a></td>
									</tr>
									<?php
									// lecture de la ligne suivante
									$ligne = $resultat->fetch();

								}
								// fermeture du curseur associé à un jeu de résultats
								$resultat->closeCursor(); ?>
							</table>
						</div>
				 <?php
			}
		}
		else {
			header('refresh:5; url=../index.php?action=1');
			ob_flush();
			?>
			<div class="alert alert-danger">
				<strong>Erreur :</strong> vous devez être connecté !
			</div>
			<?php
		} ?>
	</body>
</html>
