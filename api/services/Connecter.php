<?php
// Les paramètres doivent être passés par la méthode GET :
//     http://<hébergeur>/Olympiade-DLS-Android/api/Connecter?pseudo=Administrateur&mdp=admin

// connexion du serveur web à la base MySQL
$dao = new DAO();

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
    if ($login == "" || $mdp == "" )
    {	$msg = "Erreur : données incomplètes.";
        $code_reponse = 400;
    }
    else
    {	$niveauConnexion = $dao->getNiveauConnexion($login, $mdp);

        switch ($niveauConnexion)
        {
          case 0 :
              $msg = "0";
              $code_reponse = 401; break;
          case 1 :
              $msg = "1";
              $code_reponse = 200; break;
          case 2 :
              $msg = "2";
              $code_reponse = 200; break;
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

