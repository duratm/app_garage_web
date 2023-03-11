<?php
    require_once "autoload.php";
    session_start();
    $pdo = MaBD::getInstance();
    $clientDAO = new CustomerDAO($pdo);
    $_SESSION['code_validation'] = rand(10000,99999);


if (isset($_POST['submit'])) {
    $prenom = $_POST['Prenom'];
    $nom = $_POST['Nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $confMDP = $_POST['confMDP'];
    $testUser = $clientDAO->getCustomer($email);
    if ($testUser) {

    } elseif ($mdp != $confMDP) {

    } else {
        $_SESSION['inscrit'] = new Customer(['customerid' => '', 'name' => $_POST['Nom'], 'surname' => $_POST['Prenom'], 'address' => $_POST['adresse'], 'postalcode' => $_POST['codeP'], 'city' => $_POST['ville'], 'tel' => $_POST['tel'], 'mail' => $email, 'datecreation' => date("Y-m-d"), 'mdp' => password_hash($_POST['mdp'], PASSWORD_ARGON2ID)]);
        header("Location: validation.php");
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Garage : Inscription</title>
<link rel="icon" href="logo.ico" type="image/x-icon" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
    </head>
</html>
<body>
<header>
    <nav class="navbar bg-body-tertiary navbar-expand-lg justify-content-center">
        <a href="./index.php" class="navbar-brand"> <img src="./Images/logo.jpeg" height="60" alt=""> </a>
        <ul class="navbar-nav mr-auto"  >
            <li class="nav-item"><a class="nav-link" href="./PrendreRDV.php">Prendre RDV</a></li>
            <li class="nav-item"><a class="nav-link" href="./Tarif.php">Tarif</a></li>

            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mon compte</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if (isset($_SESSION['client'])){
                        echo "<a class='dropdown-item' href='./HomeCustomer.php'>Mon compte</a>";
                        echo "<div class='dropdown-divider'></div>";

                        echo "<a class='dropdown-item' href='./Deconnexion.php'>Déconnexion</a>";
                    }else{
                        echo "<a class='dropdown-item' href='./Connexion.php'>Connexion</a>";
                        echo "<a class='dropdown-item active' href='./Inscrire.php'>Inscription</a>";
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link" href="./NousContacter.php">Nous contacter</a></li>
        </ul>
    </nav>
</header>
<main class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px; ">
    <section class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="container">
            <section class="row justify-content-center">
                <section class="col-xl-5 col-md-8">
                    <form method="post" class="bg-white  rounded-5 shadow-5-strong p-5">
                        <?php
                        if (isset($_POST['submit'])) {
                            $prenom = $_POST['Prenom'];
                            $nom = $_POST['Nom'];
                            $email = $_POST['email'];
                            $mdp = $_POST['mdp'];
                            $confMDP = $_POST['confMDP'];
                            $testUser = $clientDAO->getCustomer($email);
                            if ($testUser) {
                                echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    Cette adresse email existe déjà                                
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                    </article>";
                            } elseif ($mdp != $confMDP) {
                                echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    Mot de passe différents                              
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                    </article>";
                            }
                        }
                        ?>
                        <article class="row mb-4">
                            <article class="col">
                                <article class="form-outline">
                                    <input type="text" name="Prenom" class="form-control" required='required'/>
                                    <label class="form-label" for="Prenom">Prenom</label>
                                </article>
                            </article>
                            <article class="col">
                                <article class="col-md form-outline">
                                    <input type="text" name="Nom" class="form-control" required='required'/>
                                    <label class="form-label" for="Nom">Nom</label>
                                </article>
                            </article>
                        </article>
                        <article class="form-outline mb-4">
                            <input type="text" name="adresse" class="form-control"/>
                            <label class="form-label" for="adresse">Adresse</label>
                        </article>
                        <article class="row mb-4">
                            <article class="col-sm-8">
                                <article class="form-outline">
                                    <input type="text" name="ville" class="form-control"/>
                                    <label class="form-label" for="ville">Ville</label>
                                </article>
                            </article>
                            <article class="col-sm">
                                <article class="form-outline">
                                    <input type="text" name="codeP" class="form-control"/>
                                    <label class="form-label" for="codeP">Code postal</label>
                                </article>
                            </article>
                        </article>
                        <article class="form-outline mb-4">
                            <input type="email" name="email" class="form-control" required='required'/>
                            <label class="form-label" for="email">Mail</label>
                        </article>
                        <article class="form-outline mb-4">
                            <input type="tel" name="tel" class="form-control"/>
                            <label class="form-label" for="tel">Téléphone</label>
                        </article>
                        <article class="row mb-4">
                            <article class="col">
                                <article class="form-outline">
                                    <input type="password" name="mdp" class="form-control" required='required'/>
                                    <label class="form-label" for="mdp">Mot de passe</label>
                                </article>
                            </article>
                            <article class="col">
                                <article class="form-outline">
                                    <input type="password" name="confMDP" class="form-control" required='required'/>
                                    <label class="form-label" for="confMDP">Confirmer le mot de passe</label>
                                </article>
                            </article>
                        </article>
                        <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Continuer l'inscription</button>
                        <article class="row mb-4">
                            <a href="Connexion.php">Vous avez déjà un compte ? Connectez-vous</a>
                        </article>
                    </form>
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