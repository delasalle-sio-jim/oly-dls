<?php
// inclusion des paramètres de l'application
include_once ('parametres.php');

include_once('Match.class.php');
include_once('Equipe.class.php');
include_once('Jeu.class.php');
include_once('Score.class.php');
include_once('Participation.class.php');

// début de la classe DAO (Data Access Object)
class DAO
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------

    private $cnx;				// la connexion à la base de données

    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Constructeur et destructeur ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    public function __construct() {
        global $HOTE, $PORT, $BDD, $USER, $PWD;
        try
        {	$this->cnx = new PDO ("mysql:host=" . $HOTE . ";port=" . $PORT . ";dbname=" . $BDD,
            $USER,
            $PWD);
        return true;
        }
        catch (Exception $ex)
        {	echo ("Echec de la connexion a la base de donnees <br>");
        echo ("Erreur numero : " . $ex->getCode() . "<br />" . "Description : " . $ex->getMessage() . "<br>");
        echo ("PARAM_HOTE = " . $HOTE);
        return false;
        }
    }

    public function __destruct() {
        // ferme la connexion à MySQL :
        unset($this->cnx);
    }

    // ------------------------------------------------------------------------------------------------------
    // -------------------------------------- Méthodes d'instances ------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    // fournit le niveau (0, 1 ou 2) d'un utilisateur identifié par $pseudo et $mdpSha1
    // cette fonction renvoie un entier :
    //     0 : authentification incorrecte
    //     1 : authentification correcte d'un utilisateur
    //     2 : authentification correcte d'un administrateur
    public function getNiveauConnexion($login, $mdp) {
        // préparation de la requête de recherche
        $txt_req = "Select com_num_privilege from compte";
        $txt_req .= " where com_login = :com_login";
        $txt_req .= " and com_mdp = :com_mdp";
        $req = $this->cnx->prepare($txt_req);
        // liaison de la requête et de ses paramètres
        $req->bindValue("com_login", $login, PDO::PARAM_STR);
        $req->bindValue("com_mdp", $mdp, PDO::PARAM_STR);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        // traitement de la réponse
        $reponse = 0;
        if ($uneLigne) {
        	$reponse = $uneLigne->com_num_privilege;
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la réponse
        return $reponse;
    }

    // Retourne les logins
    public function getLesLogins() {
        // préparation de la requête de recherche
        $txt_req = "Select com_login";
        $txt_req .= " from compte";
        $txt_req .= " order by com_login";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesLogins = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $lesLogins[] = utf8_encode($uneLigne->com_login);
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesLogins;
    }

    // Retourne les matchs d'un jeu en particulier
    public function getLePlanningJeu($jeu_id) {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from planning";
        $txt_req .= " where jeu_id = :jeu_id";
        $txt_req .= " order by hor_heure, equi_id";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':jeu_id', $jeu_id, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesMatchs = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $equi_id = $uneLigne->equi_id;
            $equi_nom = $uneLigne->equi_nom;
            $jeu_id = $uneLigne->jeu_id;
            $jeu_nom = utf8_encode($uneLigne->jeu_nom);
            $hor_id = $uneLigne->hor_id;
            $hor_heure = $uneLigne->hor_heure;

            $unMatch = new Match($equi_id, $equi_nom, $jeu_id, $jeu_nom, $hor_id, $hor_heure, null);
            $lesMatchs[] = $unMatch;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesMatchs;
    }

    // Retourne les matchs d'une équipe en particulier
    public function getLePlanningEquipe($equi_id) {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from planning";
        $txt_req .= " where equi_id = :equi_id";
        $txt_req .= " order by hor_heure";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':equi_id', $equi_id, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesMatchs = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $equi_id = $uneLigne->equi_id;
            $equi_nom = $uneLigne->equi_nom;
            $jeu_id = $uneLigne->jeu_id;
            $jeu_nom = utf8_encode($uneLigne->jeu_nom);
            $hor_id = $uneLigne->hor_id;
            $hor_heure = $uneLigne->hor_heure;

            $unMatch = new Match($equi_id, $equi_nom, $jeu_id, $jeu_nom, $hor_id, $hor_heure, null);
            $lesMatchs[] = $unMatch;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesMatchs;
    }

    // Retourne toutes les équipes
    public function getLesEquipes() {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from equipe";
        $txt_req .= " order by equi_nom";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesEquipes = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $equi_id = $uneLigne->equi_id;
            $equi_nom = $uneLigne->equi_nom;

            $uneEquipe = new Equipe($equi_id, $equi_nom);
            $lesEquipes[] = $uneEquipe;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesEquipes;
    }

    // Retourne un jeu
    public function getUnJeu($jeu_id) {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from jeu";
        $txt_req .= " where jeu_id = :jeu_id";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':jeu_id', $jeu_id, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $unJeu = null;

        if ($uneLigne)
        {
          $jeu_id = $uneLigne->jeu_id;
          $jeu_nom = utf8_encode($uneLigne->jeu_nom);
          $jeu_regle = utf8_encode($uneLigne->jeu_regle);
          $jeu_type = $uneLigne->jeu_type;

          $unJeu = new Jeu($jeu_id, $jeu_nom, $jeu_regle, $jeu_type);
        }

        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $unJeu;
    }

    // Retourne la liste des jeux normaux
    public function getLesJeuxNormaux() {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from jeu";
        $txt_req .= " where jeu_type = 'N'";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesJeux = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
          $jeu_id = $uneLigne->jeu_id;
          $jeu_nom = utf8_encode($uneLigne->jeu_nom);
          $jeu_regle = utf8_encode($uneLigne->jeu_regle);
          $jeu_type = $uneLigne->jeu_type;

          $unJeu = new Jeu($jeu_id, $jeu_nom, $jeu_regle, $jeu_type);
          $lesJeux[] = $unJeu;
          // extrait la ligne suivante
          $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesJeux;
    }

    // Retourne la liste des jeux bonus
    public function getLesJeuxBonus() {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from jeu";
        $txt_req .= " where jeu_type = 'B'";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesJeux = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
          $jeu_id = $uneLigne->jeu_id;
          $jeu_nom = utf8_encode($uneLigne->jeu_nom);
          $jeu_regle = utf8_encode($uneLigne->jeu_regle);
          $jeu_type = $uneLigne->jeu_type;

          $unJeu = new Jeu($jeu_id, $jeu_nom, $jeu_regle, $jeu_type);
          $lesJeux[] = $unJeu;
          // extrait la ligne suivante
          $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesJeux;
    }
    
    // Retourne la liste des jeux
    public function getLesJeux() {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from jeu";
        $txt_req .= " order by jeu_type DESC, jeu_nom";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesJeux = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
          $jeu_id = $uneLigne->jeu_id;
          $jeu_nom = utf8_encode($uneLigne->jeu_nom);
          $jeu_regle = utf8_encode($uneLigne->jeu_regle);
          $jeu_type = $uneLigne->jeu_type;

          $unJeu = new Jeu($jeu_id, $jeu_nom, $jeu_regle, $jeu_type);
          $lesJeux[] = $unJeu;
          // extrait la ligne suivante
          $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesJeux;
    }

    // Retourne le score de chaque équipe dans l'ordre du meilleur au pire
    public function getLeClassement() {
        // préparation de la requête de recherche
        $txt_req = "Select *";
        $txt_req .= " from classement_general";
        $txt_req .= " ORDER BY resultat DESC";

        $req = $this->cnx->prepare($txt_req);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $leClassement = array();
        $numero = 1;
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
          $classement = $numero;
          $equi_id = $uneLigne->equi_id;
          $equi_nom = $uneLigne->equi_nom;
          $resultat = $uneLigne->resultat;
          $jeu_normal_effectue = $uneLigne->jeu_normal_effectue;
          $jeu_bonus_effectue = $uneLigne->jeu_bonus_effectue;

          $unScore = new Score($classement, $equi_id, $equi_nom, $resultat, $jeu_normal_effectue, $jeu_bonus_effectue);
          $leClassement[] = $unScore;
          // extrait la ligne suivante
          $uneLigne = $req->fetch(PDO::FETCH_OBJ);
          $numero++;
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $leClassement;
    }

    // Retourne la liste des équipes n'ayant pas participer au jeu bonus passé en paramètre.
    public function getLesAbsentJeuBonus($par_jeu) {
        // préparation de la requête de recherche
        $txt_req = "select equi_id, equi_nom";
        $txt_req .= " from equipe";
        $txt_req .= " where equi_id not in (";
          $txt_req .= " select par_equipe";
          $txt_req .= " from participer";
          $txt_req .= " where par_jeu = :par_jeu)";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':par_jeu', $par_jeu, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesEquipes = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $equi_id = $uneLigne->equi_id;
            $equi_nom = $uneLigne->equi_nom;

            $uneEquipe = new Equipe($equi_id, $equi_nom);
            $lesEquipes[] = $uneEquipe;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesEquipes;
    }

    // Retourne les participations à un jeu bonus
    public function getLesParticipationsBonus($par_jeu) {
        // préparation de la requête de recherche
        $txt_req = "select par_jeu, par_equipe, equi_nom, par_nb_point";
        $txt_req .= " from participer, equipe";
        $txt_req .= " where par_equipe = equi_id and par_jeu = :par_jeu";
        $txt_req .= " order by par_nb_point DESC";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':par_jeu', $par_jeu, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesParticipations = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $par_equipe = $uneLigne->par_equipe;
            $equi_nom = $uneLigne->equi_nom;
            $par_jeu = $uneLigne->par_jeu;
            $par_nb_point = $uneLigne->par_nb_point;

            $uneParticipation = new Participation($par_equipe, $equi_nom, $par_jeu, null, $par_nb_point);
            $lesParticipations[] = $uneParticipation;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesParticipations;
    }

    // Update le résultat d'un match
    public function updateResultatMatch($mat_equipe, $mat_jeu, $mat_nb_point) {
        // préparation de la requête de recherche
        $txt_req = "update corewqqc_oly_dls_bdd.match";
        $txt_req .= " set mat_nb_point = :mat_nb_point";
        $txt_req .= " where mat_equipe = :mat_equipe and mat_jeu = :mat_jeu";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':mat_equipe', $mat_equipe, PDO::PARAM_INT);
        $req->bindValue(':mat_jeu', $mat_jeu, PDO::PARAM_INT);
        $req->bindValue(':mat_nb_point', $mat_nb_point, PDO::PARAM_INT);
        // exécution de la requête
        $ok = $req->execute();
        return $ok;
    }

    // Ajoute une participation
    public function ajouterUneParticipation($par_jeu, $par_equipe, $par_nb_point) {
        // préparation de la requête de recherche
        $txt_req = "insert into participer";
        $txt_req .= " values (:par_jeu, :par_equipe, :par_nb_point)";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':par_jeu', $par_jeu, PDO::PARAM_INT);
        $req->bindValue(':par_equipe', $par_equipe, PDO::PARAM_INT);
        $req->bindValue(':par_nb_point', $par_nb_point, PDO::PARAM_INT);
        // exécution de la requête
        $ok = $req->execute();
        return $ok;
    }

    // Supprimer une participation
    public function supprimerUneParticipation($par_jeu, $par_equipe) {
        // préparation de la requête de recherche
        $txt_req = "delete from participer";
        $txt_req .= " where par_jeu = :par_jeu AND par_equipe = :par_equipe";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':par_jeu', $par_jeu, PDO::PARAM_INT);
        $req->bindValue(':par_equipe', $par_equipe, PDO::PARAM_INT);
        // exécution de la requête
        $ok = $req->execute();
        return $ok;
    }

    // Retourne LesResultatDesMatchDunJeu
    public function getLesMatchs($mat_jeu) {
        // préparation de la requête de recherche
        $txt_req = "select mat_equipe, mat_nb_point";
        $txt_req .= " from corewqqc_oly_dls_bdd.match";
        $txt_req .= " where mat_jeu = :mat_jeu";

        $req = $this->cnx->prepare($txt_req);
        $req->bindValue(':mat_jeu', $mat_jeu, PDO::PARAM_INT);
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);

        $lesMatchs = array();
        // tant qu'une ligne est trouvée :
        while ($uneLigne) {
            $mat_equipe = $uneLigne->mat_equipe;
            $mat_nb_point = $uneLigne->mat_nb_point;

            $unMatch = new Match($mat_equipe, null, $mat_jeu, null, null, null, $mat_nb_point);
            $lesMatchs[] = $unMatch;
            // extrait la ligne suivante
            $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la collection
        return $lesMatchs;
    }
} // fin de la classe DAO
