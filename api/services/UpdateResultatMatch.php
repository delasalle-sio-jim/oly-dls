<?php
// connexion du serveur web à la base MySQL
$dao = new DAO();

// Récupération des données transmises
$login = (empty($this->request['pseudo'])) ? "" : $this->request['pseudo'];
$mdp = (empty($this->request['mdp'])) ? "" : $this->request['mdp'];
$mat_equipe = (empty($this->request['equi_id'])) ? "" : $this->request['equi_id'];
$mat_jeu = (empty($this->request['jeu_id'])) ? "" : $this->request['jeu_id'];
$mat_nb_point = (empty($this->request['nb_point']) && $this->request['nb_point'] != 0) ? "" : $this->request['nb_point'];

// La méthode HTTP utilisée doit être GET
if ($this->getMethodeRequete() != "GET")
{	$msg = "Erreur : méthode HTTP incorrecte.";
    $code_reponse = 406;
}
else {
    // Les paramètres doivent être présents
    if ($login == "" || $mdp == "" || $mat_equipe == "" || $mat_jeu == "" || $mat_nb_point == "")
    {	$msg = "Erreur : données incomplètes.";
        $code_reponse = 400;
    }
    else
    {
      if($dao->getNiveauConnexion($login, $mdp) == 0)
      {
        $msg = "Erreur : authentification incorrecte.";
        $code_reponse = 400;
      }
      else
      {
        $ok = $dao->updateResultatMatch($mat_equipe, $mat_jeu, $mat_nb_point);

        if (!$ok)
        {
          $msg = "Erreur : problème lors de la sauvegarde du résultat.";
          $code_reponse = 500;
        }
        else
        {
          $msg = "Sauvegarde réussie.";
          $code_reponse = 200;
        }
      }
    }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg)
{
    /* Exemple de code JSON
         {
             "data":{
                "reponse": "authentification incorrecte."
             }
         }
     */

    // construction de l'élément "data"
    $elt_data = ["reponse" => $msg];

    // construction de la racine
    $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
