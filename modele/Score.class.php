<?php
// début de la classe DAO (Data Access Object)
class Score
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------

    private $classement;
    private $equi_id;
    private $equi_nom;
    private $resultat;
    private $jeu_bonus_effectue;
    private $jeu_normal_effectue;

    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function __construct($classement, $equi_id, $equi_nom, $resultat, $jeu_normal_effectue, $jeu_bonus_effectue) {
      $this->classement = $classement;
      $this->equi_id = $equi_id;
      $this->equi_nom = $equi_nom;
      $this->resultat = $resultat;
      $this->jeu_normal_effectue = $jeu_normal_effectue;
      $this->jeu_bonus_effectue = $jeu_bonus_effectue;
    }

    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------

    public function getClassement()	{return $this->classement;}
    public function setClassement($classement) {$this->classement = $classement;}

    public function getIdEquipe()	{return $this->equi_id;}
    public function setIdEquipe($equi_id) {$this->equi_id = $equi_id;}

    public function getNomEquipe()	{return $this->equi_nom;}
    public function setNomEquipe($equi_nom) {$this->equi_nom = $equi_nom;}

    public function getResultat()	{return $this->resultat;}
    public function setResultat($resultat) {$this->resultat = $resultat;}

    public function getJeuNormalEffectue()	{return $this->jeu_normal_effectue;}
    public function setJeuNormalEffectue($jeu_bonus_effectue) {$this->jeu_normal_effectue = $jeu_bonus_effectue;}

    public function getJeuBonusEffectue()	{return $this->jeu_bonus_effectue;}
    public function setJeuBonusEffectue($jeu_normal_effectue) {$this->jeu_bonus_effectue = $jeu_normal_effectue;}
} // fin de la classe
