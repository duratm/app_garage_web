<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Garage : index</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
    <link rel="icon" href="./Images/logo.ico" type="image/x-icon" />
</head>
</html>
<body>
<header>
    <nav class="navbar bg-body-tertiary navbar-expand-lg justify-content-center">
        <a href="./index.php" class="navbar-brand "> <img src="./Images/logo.jpeg" height="60" alt=""> </a>
        <ul class="navbar-nav mr-auto"  >
            <li class="nav-item"><a class="nav-link" href="./PrendreRDV.php">Prendre RDV</a></li>
            <li class="nav-item"><a class="nav-link" href="./Tarif.php">Tarif</a></li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mon compte</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if (isset($_SESSION['client'])){
                        echo "<a class='dropdown-item' href='./HomeCustomer.php'>Mon compte</a>";
                        echo "<div class='dropdown-divider'></div>";

                        echo "<a class='dropdown-item' href='./Deconnexion.php'>Déconnexion</a>";
                    }else{
                        echo "<a class='dropdown-item' href='./Connexion.php'>Connexion</a>";
                        echo "<a class='dropdown-item' href='./Inscrire.php'>Inscription</a>";
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link" href="./NousContacter.php">Nous contacter</a></li>
        </ul>
    </nav>
    <?php
    if (isset($_SESSION['success'])){
        echo "<article class='alert alert-success alert-dismissible fade show' role='alert'>
            ".$_SESSION['success']."
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
            </article>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['supp'])){
        echo "<article class='alert alert-success alert-dismissible fade show' role='alert'>
                Compte supprimé
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                </article>";
        unset($_SESSION['supp']);
    }
    ?>
    <section class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px; ">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.8);">
            <section class="container d-flex align-items-center justify-content-center text-center h-100">
                <article class="text-white">
                    <h1 class="mb-3">Motorsport Garage</h1>
                    <p>Leader français de la réparation de véhicule depuis 1995</p>
                    <p>Notre service vous promet une réparation rapide faite par des professionnels</p>
                    <p>Découvrez nos services dès maintenant</p>
                </article>
            </section>
        </div>
    </section>
</header>

<main class="container mt-5">
        <!--Section: Content-->
        <section>
            <section class="row">
                <article class="col-md-6 gx-5 mb-4">
                    <article class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
                        <img src="./Images/Accueil.jpg" class="img-fluid" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </article>
                </article>

                <article class="col-md-6 gx-5 mb-4">
                    <h4><strong>Notre garage</strong></h4>
                    <p class="text-muted">
                        Depuis de nombreuses années, nous sommes le leader français de la réparation de véhicule.
                        Nous vous proposons un service de qualité et rapide.
                        Nous sommes situés à Valence 15 avenue de Chabeuil.
                    </p>
                    <p><strong>Une équipe compétente et à votre écoute</strong></p>
                    <p class="text-muted">
                        Nous sommes une équipe de professionnels qui vous propose un service de qualité.
                        Nous sommes à votre écoute et nous vous proposons des solutions adaptées à vos besoins.
                    </p>
                </article>
            </section>
        </section>
        <!--Section: Content-->

        <hr class="my-5" />

        <!--Section: Content-->
        <section class="text-center">
            <h4 class="mb-5"><strong>Nos services</strong></h4>

            <section class="row">
                <section class="col-lg-4 col-md-12 mb-4">
                    <article class="card">
                        <article class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img src="./Images/tarifs.jpeg" class="img-fluid" />
                            <a href="./Tarif.php">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </article>
                        <article class="card-body">
                            <h5 class="card-title">Consultez nos tarifs</h5>
                            <p class="card-text">
                                Nous vous proposons des tarifs adaptés à vos besoins.
                                Vous pouvez consulter nos tarifs en cliquant sur le bouton ci-dessous.
                            </p>
                            <br>
                            <a href="./Tarif.php" class="btn btn-primary">Nos tarifs</a>
                        </article>
                    </article>
                </section>

                <section class="col-lg-4 col-md-6 mb-4">
                    <section class="card">
                        <article class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img src="./Images/rendez-vous.jpg" class="img-fluid" />
                            <a href="./PrendreRDV.php">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </article>
                        <article class="card-body">
                            <h5 class="card-title">Prendre un rendez-vous</h5>
                            <p class="card-text">
                                Nos disponibilités sont accessible sur notre site.
                                Vous pouvez prendre un rendez-vous en ligne en cliquant sur le bouton ci-dessous.
                            </p>
                            <br>
                            <a href="./PrendreRDV.php" class="btn btn-primary">Les rendez-vous</a>
                        </article>
                    </section>
                </section>

                <section class="col-lg-4 col-md-6 mb-4">
                    <section class="card">
                        <article class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img src="./Images/compte-accueil.jpg" class="img-fluid" />
                            <a href="./HomeCustomer.php">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </article>
                        <article class="card-body">
                            <h5 class="card-title">Consulter votre compte</h5>
                            <p class="card-text">
                                Sur votre compte, vous pouvez consulter vos rendez-vous, vos factures, interventions en cours et vos informations personnelles.
                                Consultez votre compte en cliquant sur le bouton ci-dessous.
                            </p>
                            <a href="./HomeCustomer.php" class="btn btn-primary">Mon profil</a>
                        </article>
                    </section>
                </section>
            </section>
        </section>
</main>
<footer class="bg-dark text-center text-white">
    <div class="container p-4">
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Motorsport Garage
                        </h6>
                        <p>
                            Leader français de la réparation de véhicule depuis 1995.
                            Notre service vous promet une réparation rapide faite par des professionnels.
                            Découvrez nos services dès maintenant.
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> Valence, 26000, FR</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            garagesports@alwaysdata.net
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2023 Copyright: Durat Mathias, Farret Quentin, Viard Paul, Micoulet Alex
    </section>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
</body>
</html>