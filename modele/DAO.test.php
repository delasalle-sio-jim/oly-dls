<?php
// Projet TraceGPS
// fichier : modele/DAO.test.php
// Rôle : test de la classe DAO.class.php
// Dernière mise à jour : 7/10/2019 par JM CARTRON
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Test de la classe DAO</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
// connexion du serveur web à la base MySQL
include_once ('DAO.class.php');
//include_once ('_DAO.mysql.class.php');
$dao = new DAO();

/*
// FONCTIONNEL
// test de la méthode getNiveauConnexion ----------------------------------------------------------
echo "<h3>Test de getNiveauConnexion : </h3>";
$niveau = $dao->getNiveauConnexion("Administrateur", "admin");
echo "<p>Niveau de ('Administrateur', 'admin') : " . $niveau . "</br>";

$niveau = $dao->getNiveauConnexion("Professeur", "prof");
echo "<p>Niveau de ('Professeur', 'prof') : " . $niveau . "</br>";

$niveau = $dao->getNiveauConnexion("titi", "123456");
echo "<p>Niveau de ('toto', '123456') : " . $niveau . "</br>";
*/


/*
// FONCTIONNEL
// test de la méthode getLesLogins -----------------------------------------------------------
echo "<h3>Test de getLesLogins : </h3>";
$lesLogins = $dao->getLesLogins();
foreach ($lesLogins as $value) {
	echo $value . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLePlanningJeu -----------------------------------------------------------
echo "<h3>Test de getLePlanningJeu : </h3>";
$lesMatchs = $dao->getLePlanningJeu(1);
foreach ($lesMatchs as $value) {
	echo $value->getIdEquipe() . ' ' .
	 $value->getNomEquipe() . ' ' .
	 $value->getIdJeu() . ' ' .
	 $value->getNomJeu() . ' ' .
	 $value->getIdHor() . ' ' .
	 $value->getHeureHor() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLePlanningEquipe -----------------------------------------------------------
echo "<h3>Test de getLePlanningEquipe : </h3>";
$lesMatchs = $dao->getLePlanningEquipe(1);
foreach ($lesMatchs as $value) {
	echo $value->getIdEquipe() . ' ' .
	 $value->getNomEquipe() . ' ' .
	 $value->getIdJeu() . ' ' .
	 $value->getNomJeu() . ' ' .
	 $value->getIdHor() . ' ' .
	 $value->getHeureHor() . ' ' . '</br>';
}
*/


// FONCTIONNEL
// test de la méthode getLesEquipes -----------------------------------------------------------
/*echo "<h3>Test de getLePlanningEquipe : </h3>";
$lesEquipes = $dao->getLesEquipes();
foreach ($lesEquipes as $equipe) {
	echo $equipe->getIdEquipe() . ' ' .
	 $equipe->getNomEquipe() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getUnJeu -----------------------------------------------------------
echo "<h3>Test de getUnJeu : </h3>";
$unJeu = $dao->getUnJeu(1);

echo $unJeu->getIdJeu() . ' ' .
	$unJeu->getNomJeu() . ' ' .
	$unJeu->getRegleJeu() . ' ' .
	$unJeu->getTypeJeu();
*/

/*
// FONCTIONNEL
// test de la méthode getLesJeuxNormaux -----------------------------------------------------------
echo "<h3>Test de getLesJeuxNormaux : </h3>";
$lesJeux = $dao->getLesJeuxNormaux();
foreach ($lesJeux as $unJeu) {
	echo $unJeu->getIdJeu() . ' ' .
		$unJeu->getNomJeu() . ' ' .
		$unJeu->getRegleJeu() . ' ' .
		$unJeu->getTypeJeu() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLesJeuxBonus -----------------------------------------------------------
echo "<h3>Test de getLesJeuxBonus : </h3>";
$lesJeux = $dao->getLesJeuxBonus();
foreach ($lesJeux as $unJeu) {
	echo $unJeu->getIdJeu() . ' ' .
		$unJeu->getNomJeu() . ' ' .
		$unJeu->getRegleJeu() . ' ' .
		$unJeu->getTypeJeu() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLeClassement -----------------------------------------------------------
echo "<h3>Test de getLeClassement : </h3>";
$leClassement = $dao->getLeClassement();
foreach ($leClassement as $unScore) {
	echo $unScore->getClassement() . ' ' .
		$unScore->getIdEquipe() . ' ' .
		$unScore->getNomEquipe() . ' ' .
		$unScore->getResultat() . ' ' .
		$unScore->getJeuNormalEffectue() . ' ' .
		$unScore->getJeuBonusEffectue() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLesAbsentJeuBonus -----------------------------------------------------------
echo "<h3>Test de getLesAbsentJeuBonus : </h3>";
$lesEquipes = $dao->getLesAbsentJeuBonus(5);
foreach ($lesEquipes as $equipe) {
	echo $equipe->getIdEquipe() . ' ' .
	 $equipe->getNomEquipe() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL
// test de la méthode getLesParticipationsBonus -----------------------------------------------------------
echo "<h3>Test de getLesParticipationsBonus : </h3>";
$lesParticipations = $dao->getLesParticipationsBonus(4);
foreach ($lesParticipations as $participation) {
	echo $participation->getIdEquipe() . ' ' .
	 $participation->getIdJeu() . ' ' .
	 $participation->getNomJeu() . ' ' .
	 $participation->getNbPoint() . ' ' .
	 $participation->getNomEquipe() . ' ' . '</br>';
}
*/

/*
// FONCTIONNEL & Résultat correct dans la bdd
// test de la méthode updateResultatMatch -----------------------------------------------------------
echo "<h3>Test de updateResultatMatch : </h3>";
$ok = $dao->updateResultatMatch(1, 1, 0);
echo $ok;
*/

/*
// FONCTIONNEL & Résultat correct dans la bdd
// test de la méthode ajouterUneParticipation -----------------------------------------------------------
echo "<h3>Test de ajouterUneParticipation : </h3>";
$ok = $dao->ajouterUneParticipation(5, 2, 1);
echo $ok;
*/

/*
// FONCTIONNEL & Résultat correct dans la bdd
// test de la méthode supprimerUneParticipation -----------------------------------------------------------
echo "<h3>Test de supprimerUneParticipation : </h3>";
$ok = $dao->supprimerUneParticipation(5, 2);
echo $ok;
*/


// FONCTIONNEL
// test de la méthode getLesResultatDesMatchDunJeu -----------------------------------------------------------
/*echo "<h3>Test de getLesResultatDesMatchDunJeu : </h3>";
$lesMatchs = $dao->getLesResultatDesMatchDunJeu(1);
foreach ($lesMatchs as $match) {
	echo $match->getIdEquipe() . ' ' .
	 $match->getIdJeu() . ' ' .
	 $match->getNbPoint() . ' ' . '</br>';
}
*/

// ferme la connexion à MySQL :
unset($dao);
?>
ok
</body>
</html>
