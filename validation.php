<?php
require_once "autoload.php";
session_start();
$pdo = MaBD::getInstance();
$clientDAO = new CustomerDAO($pdo);
if(!isset($_SESSION['resetflag'])) {
    if (isset($_POST['code_verif']) && $_POST['code_verif'] != 0) {
        if ($_POST['code_verif'] == $_SESSION['code_validation']) {
            $moi = new Customer(['customerid' => '', 'name' => $_SESSION['inscrit']->name, 'surname' => $_SESSION['inscrit']->surname, 'address' => $_SESSION['inscrit']->address, 'postalcode' => $_SESSION['inscrit']->postalcode, 'city' => $_SESSION['inscrit']->city, 'tel' => $_SESSION['inscrit']->tel, 'mail' => $_SESSION['inscrit']->mail, 'datecreation' => date("Y-m-d"), 'mdp' => $_SESSION['inscrit']->mdp]);
            $res = $clientDAO->insert($moi);
            $_SESSION['client'] = $clientDAO->getCustomer($_SESSION['inscrit']->mail);
            $_SESSION['code_validation'] = 0;//0 = validé
            unset($_SESSION['inscrit']);
            header("Location: Connexion.php");
            //affiché si session = 0 un message de bienvenue
        }
    }
}else{
    if (isset($_POST['code_verif']) && $_POST['code_verif'] != 0) {
        if ($_POST['code_verif'] == $_SESSION['code_validation']) {
            $moi = new Customer(['customerid' => $_SESSION['resetClient']->customerid, 'name' => $_SESSION['resetClient']->name, 'surname' => $_SESSION['resetClient']->surname, 'address' => $_SESSION['resetClient']->address, 'postalcode' => $_SESSION['resetClient']->postalcode, 'city' => $_SESSION['resetClient']->city, 'tel' => $_SESSION['resetClient']->tel, 'mail' => $_SESSION['resetClient']->mail, 'datecreation' => $_SESSION['resetClient']->datecreation, 'mdp' => $_SESSION['resetMDP']]);
            var_dump($_SESSION['resetMDP']);
            $res = $clientDAO->update($moi);
            $_SESSION['mdpChangé'] = "changed";
            $_SESSION['client'] = $clientDAO->getCustomer($_SESSION['resetClient']->mail);
            $_SESSION['code_validation'] = 0;//0 = validé
            unset($_SESSION['inscrit']);
            unset($_SESSION['resetClient']);unset($_SESSION['resetMDP']);unset($_SESSION['resetflag']);
            header("Location: Connexion.php");
        }
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
                    <?php
                    if (isset($_SESSION['resend'])){
                        echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                              email envoyé
                              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                              </article>";
                        unset($_SESSION['resend']);
                    }
                    if(!isset($_SESSION['resetflag'])) {
                        if (isset($_POST['code_verif']) && $_POST['code_verif'] != 0) {
                            if (! $_POST['code_verif'] == $_SESSION['code_validation']) {
                                echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                              mauvais code
                              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                              </article>";
                                unset($_POST['code_verif']);
                            }
                        }
                    }
                    ?>
                    <form method="post" class="bg-white  rounded-5 shadow-5-strong p-5">
                        <article class="form-outline mb-4">
                            <input type="number" name="code_verif" class="form-control" value="<?php echo $_SESSION['code_validation'];?>">
                            <label class="form-label" for="code_verif">code de vérification</label>
                        </article>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Vérifier mon code</button>
                        <article class="row mb-4">
                            <a href="renvoyerVerif.php">Renvoyer un mail</a>
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