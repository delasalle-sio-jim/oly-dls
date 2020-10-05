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

				<h1>Résultats</h1>
			</div>

			<div class="mx-auto mt-5" style="width : 50%;">
				<form action="jeu_validation.php?action=jeu_b&id=<?php echo $id ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
				<table class="table table-striped">
					<thead class="text-center">
						<th>Equipe</th>
						<th>Résultat</th>
						<?php
						if ($_SESSION['com_num_privilege'] == 2)
						{
							?>
							<th>Action</th>
							<?php
						}
						?>
					</thead>

					<tr class="text-center">
						<td>
							<?php
							//	on récupère toutes les lignes de la table Compte
							$resultat = $cnx->prepare("select equi_id, equi_nom from equipe where equi_id not in (select par_equipe from participer where par_jeu = :par_jeu)");
							$resultat->bindValue(':par_jeu', $id, PDO::PARAM_INT);
							$resultat->execute();
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							$Chaine = "";
							$Select='<select class="form-control" name="equipe">';
							// tant qu'il y a des niveaux
							while ($ligne = $resultat->fetch())	{
								$Chaine = $Chaine."<option value=".$ligne->equi_id.">".utf8_encode($ligne->equi_nom)."</option>";
							}
							echo $Select.$Chaine.'</select>';
							?>
						</td>
						<td>
							<input class="form-control" type="number" name="resultat" id="resultat" min="0" max="10" value="0">
						</td>
						<?php
						if ($_SESSION['com_num_privilege'] == 2)
						{
							?>
							<td></td>
							<?php
						}
						?>
					</tr>

					<?php
					// exécution de la requête  et récupération des données extraites
					$resultat = $cnx->prepare("select par_equipe, equi_nom, par_nb_point from participer, equipe where par_equipe = equi_id and par_jeu = :par_jeu order by par_nb_point DESC");
					$resultat->bindValue(':par_jeu', $id, PDO::PARAM_INT);
					$resultat->execute();
					$resultat->setFetchMode(PDO::FETCH_OBJ);

					// lecture de la première ligne du jeu d'enregistrements
					$ligne = $resultat->fetch();
					$i = 0;
					// tant qu'il y a des lignes à lire
					while($ligne) { ?>
						<tr class="text-center">
							<td><?php echo $ligne->equi_nom ?></td>
							<td><?php echo $ligne->par_nb_point ?></td>
							<?php
							if ($_SESSION['com_num_privilege'] == 2)
							{
								?>
								<td>
									<input class="btn btn-danger btn-sm" type="button" value="Supprimer" onclick="remove('<?php echo $ligne->par_equipe ?>');">
								</td>
								<?php
							}
							?>
						</tr>
						<?php
						$i++;
						// lecture de la ligne suivante
						$ligne = $resultat->fetch();
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

		<script>
		function remove(unId) {
			if (confirm('Etes-vous sûr de vouloir supprimer ?'))
			{
				document.location.href="jeu_validation.php?id=<?php echo $id ?>&action=jeu_b&equi_id=" + unId;
			}
		}
		</script>
	</body>
</html>
