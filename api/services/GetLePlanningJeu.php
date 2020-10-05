<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesMatchs = array();

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
  if ($login == "" || $mdp == "" || $jeu_id =="")
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
      $lesMatchs = $dao->getLePlanningJeu($jeu_id);

      $nbReponses = sizeof($lesMatchs);

      if ($nbReponses == 0) {
        $msg = "Aucun match.";
        $code_reponse = 200;
      }
      else {
        $msg = $nbReponses . " match(s).";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesMatchs);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesMatchs)
{
    /* Exemple de code JSON
    {
        "data": {
            "reponse": "3 match(s).",
            "donnees": {
                "lesMatchs": [
                    {
                        "equi_id": "1",
                        "equi_nom": "SIO1",
                        "jeu_id": "1",
                        "jeu_nom": "Chamboultout",
                        "hor_id": "1",
                        "hor_heure": "10:00:00"
                    },
                    {
                        "equi_id": "2",
                        "equi_nom": "SIO2",
                        "jeu_id": "1",
                        "jeu_nom": "Chamboultout",
                        "hor_id": "1",
                        "hor_heure": "10:00:00"
                    },
                    {
                        "equi_id": "3",
                        "equi_nom": "SIO3",
                        "jeu_id": "1",
                        "jeu_nom": "Chamboultout",
                        "hor_id": "2",
                        "hor_heure": "10:15:00"
                    }
                ]
            }
        }
    }
     */

     if (sizeof($lesMatchs) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
         $lesObjetsDuTableau = array();
         foreach ($lesMatchs as $unMatch)
         {
           $unObjetMatch = array();
           $unObjetMatch["equi_id"] = $unMatch->getIdEquipe();
           $unObjetMatch["equi_nom"] = $unMatch->getNomEquipe();
           $unObjetMatch["jeu_id"] = $unMatch->getIdJeu();
           $unObjetMatch["jeu_nom"] = $unMatch->getNomJeu();
           $unObjetMatch["hor_id"] = $unMatch->getIdHor();
           $unObjetMatch["hor_heure"] = $unMatch->getHeureHor();
           $lesObjetsDuTableau[] = $unObjetMatch;
         }
         $elt_match = ["lesMatchs" => $lesObjetsDuTableau];

         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg, "donnees" => $elt_match];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
