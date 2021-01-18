<header> 
        <div id='logo'>
        </div>
    <nav class="navbar navbar-expand-sm justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item"><a href="index.php" class="nav-link">Acceuil</a></li>
            <?php if (!isset($_SESSION['logged'])): ?>
                <li class="nav-item"><a href="inscription.php" class="nav-link">Inscription</a></li>
                <li class="nav-item"><a href="connexion.php" class="nav-link">connexion</a></li>
            <?php else: ?>
                    <li><a href="deconnexion.php" class="nav-link">Déconnexion</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="profil.php" class="nav-link">Profil</a></li>
            <li class="nav-item"><a href="planning.php" class="nav-link">Planning</a></li>
            <li class="nav-item"><a href="reservation.php" class="nav-link">Réservation</a></li>
            <li class="nav-item"><a href="reservation-form.php" class="nav-link">Réservation: formulaire</a></li>
        </ul>
    </nav>
</header>