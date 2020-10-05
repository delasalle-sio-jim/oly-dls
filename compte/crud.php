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

		if (isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2 && isset($_GET['type']))
		{
      ?>
			<div class="mx-auto mt-5 text-center" style="width : 100%;">
				<h1>Gestion <?php echo ucfirst($_GET['type']) ?></h1>
			</div>

      <?php
      if ($_GET['type'] == 'compte')
      {
				?>
				<form action="crud_action.php?type=<?php echo $_GET['type'] ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
					<div class="mx-auto mt-5" style="width : 70%;">
						<button class="btn btn-info" type="button" id="add">Ajouter un compte</button>

						<table class="table table-striped mt-3" id="table">
							<thead>
								<th>Login</th>
								<th>Mot de passe</th>
								<th>Privilège</th>
								<th>Action</th>
							</thead>

							<?php
							// exécution de la requête  et récupération des données extraites
							$resultat = $cnx->query("select * from compte order by com_num_privilege DESC, com_login");
							$resultat->execute();
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							// lecture de la première ligne du jeu d'enregistrements
							$ligne = $resultat->fetch();

							// tant qu'il y a des lignes à lire
							while($ligne) { ?>
								<input name="id[]" type ="hidden" value="<?php echo $ligne->com_id ?>"/>
								<tr>
									<td><input class="form-control" name="login[]" value="<?php echo utf8_decode($ligne->com_login) ?>"/></td>
									<td><input class="form-control" name="mdp[]" value="<?php echo utf8_decode($ligne->com_mdp) ?>"/></td>
									<td><input class="form-control" name="priv[]" type="number" value="<?php echo $ligne->com_num_privilege ?>" min="0" max="2"/></td>
									<td>
										<input class="btn btn-danger btn-sm" type="button" value="Supprimer" onclick="remove('<?php echo $ligne->com_id ?>');">
									</td>
								</tr>
								<?php
								// lecture de la ligne suivante
								$ligne = $resultat->fetch();
							}

							// fermeture du curseur associé à un jeu de résultats
							$resultat->closeCursor(); ?>
						</table>
					</div>

					<div class="mx-auto mt-5 text-center" style="width : 100%;">
						<button class="btn btn-info" type="submit" onClick="return confirm('Etes-vous sûr de vouloir sauvegarder ?');">Sauvegarder</button>
					</div>
				</form>
				<?php
      }
      else if ($_GET['type'] == 'jeu')
      {
				?>
				<form action="crud_action.php?type=<?php echo $_GET['type'] ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
					<div class="mx-auto mt-5" style="width : 70%;">
						<button class="btn btn-info" type="button" id="add">Ajouter un jeu</button>

						<table class="table table-striped mt-3" id="table">
							<thead>
								<th>Nom</th>
								<th>Règles</th>
								<th>Type</th>
								<th>Action</th>
							</thead>

							<?php
							// exécution de la requête  et récupération des données extraites
							$resultat = $cnx->query("select * from jeu order by jeu_type DESC, jeu_nom");
							$resultat->execute();
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							// lecture de la première ligne du jeu d'enregistrements
							$ligne = $resultat->fetch();

							// tant qu'il y a des lignes à lire
							while($ligne) { ?>
								<input name="id[]" type ="hidden" value="<?php echo $ligne->jeu_id ?>"/>
								<tr>
									<td><input class="form-control" name="nom[]" value="<?php echo utf8_decode($ligne->jeu_nom) ?>"/></td>
									<td><input class="form-control" name="regle[]" value="<?php echo utf8_decode($ligne->jeu_regle) ?>"/></td>
									<td>
										<input class="form-control-radio" name="type[][<?php echo $ligne->jeu_id ?>]" type="radio" value="N" <?php if ($ligne->jeu_type == 'N') echo 'checked' ?>/> Normal
										<input class="form-control-radio" name="type[][<?php echo $ligne->jeu_id ?>]" type="radio" value="B" <?php if ($ligne->jeu_type == 'B') echo 'checked' ?>/> Bonus
									</td>
									<td>
										<input class="btn btn-danger btn-sm" type="button" value="Supprimer" onclick="remove('<?php echo $ligne->jeu_id ?>');">
									</td>
								</tr>
								<?php
								// lecture de la ligne suivante
								$ligne = $resultat->fetch();
							}

							// fermeture du curseur associé à un jeu de résultats
							$resultat->closeCursor(); ?>
						</table>
					</div>

					<div class="mx-auto mt-5 text-center" style="width : 100%;">
						<button class="btn btn-info" type="submit" onClick="return confirm('Etes-vous sûr de vouloir sauvegarder ?');">Sauvegarder</button>
					</div>
				</form>
				<?php
      }
      else if ($_GET['type'] == 'equipe')
      {
				?>
				<form action="crud_action.php?type=<?php echo $_GET['type'] ?>" name="score" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
					<div class="mx-auto mt-5" style="width : 70%;">
						<button class="btn btn-info" type="button" id="add">Ajouter une équipe</button>

						<table class="table table-striped mt-3" id="table">
							<thead>
								<th>Nom</th>
								<th>Action</th>
							</thead>

							<?php
							// exécution de la requête  et récupération des données extraites
							$resultat = $cnx->query("select * from equipe order by equi_nom");
							$resultat->execute();
							$resultat->setFetchMode(PDO::FETCH_OBJ);

							// lecture de la première ligne du jeu d'enregistrements
							$ligne = $resultat->fetch();

							// tant qu'il y a des lignes à lire
							while($ligne) { ?>
								<input name="id[]" type ="hidden" value="<?php echo $ligne->equi_id ?>"/>
								<tr>
									<td><input class="form-control" name="nom[]" value="<?php echo utf8_decode($ligne->equi_nom) ?>"/></td>
									<td>
										<input class="btn btn-danger btn-sm" type="button" value="Supprimer" onclick="remove('<?php echo $ligne->equi_id ?>');">
									</td>
								</tr>
								<?php
								// lecture de la ligne suivante
								$ligne = $resultat->fetch();
							}

							// fermeture du curseur associé à un jeu de résultats
							$resultat->closeCursor(); ?>
						</table>
					</div>

					<div class="mx-auto mt-3 text-center" style="width : 100%;">
						<button class="btn btn-info" type="submit" onClick="return confirm('Etes-vous sûr de vouloir sauvegarder ?');">Sauvegarder</button>
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
			document.getElementById('add').addEventListener('click', function(){
				<?php
					$i = 0;
				 	switch ($_GET['type']) {
				 		case 'compte':
							$i++;
				 			?>
							var nouvelleLigne = document.getElementById('table').insertRow(1);
							var cellLogin = nouvelleLigne.insertCell();
							var cellMdp = nouvelleLigne.insertCell();
							var cellPrivilege = nouvelleLigne.insertCell();
							var cellAction = nouvelleLigne.insertCell();

							var login = document.createElement("INPUT");
							login.setAttribute("name", "new_login[]");

							var mdp = document.createElement("INPUT");
							mdp.setAttribute("name", "new_mdp[]");

							var privilege = document.createElement("INPUT");
							privilege.setAttribute("type", "number");
							privilege.setAttribute("min", "0");
							privilege.setAttribute("max", "2");
							privilege.setAttribute("name", "new_priv[]");

							var suppr = document.createElement("INPUT");
							suppr.setAttribute("type", "button");
							suppr.setAttribute("value", "Supprimer");
							suppr.setAttribute("onclick", "remove(0);");
							suppr.setAttribute("id", "<?php echo $i ?>");

							cellLogin.appendChild(login);
							cellMdp.appendChild(mdp);
							cellPrivilege.appendChild(privilege);
							cellAction.appendChild(suppr);
							<?php
				 			break;

						case 'jeu':
							$i++;
							?>
							var nouvelleLigne = document.getElementById('table').insertRow(1);
							var cellNom = nouvelleLigne.insertCell();
							var cellRegle = nouvelleLigne.insertCell();
							var cellType = nouvelleLigne.insertCell();
							var cellAction = nouvelleLigne.insertCell();

							var nom = document.createElement("INPUT");
							nom.setAttribute("name", "new_nom[]");

							var regle = document.createElement("INPUT");
							regle.setAttribute("name", "new_regle[]");

							var type = document.createElement("INPUT");
							type.setAttribute("placeholder", "\"N\" ou \"B\"");
							type.setAttribute("name", "new_type[]");

							var suppr = document.createElement("INPUT");
							suppr.setAttribute("type", "button");
							suppr.setAttribute("value", "Supprimer");
							suppr.setAttribute("onclick", "remove(0);");
							suppr.setAttribute("id", "<?php echo $i ?>");

							cellNom.appendChild(nom);
							cellRegle.appendChild(regle);
							cellType.appendChild(type);
							cellAction.appendChild(suppr);
							<?php
							break;

						case 'equipe':
							$i++;
							?>
							var nouvelleLigne = document.getElementById('table').insertRow(1);
							var cellNom = nouvelleLigne.insertCell();
							var cellAction = nouvelleLigne.insertCell();

							var nom = document.createElement("INPUT");
							nom.setAttribute("name", "new_nom[]");

							var suppr = document.createElement("INPUT");
							suppr.setAttribute("type", "button");
							suppr.setAttribute("value", "Supprimer");
							suppr.setAttribute("onclick", "remove(0);");
							suppr.setAttribute("id", "<?php echo $i ?>");

							cellNom.appendChild(nom);
							cellAction.appendChild(suppr);
							<?php
							break;
				 	}
				?>
			});

			function remove(unId) {
				if (unId == 0)
				{
					if (confirm('Etes-vous sûr de vouloir supprimer ?'))
					{
						document.getElementById(<?php echo $i ?>).parentNode.parentNode.parentNode.removeChild(document.getElementById(<?php echo $i ?>).parentNode.parentNode);
					}
				}
				else
				{
					if (confirm('Etes-vous sûr de vouloir supprimer ?'))
					{
						document.location.href="crud_action.php?type=<?php echo $_GET['type'] ?>&action=del&id=" + unId;
					}
				}
			}
		</script>
	</body>
</html>
