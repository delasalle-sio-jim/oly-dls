<?php
if(isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 2) {
  ?>
  <!-- Navigation -->
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link" href="#">Gestion</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Jeux</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Tableau des scores</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Réinitialisation</a>
    </li>
  </ul>
  <?php
} else if(isset($_SESSION['connect']) && $_SESSION['connect'] && $_SESSION['com_num_privilege'] == 1) {
  $resultat = $cnx->query("select * from jeu order by jeu_nom");
  $resultat->execute();
  $resultat->setFetchMode(PDO::FETCH_OBJ);?>
  <!-- Navigation -->
  <ul class="nav flex-column">
    <?php
    while ($ligne = $resultat->fetch()) {
      ?>
      <li class="nav-item <?php if(isset($_GET['id']) && $_GET['id'] == $ligne->jeu_id) echo "active" ?>">
        <a class="nav-link" href="<?= $ligne->jeu_type == "B" ? "jeu_bonus.php?id=".$ligne->jeu_id : "jeu_normal.php?id=".$ligne->jeu_id ?>"><?= ucfirst($ligne->jeu_nom) ?></a>
      </li>
      <?php
    } ?>
  </ul>
  <?php
}
