<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesScores = array();

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
      $lesMatchs = $dao->getLesMatchs($jeu_id);

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
                  "lesScores": [
                      {
                          "equi_id": "1",
                          "jeu_id": "1",
                          "nb_point": "10"
                      },
                      {
                          "equi_id": "2",
                          "jeu_id": "1",
                          "nb_point": "5"
                      },
                      {
                          "equi_id": "3",
                          "jeu_id": "1",
                          "nb_point": "0"
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
         $unObjetMatch["jeu_id"] = $unMatch->getIdJeu();
         $unObjetMatch["nb_point"] = $unMatch->getNbPoint();
         $lesObjetsDuTableau[] = $unObjetMatch;
       }
       $elt_match = ["lesScores" => $lesObjetsDuTableau];

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
