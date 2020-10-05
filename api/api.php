<?php
include_once ("rest.php");
include_once ('../modele/DAO.class.php');

class Api extends Rest
{
    // Le constructeur
    public function __construct()
    {   parent::__construct();      // appel du constructeur de la classe parente
    }


    // Cette méthode traite l'action demandée dans l'URI
    public function traiterRequete()
    {   // récupère le contenu du paramètre action et supprime les "/"
        $action = ( empty($this->request['action'])) ? "" : $this->request['action'];
        $action = strtolower(trim(str_replace("/", "", $action)));

        switch ($action) {
            // services web fournis
            case "connecter" : {$this->Connecter(); break;}
            case "getleslogins" : {$this->GetLesLogins(); break;}
            case "getleplanningjeu" : {$this->GetLePlanningJeu(); break;}
            case "getleplanningequipe" : {$this->GetLePlanningEquipe(); break;}
            case "getlesequipes" : {$this->GetLesEquipes(); break;}
            case "getunjeu" : {$this->GetUnJeu(); break;}
            case "getlesjeux" : {$this->GetLesJeux(); break;}
            case "getlesjeuxnormaux" : {$this->GetLesJeuxNormaux(); break;}
            case "getlesjeuxbonus" : {$this->GetLesJeuxBonus(); break;}
            case "getleclassement" : {$this->GetLeClassement(); break;}
            case "getlesabsentjeubonus" : {$this->GetLesAbsentJeuBonus(); break;}
            case "getlesparticipationsbonus" : {$this->GetLesParticipationsBonus(); break;}
            case "updateresultatmatch" : {$this->UpdateResultatMatch(); break;}
            case "ajouteruneparticipation" : {$this->AjouterUneParticipation(); break;}
            case "supprimeruneparticipation" : {$this->SupprimerUneParticipation(); break;}
            case "getlesmatchs" : {$this->GetLesMatchs(); break;}

            // l'action demandée n'existe pas, la réponse est 404 ("Page not found") et aucune donnée n'est envoyée
            default : {
                $code_reponse = 404;
                $donnees = '';
                $content_type = "application/json; charset=utf-8";      // indique le format Json pour la réponse
                $this->envoyerReponse($code_reponse, $content_type, $donnees);    // envoi de la réponse HTTP
                break;
            }
        }
    } // fin de la fonction traiterRequete

    // services web fournis ===========================================================================================

    // Ce service permet permet à un utilisateur de s'authentifier
    private function Connecter()
    {   include_once ("services/Connecter.php");
    }

    private function GetLesLogins()
    {   include_once ("services/GetLesLogins.php");
    }

    private function GetLePlanningJeu()
    {   include_once ("services/GetLePlanningJeu.php");
    }

    private function GetLePlanningEquipe()
    {   include_once ("services/GetLePlanningEquipe.php");
    }

    private function GetLesEquipes()
    {   include_once ("services/GetLesEquipes.php");
    }

    private function GetUnJeu()
    {   include_once ("services/GetUnJeu.php");
    }

    private function GetLesJeux()
    {   include_once ("services/GetLesJeux.php");
    }
    
    private function GetLesJeuxNormaux()
    {   include_once ("services/GetLesJeuxNormaux.php");
    }

    private function GetLesJeuxBonus()
    {   include_once ("services/GetLesJeuxBonus.php");
    }

    private function GetLeClassement()
    {   include_once ("services/GetLeClassement.php");
    }

    private function GetLesAbsentJeuBonus()
    {   include_once ("services/GetLesAbsentJeuBonus.php");
    }

    private function GetLesParticipationsBonus()
    {   include_once ("services/GetLesParticipationsBonus.php");
    }

    private function UpdateResultatMatch()
    {   include_once ("services/UpdateResultatMatch.php");
    }

    private function AjouterUneParticipation()
    {   include_once ("services/AjouterUneParticipation.php");
    }

    private function SupprimerUneParticipation()
    {   include_once ("services/SupprimerUneParticipation.php");
    }

    private function GetLesMatchs()
    {   include_once ("services/GetLesMatchs.php");
    }
} // fin de la classe Api

// Traitement de la requête HTTP
$api = new Api;
$api->traiterRequete();
