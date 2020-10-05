<?php session_start();
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

		if (isset($_SESSION['connect']) && $_SESSION['connect'] && ($_SESSION['com_num_privilege'] == 1 || $_SESSION['com_num_privilege'] == 2))
		{
			?>

			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<?php
				$id = $_GET['id'];
				// exécution de la requête  et récupération des données extraites
				$resultat = $cnx->prepare("select * from jeu where jeu_id = :jeu_id");
				$resultat->bindValue(':jeu_id', $id, PDO::PARAM_INT);
				$resultat->execute();
				$resultat->setFetchMode(PDO::FETCH_OBJ);
				$ligne = $resultat->fetch();
				?>

				<h1><?= utf8_encode($ligne->jeu_nom) ?></h1>

				</br></br>

				<h2>Règles de l'épreuve</h2>

				</br>

				<p><?= utf8_encode($ligne->jeu_regle) ?></p>

				</br></br>

				<h1>Planning & Résultats</h1>
			</div>

			<div class="mx-auto mt-5" style="width : 60%;">
				<form action="jeu_validation.php?action=jeu_n&id=<?php echo $id ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
				<table class="table table-striped">
					<thead class="text-center">
						<th>Match</th>
						<th>Equipe</th>
						<th>Horaire</th>
						<th>Résultat</th>
					</thead>
				<?php
					// exécution de la requête  et récupération des données extraites
					$resultat = $cnx->prepare("select * from planning where jeu_id = :jeu_id");
					$resultat->bindValue(':jeu_id', $id, PDO::PARAM_INT);
					$resultat->execute();
					$resultat->setFetchMode(PDO::FETCH_OBJ);

					// lecture de la première ligne du jeu d'enregistrements
					$ligne = $resultat->fetch();

					$match = 1;
					// tant qu'il y a des lignes à lire
					while($ligne) { ?>
						<tr  class="text-center">
							<td><?php echo $match ?></td>
							<td><?php echo $ligne->equi_nom ?></td>
							<td><?php echo $ligne->hor_heure ?></td>
							<td>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Gagne<?php echo $ligne->equi_id ?>" value="10">
								<label class="form-check-label" for="Gagne<?php echo $ligne->equi_id ?>">
									Gagné
								</label>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Egalite<?php echo $ligne->equi_id ?>" value="5">
								<label class="form-check-label" for="Egalite<?php echo $ligne->equi_id ?>">
									Egalité
								</label>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Perdu<?php echo $ligne->equi_id ?>" value="0">
								<label class="form-check-label" for="Perdu<?php echo $ligne->equi_id ?>">
									Perdu
								</label>
							</td>
						</tr>
						<?php
						// lecture de la ligne suivante
						$ligne = $resultat->fetch();
						if( ! $ligne) {
							break;
						}
						?>
						<tr  class="text-center">
							<td><?php echo $match ?></td>
							<td><?php echo $ligne->equi_nom ?></td>
							<td><?php echo $ligne->hor_heure ?></td>
							<td>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Gagne<?php echo $ligne->equi_id ?>" value="10">
								<label class="form-check-label" for="Gagne<?php echo $ligne->equi_id ?>">
									Gagné
								</label>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Egalite<?php echo $ligne->equi_id ?>" value="5">
								<label class="form-check-label" for="Egalite<?php echo $ligne->equi_id ?>">
									Egalité
								</label>
								<input class="form-control-input" type="radio" name="resultat[][<?php echo $ligne->equi_id ?>]" id="Perdu<?php echo $ligne->equi_id ?>" value="0">
								<label class="form-check-label" for="Perdu<?php echo $ligne->equi_id ?>">
									Perdu
								</label>
							</td>
						</tr>
						<?php
						// lecture de la ligne suivante
						$ligne = $resultat->fetch();
						$match++;
					}
					// fermeture du curseur associé à un jeu de résultats
					$resultat->closeCursor(); ?>
				</table>
			</div>

			<div class="mx-auto mt-5 mb-5 text-center" style="width : 100%;">
				<?php
				if ($_SESSION['com_num_privilege'] == 1)
				{
					?>
					<p style="font-style : italic;">En cas d'erreur de saisie, veuillez alerter un administrateur.</p>
					</br></br>
					<?php
				}
				?>

					<button class="btn btn-info" type="submit" onClick="return confirm('Etes-vous sûr de vouloir valider ces résultats ?');">Valider les résultats</button>
				</form>


				</br></br>

				<a href="index.php" role="button" class="btn btn-secondary">Retour</a>
			</div>

			<?php
			// Pré remplissage des résultats déja validés
			$resultat = $cnx->prepare("select mat_equipe, mat_nb_point from corewqqc_oly_dls_bdd.match where mat_jeu = :mat_jeu");
			$resultat->bindValue(':mat_jeu', $id, PDO::PARAM_INT);
			$resultat->execute();
			$resultat->setFetchMode(PDO::FETCH_OBJ);
			$ligne = $resultat->fetch();
			while($ligne)
			{
				?>
				<script>
					<?php
					if ( ! is_null($ligne->mat_nb_point))
					{
						switch ($ligne->mat_nb_point) {
							case 10:
								?>
								radiobtn = document.getElementById("Gagne<?php echo $ligne->mat_equipe ?>").checked = true;
								<?php
								break;

							case 5:
								?>
								radiobtn = document.getElementById("Egalite<?php echo $ligne->mat_equipe ?>").checked = true;
								<?php
								break;

							case 0:
								?>
								document.getElementById("Perdu<?php echo $ligne->mat_equipe ?>").checked = true;
								<?php
								break;
						}

						// On désactive les éléments pour empecher les fausses manipulations
						// Passer par un compte de privilège 2 pour modification
						if ($_SESSION['com_num_privilege'] == 1)
						{
							?>
							document.getElementById("Gagne<?php echo $ligne->mat_equipe ?>").disabled = true;
							document.getElementById("Egalite<?php echo $ligne->mat_equipe ?>").disabled = true;
							document.getElementById("Perdu<?php echo $ligne->mat_equipe ?>").disabled = true;
							<?php
						}
					}
					?>
				</script>
				<?php
				$ligne = $resultat->fetch();
			}
		}
		else {
			header('refresh:5; url=../index.php?action=1');
			ob_flush();
			?>
			<div class="alert alert-danger">
				<strong>Erreur :</strong> vous devez être connecté en tant que professeur ou administrateur !
			</div>
			<?php
		} ?>
	</body>
</html>
