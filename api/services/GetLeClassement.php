<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesScores = array();

// Récupération des données transmises
$login = (empty($this->request['pseudo'])) ? "" : $this->request['pseudo'];
$mdp = (empty($this->request['mdp'])) ? "" : $this->request['mdp'];

// La méthode HTTP utilisée doit être GET
if ($this->getMethodeRequete() != "GET")
{	$msg = "Erreur : méthode HTTP incorrecte.";
    $code_reponse = 406;
}
else {
  // Les paramètres doivent être présents
  if ($login == "" || $mdp == "")
  {	$msg = "Erreur : données incomplètes.";
      $code_reponse = 400;
  }
  else
  {
    if($dao->getNiveauConnexion($login, $mdp) != 2)
    {
      $msg = "Erreur : authentification incorrecte ou compte administrateur requis.";
          $code_reponse = 401;
    }
    else
    {
      $lesScores = $dao->getLeClassement();

      $nbReponses = sizeof($lesScores);

      if ($nbReponses == 0) {
        $msg = "Aucun score.";
        $code_reponse = 200;
      }
      else {
        $msg = $nbReponses . " score(s).";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesScores);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesScores)
{
    /* Exemple de code JSON
    {
        "data": {
            "reponse": "7 score(s).",
            "donnees": {
                "lesScores": [
                    {
                        "classement": 1,
                        "equi_id": "1",
                        "equi_nom": "SIO1",
                        "resultat": "18",
                        "jeu_normal_effectue": "2",
                        "jeu_bonus_effectue": "2"
                    },
                    {
                        "classement": 2,
                        "equi_id": "4",
                        "equi_nom": "SIO4",
                        "resultat": "9",
                        "jeu_normal_effectue": "0",
                        "jeu_bonus_effectue": "1"
                    },
                    {
                        "classement": 3,
                        "equi_id": "2",
                        "equi_nom": "SIO2",
                        "resultat": "9",
                        "jeu_normal_effectue": "1",
                        "jeu_bonus_effectue": "1"
                    },
                    {
                        "classement": 4,
                        "equi_id": "3",
                        "equi_nom": "SIO3",
                        "resultat": "7",
                        "jeu_normal_effectue": "1",
                        "jeu_bonus_effectue": "1"
                    },
                    {
                        "classement": 5,
                        "equi_id": "6",
                        "equi_nom": "CG1",
                        "resultat": "0",
                        "jeu_normal_effectue": "0",
                        "jeu_bonus_effectue": "0"
                    },
                    {
                        "classement": 6,
                        "equi_id": "7",
                        "equi_nom": "CG2",
                        "resultat": "0",
                        "jeu_normal_effectue": "0",
                        "jeu_bonus_effectue": "0"
                    },
                    {
                        "classement": 7,
                        "equi_id": "5",
                        "equi_nom": "SIO5",
                        "resultat": "0",
                        "jeu_normal_effectue": "0",
                        "jeu_bonus_effectue": "0"
                    }
                ]
            }
        }
    }
     */

     if (sizeof($lesScores) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
       $lesObjetsDuTableau = array();
       foreach ($lesScores as $unScore)
       {
         $unObjetScore = array();
         $unObjetScore["classement"] = $unScore->getClassement();
         $unObjetScore["equi_id"] = $unScore->getIdEquipe();
         $unObjetScore["equi_nom"] = $unScore->getNomEquipe();
         $unObjetScore["resultat"] = $unScore->getResultat();
         $unObjetScore["jeu_normal_effectue"] = $unScore->getJeuNormalEffectue();
         $unObjetScore["jeu_bonus_effectue"] = $unScore->getJeuBonusEffectue();
         $lesObjetsDuTableau[] = $unObjetScore;
       }
       $elt_score = ["lesScores" => $lesObjetsDuTableau];

       // construction de l'élément "data"
       $elt_data = ["reponse" => $msg, "donnees" => $elt_score];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
