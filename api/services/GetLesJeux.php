<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesJeux = array();

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
    if($dao->getNiveauConnexion($login, $mdp) == 0)
    {
      $msg = "Erreur : authentification incorrecte.";
          $code_reponse = 401;
    }
    else
    {
      $lesJeux = $dao->getLesJeux();

      $nbReponses = sizeof($lesJeux);

      if ($nbReponses == 0) {
        $msg = "Aucun jeu.";
        $code_reponse = 200;
      }
      else {
        $msg = $nbReponses . " jeu(x).";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesJeux);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesJeux)
{
    /* Exemple de code JSON
    // Ne pas faire attention à l'encodage :)
    {
        "data": {
            "reponse": "2 jeu(x).",
            "donnees": {
                "lesJeux": [
                    {
                        "jeu_id": "4",
                        "jeu_nom": "Quest-rep",
                        "jeu_regle": "R?pondre ? des questions de culture g?n?rale.",
                        "jeu_type": "B"
                    },
                    {
                        "jeu_id": "5",
                        "jeu_nom": "Molky",
                        "jeu_regle": "",
                        "jeu_type": "B"
                    }
                ]
            }
        }
    }
     */

     if (sizeof($lesJeux) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
       $lesObjetsDuTableau = array();
       foreach ($lesJeux as $unJeu)
       {
         $unObjetJeu = array();
         $unObjetJeu["jeu_id"] = $unJeu->getIdJeu();
         $unObjetJeu["jeu_nom"] = $unJeu->getNomJeu();
         $unObjetJeu["jeu_regle"] = $unJeu->getRegleJeu();
         $unObjetJeu["jeu_type"] = $unJeu->getTypeJeu();
         $lesObjetsDuTableau[] = $unObjetJeu;
       }
       $elt_jeu = ["lesJeux" => $lesObjetsDuTableau];

       // construction de l'élément "data"
       $elt_data = ["reponse" => $msg, "donnees" => $elt_jeu];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>