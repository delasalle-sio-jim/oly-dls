<?php
if(isset($_SESSION['connect']) && $_SESSION['connect']) {
  ?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-xl bg-info navbar-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="./images/gr-st-jean.jpg" height="50" alt="logo">
        Olympiades - <?= utf8_encode($_SESSION['com_login']) ?>
      </a>
    </div>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
      </li>
    </ul>
  </nav>
  <?php
} else {
  ?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-xl bg-info navbar-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="./images/gr-st-jean.jpg" height="50" alt="logo">
        Olympiades
      </a>
    </div>
  </nav>
  <?php
}
