<header>
    <div id='logo'>
    </div>
    <ul class="d-flex flex-row align-items-center justify-content-between">
        <li><a href="index.php">Acceuil</a></li>
        <?php if (!isset($_SESSION['logged'])): ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">connexion</a></li>
        <?php else: ?>
                <li><a href="deconnexion.php">Déconnexion</a></li>
        <?php endif; ?>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="planning.php">Planning</a></li>
        <li><a href="reservation.php">Réservation</a></li>
        <li><a href="reservation-form.php">Réservation: formulaire</a></li>
    </ul>
</header>