<?php session_start();?>
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
				<h1>Réinitialisation</h1>

				</br></br>

	      <p>
	        La réinitialisation supprimera tous les matchs et les participations aux jeux bonus des équipes.
	        </br>
	        Le classement général et les plannings seront donc vidé.
	        </br></br>
	        La réinitialisation conservera les comptes, les jeux et les équipes.
	        </br></br>
	        La réinitialisation requiert le mot de passe administrateur.
	      <p>
			</div>

			<div class="mx-auto mt-5 text-center" style="width : 20%;">
	      <form action="reinitialisation_action.php" role="form" method="post">
					<div class="form-group">
						<label for="pwd">Mot de passe</label>
						<input class="form-control" type="password" name='mdp' id="pwd" width="200px"/>
					</div>

	        </br>

					<button type="submit" class="btn btn-info" onClick="return confirm('Etes-vous sûr de vouloir effectuer une réinitialisation ?');">Réinitialiser</button>
	      </form>
			</div>


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
	</body>
</html>
