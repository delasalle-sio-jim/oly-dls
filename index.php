<?php
include("include/_inc_parametres.php");
include("include/_inc_connexion.php");
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
		include("include/navbar.php");

		if(isset($_GET['action']) && $_GET['action'] == 1) {
			?>
			<div class="mx-auto mt-5" style="width : 40%;">
				<h3>
					<svg class="bi bi-unlock-fill" width="1.25em" height="1.25em" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					  <path d="M2.5 10a2 2 0 012-2h7a2 2 0 012 2v5a2 2 0 01-2 2h-7a2 2 0 01-2-2v-5z"/>
					  <path fill-rule="evenodd" d="M10.5 5a3.5 3.5 0 117 0v3h-1V5a2.5 2.5 0 00-5 0v3h-1V5z" clip-rule="evenodd"/>
					</svg>
					Connexion
				</h3>
				<form action="compte/loginok.php" name="login" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label for="identifiant">Identifiant</label>
						<?php
						//on récupère toutes les lignes de la table Compte
						$resultat = $cnx->query("select * FROM compte;");
						//le résultat est récupéré sous forme d'objet
						$resultat->setFetchMode(PDO::FETCH_OBJ);

						$Chaine = "";
						$Select='<select class="form-control" name="identifiant" id="identifiant">';

						while ($ligne = $resultat->fetch() )	{
							$Chaine = $Chaine."<option value=".$ligne->com_id.">".utf8_encode($ligne->com_login)."</option>";
						}
						echo $Select.$Chaine.'</select>';
						?>
					</div>
					<div class="form-group">
						<label for="pwd">Mot de passe</label>
						<input type="password" class="form-control" id="pwd" name="mdp" required>
					</div>
					<button type="submit" class="btn btn-info">Connexion</button>
				</form>
			</div>
			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<a href="index.php">Je suis un étudiant</a>
			</div>
			<?php
		}
		else {
			?>
			<div class="mx-auto mt-5" style="width : 40%;">
				<form action="planning/" name="login" role="form" class="form-horizontal" method="post" accept-charset="utf-8">

					<div class="form-group">
						<label for="identifiant">Equipe</label>
	 					<?php
							//	on récupère toutes les lignes de la table Compte
							$resultat = $cnx->query("select * FROM equipe;");
							//le résultat est récupéré sous forme d'objet
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							$Chaine = "";
							$Select='<select class="form-control" name="identifiant" id="identifiant">';
							// tant qu'il y a des niveaux
							while ($ligne = $resultat->fetch() )	{
								$Chaine = $Chaine."<option value=".$ligne->equi_id.">".utf8_encode($ligne->equi_nom)."</option>";
							}
							echo $Select.$Chaine.'</select>';
						?>
					</div>
					<button type="submit" class="btn btn-info">Voir le planning</button>
				</form>
			</div>
			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<a href="index.php?action=1">Je ne suis pas un étudiant</a>
			</div>
			<?php
		}
		?>
	</body>
</html>
