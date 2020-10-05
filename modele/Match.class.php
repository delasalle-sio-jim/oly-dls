<?php
// début de la classe DAO (Data Access Object)
class Match
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------

    private $equi_id;
    private $equi_nom;
    private $jeu_id;
    private $jeu_nom;
    private $hor_id;
    private $hor_heure;
    private $mat_nb_point;

    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function __construct($idEqui, $nomEqui, $idJeu, $nomJeu, $idHor, $heureHor, $nbPoint) {
      $this->equi_id = $idEqui;
      $this->equi_nom = $nomEqui;
      $this->jeu_id = $idJeu;
      $this->jeu_nom = $nomJeu;
      $this->hor_id = $idHor;
      $this->hor_heure = $heureHor;
      $this->mat_nb_point = $nbPoint;
    }

    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function getIdEquipe()	{return $this->equi_id;}
    public function setIdEquipe($idEqui) {$this->equi_id = $idEqui;}

    public function getNomEquipe()	{return $this->equi_nom;}
    public function setNomEquipe($nomEqui) {$this->equi_nom = $nomEqui;}

    public function getIdJeu()	{return $this->jeu_id;}
    public function setIdJeu($idJeu) {$this->jeu_id = $idJeu;}

    public function getNomJeu()	{return $this->jeu_nom;}
    public function setNomJeu($nomJeu) {$this->jeu_nom = $nomJeu;}

    public function getIdHor()	{return $this->hor_id;}
    public function setIdHor($idHor) {$this->hor_id = $idHor;}

    public function getHeureHor()	{return $this->hor_heure;}
    public function setHeureHor($heureHor) {$this->hor_heure = $heureHor;}

    public function getNbPoint()	{return $this->mat_nb_point;}
    public function setNbPoint($nbPoint) {$this->mat_nb_point = $nbPoint;}
} // fin de la classe
