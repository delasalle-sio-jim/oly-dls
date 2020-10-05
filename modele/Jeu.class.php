<?php
// début de la classe DAO (Data Access Object)
class Jeu
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------

    private $jeu_id;
    private $jeu_nom;
    private $jeu_regle;
    private $jeu_type;

    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function __construct($idJeu, $nomJeu, $regleJeu, $typeJeu) {
      $this->jeu_id = $idJeu;
      $this->jeu_nom = $nomJeu;
      $this->jeu_regle = $regleJeu;
      $this->jeu_type = $typeJeu;
    }

    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function getIdJeu()	{return $this->jeu_id;}
    public function setIdJeu($idJeu) {$this->jeu_id = $idJeu;}

    public function getNomJeu()	{return $this->jeu_nom;}
    public function setNomJeu($nomJeu) {$this->jeu_nom = $nomJeu;}

    public function getRegleJeu()	{return $this->jeu_regle;}
    public function setRegleJeu($regleJeu) {$this->jeu_regle = $regleJeu;}

    public function getTypeJeu()	{return $this->jeu_type;}
    public function setTypeJeu($typeJeu) {$this->jeu_type = $typeJeu;}
} // fin de la classe
