<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesParticipations = array();

// Récupération des données transmises
$login = (empty($this->request['pseudo'])) ? "" : $this->request['pseudo'];
$mdp = (empty($this->request['mdp'])) ? "" : $this->request['mdp'];
$jeu_id = (empty($this->request['id'])) ? "" : $this->request['id'];

// La méthode HTTP utilisée doit être GET
if ($this->getMethodeRequete() != "GET")
{	$msg = "Erreur : méthode HTTP incorrecte.";
    $code_reponse = 406;
}
else {
  // Les paramètres doivent être présents
  if ($login == "" || $mdp == "" || $jeu_id == "")
  {	$msg = "Erreur : données incomplètes.";
      $code_reponse = 400;
  }
  else
  {
    if($dao->getNiveauConnexion($login, $mdp) == 0)
    {
      $msg = "Erreur : authentification incorrecte.";
          $code_reponse = 401;
    }
    else
    {
      $lesParticipations = $dao->getLesParticipationsBonus($jeu_id);

      $nbReponses = sizeof($lesParticipations);

      if ($nbReponses == 0) {
        $msg = "Aucune participation.";
        $code_reponse = 200;
      }
      else {
        $msg = $nbReponses . " participation(s).";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesParticipations);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesParticipations)
{
    /* Exemple de code JSON
    {
        "data": {
            "reponse": "4 participation(s).",
            "donnees": {
                "lesParticipations": [
                    {
                        "par_jeu": "4",
                        "par_equipe": "4",
                        "equi_nom": "SIO4",
                        "par_nb_point": "9"
                    },
                    {
                        "par_jeu": "4",
                        "par_equipe": "3",
                        "equi_nom": "SIO3",
                        "par_nb_point": "7"
                    },
                    {
                        "par_jeu": "4",
                        "par_equipe": "2",
                        "equi_nom": "SIO2",
                        "par_nb_point": "4"
                    },
                    {
                        "par_jeu": "4",
                        "par_equipe": "1",
                        "equi_nom": "SIO1",
                        "par_nb_point": "3"
                    }
                ]
            }
        }
    }
     */

     if (sizeof($lesParticipations) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
       $lesObjetsDuTableau = array();
       foreach ($lesParticipations as $uneParticipation)
       {
         $unObjetParticipation = array();
         $unObjetParticipation["par_jeu"] = $uneParticipation->getIdJeu();
         $unObjetParticipation["par_equipe"] = $uneParticipation->getIdEquipe();
         $unObjetParticipation["equi_nom"] = $uneParticipation->getNomEquipe();
         $unObjetParticipation["par_nb_point"] = $uneParticipation->getNbPoint();
         $lesObjetsDuTableau[] = $unObjetParticipation;
       }
       $elt_participation = ["lesParticipations" => $lesObjetsDuTableau];

       // construction de l'élément "data"
       $elt_data = ["reponse" => $msg, "donnees" => $elt_participation];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
