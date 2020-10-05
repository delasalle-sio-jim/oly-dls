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
      $lesJeux = $dao->getLesJeuxNormaux();

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
            "reponse": "3 jeu(x).",
            "donnees": {
                "lesJeux": [
                    {
                        "jeu_id": "1",
                        "jeu_nom": "Chamboultout",
                        "jeu_regle": "D?gommer le plus de bo?tes possible. 2 ?quipes, 3 tireurs par ?quipe et 3 tirs par tireur. L'?quipe qui d?gomme le plus de boite remporte l'?preuve.",
                        "jeu_type": "N"
                    },
                    {
                        "jeu_id": "2",
                        "jeu_nom": "Bouteille perc\u00e9e",
                        "jeu_regle": "Course relai. Transporter de l'eau d'un bac ? l'autre avec une bouteille perc?e. 2 ?quipes face ? face, 7 participants par ?quipe. L'?quipe qui a le bac le plus rempli remporte l'?preuve",
                        "jeu_type": "N"
                    },
                    {
                        "jeu_id": "3",
                        "jeu_nom": "Tir \u00e0 la corde",
                        "jeu_regle": "2 ?quipes tirent, chacun de leur c?t?, sur une m?me corde. Une limite centrale d?marque chaque c?t?. L'?quipe qui parvient a tirer l'autre de son c?t? ? gagn?. Si une ?quipe tombe, elle perd",
                        "jeu_type": "N"
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
