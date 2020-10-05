<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesEquipes = array();

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
      $lesEquipes = $dao->getLesAbsentJeuBonus($jeu_id);

      $nbReponses = sizeof($lesEquipes);

      if ($nbReponses == 0) {
        $msg = "Aucune équipe.";
        $code_reponse = 200;
      }
      else {
        $msg = $nbReponses . " équipe(s).";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesEquipes);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesEquipes)
{
    /* Exemple de code JSON
    {
        "data": {
            "reponse": "3 \u00e9quipe(s).",
            "donnees": {
                "lesEquipes": [
                    {
                        "equi_id": "5",
                        "equi_nom": "SIO5"
                    },
                    {
                        "equi_id": "6",
                        "equi_nom": "CG1"
                    },
                    {
                        "equi_id": "7",
                        "equi_nom": "CG2"
                    }
                ]
            }
        }
    }
     */

     if (sizeof($lesEquipes) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
       $lesObjetsDuTableau = array();
       foreach ($lesEquipes as $uneEquipe)
       {
         $unObjetEquipe = array();
         $unObjetEquipe["equi_id"] = $uneEquipe->getIdEquipe();
         $unObjetEquipe["equi_nom"] = $uneEquipe->getNomEquipe();
         $lesObjetsDuTableau[] = $unObjetEquipe;
       }
       $elt_equipe = ["lesEquipes" => $lesObjetsDuTableau];

       // construction de l'élément "data"
       $elt_data = ["reponse" => $msg, "donnees" => $elt_equipe];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
