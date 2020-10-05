<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();
$unJeu = null;

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
      $unJeu = $dao->getUnJeu($jeu_id);

      if ($unJeu == null) {
        $msg = "Jeu non trouvé.";
        $code_reponse = 200;
      }
      else {
        $msg = "Jeu trouvé.";
        $code_reponse = 200;
      }
    }
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $unJeu);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $unJeu)
{
    /* Exemple de code JSON
    // Ne pas faire attention à l'encodage :)
    {
        "data": {
            "reponse": "Jeu trouv\u00e9.",
            "donnees": {
                "jeu_id": "2",
                "jeu_nom": "Bouteille perc\u00e9e",
                "jeu_regle": "Course relai. Transporter de l'eau d'un bac ? l'autre avec une bouteille perc?e. 2 ?quipes face ? face, 7 participants par ?quipe. L'?quipe qui a le bac le plus rempli remporte l'?preuve",
                "jeu_type": "N"
            }
        }
    }
     */

     if ($unJeu == null) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
         $unObjetJeu = array();
         $unObjetJeu["jeu_id"] = $unJeu->getIdJeu();
         $unObjetJeu["jeu_nom"] = $unJeu->getNomJeu();
         $unObjetJeu["jeu_regle"] = $unJeu->getRegleJeu();
         $unObjetJeu["jeu_type"] = $unJeu->getTypeJeu();

         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg, "donnees" => $unObjetJeu];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
