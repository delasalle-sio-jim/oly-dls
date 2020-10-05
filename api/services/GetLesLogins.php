<?php
// Les paramètres doivent être passés par la méthode GET :
//     http://<hébergeur>/Olympiade-DLS-Android/api/GetLesLogins

// connexion du serveur web à la base MySQL
$dao = new DAO();
$lesLogins = array();

// La méthode HTTP utilisée doit être GET
if ($this->getMethodeRequete() != "GET")
{	$msg = "Erreur : méthode HTTP incorrecte.";
    $code_reponse = 406;
}
else {
  $lesLogins = $dao->getLesLogins();

  // mémorisation du nombre d'utilisateurs
  $nbReponses = sizeof($lesLogins);

  if ($nbReponses == 0) {
  $msg = "Aucun login.";
  $code_reponse = 200;
  }
  else {
  $msg = $nbReponses . " login(s).";
  $code_reponse = 200;
  }
}
// ferme la connexion à MySQL :
unset($dao);

$content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
$donnees = creerFluxJSON ($msg, $lesLogins);

// envoi de la réponse HTTP
$this->envoyerReponse($code_reponse, $content_type, $donnees);

// fin du programme (pour ne pas enchainer sur la fonction suivante)
exit;

// ================================================================================================

// création du flux JSON en sortie
function creerFluxJSON($msg, $lesLogins)
{
    /* Exemple de code JSON
      {
          "data": {
              "reponse": "2 login(s).",
              "donnees": [
                  "Administrateur",
                  "Professeur"
              ]
          }
      }
     */

     if (sizeof($lesLogins) == 0) {
         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg];
     }
     else {
         // construction d'un tableau contenant les utilisateurs
         $leTableau = array();
         foreach ($lesLogins as $unLogin)
         {
             $leTableau[] = $unLogin;
         }

         // construction de l'élément "data"
         $elt_data = ["reponse" => $msg, "donnees" => $leTableau];
     }

     // construction de la racine
     $elt_racine = ["data" => $elt_data];

    // retourne le contenu JSON (l'option JSON_PRETTY_PRINT gère les sauts de ligne et l'indentation)
    return json_encode($elt_racine, JSON_PRETTY_PRINT);
}

// ================================================================================================
?>
