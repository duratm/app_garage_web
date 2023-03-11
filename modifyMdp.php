<?php
require_once "autoload.php";
require_once "sender.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Garage : index</title>
<link rel="icon" href="logo.ico" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
</head>
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
                        echo "<a class='dropdown-item active' href='./HomeCustomer.php'>Mon compte</a>";
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
</header>
<main class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px; ">
    <section class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="container">
            <section class="row justify-content-center">
                <section class="col-xl-5 col-md-8">
                    <?php
                    $customerBDD = new CustomerDAO(MaBD::getInstance());
                    if (isset($_POST['mail'])){
                        $customer = $customerBDD->getCustomer($_POST['mail']);
                    }
                    elseif (isset($_SESSION['client'])) {
                        $customer = $_SESSION['client'];
                    }
                    if (isset($_SESSION['client'])) {
                        if (isset($_POST['new'])) {
                            if (password_verify($_POST['ancien'], $customerBDD->getCustomer($customer->mail)->mdp)) {
                                if ($_POST['new'] == $_POST['confirmNew']) {
                                    $mdp = password_hash($_POST['new'], PASSWORD_ARGON2ID);
                                    if (isset($_SESSION['client'])) {
                                        $client = $_SESSION['client'];
                                        $_SESSION['client'] = new Customer(['customerid' => $client->customerid, 'name' => $client->name, 'surname' => $client->surname, 'address' => $client->address, 'postalcode' => $client->postalcode, 'city' => $client->city, 'tel' => $client->tel, 'mail' => $client->mail, 'datecreation' => date("Y-m-d"), 'mdp' => $mdp]);
                                    } else {
                                        $client = $customerBDD->getCustomer($_POST['mail']);
                                        $_SESSION['client'] = new Customer(['customerid' => $client->customerid, 'name' => $client->name, 'surname' => $client->surname, 'address' => $client->address, 'postalcode' => $client->postalcode, 'city' => $client->city, 'tel' => $client->tel, 'mail' => $client->mail, 'datecreation' => date("Y-m-d"), 'mdp' => $mdp]);
                                    }
                                    $customerBDD->update($_SESSION['client']);
                                    $_SESSION['client']->mdp = null;
                                    $_SESSION['mdpChangé'] = "changed";
                                    if (isset($_SESSION['client'])) {
                                        header("location: ./HomeCustomer.php");
                                    } else {
                                        header("location: ./Connexion.php");
                                    }
                                } else {
                                    echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                                Erreur dans le nouveau mot de passe !
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                </article>";
                                }
                            } else {
                                echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                            Erreur dans l'ancien mot de passe !
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                            </article>";
                            }
                        }
                    }else{
                        if (isset($_POST['new'])) {
                            $_SESSION['resetflag'] = 1;
                            $_SESSION['resetClient'] = $customerBDD->getCustomer($_POST['mail']);
                            //var_dump($_POST['new']);
                            $_SESSION['resetMDP'] = password_hash($_POST['new'], PASSWORD_ARGON2ID);
                            sendAMail($_SESSION['resetClient']);
                            header("Location: validation.php");
                        }
                    }
                    ?>
                    <form method="post" class="bg-white  rounded-5 shadow-5-strong p-5">
                        <?php
                        if (!isset($_SESSION['client'])){
                            echo "<article class='form-outline mb-4'>
                            <input type='email' name='mail' required='required' class='form-control'>
                            <label class='form-label' for='mail'>Email</label>
                            </article>";
                        }else{
                        echo "<article class='form-outline mb-4'>
                            <input type='password' name='ancien' required='required' class='form-control'>
                            <label class='form-label' for='ancien'>Ancien mot de passe</label>
                        </article>";
                        }
                        ?>

                        <article class="form-outline mb-4">
                            <input type="password" name="new" required='required' class="form-control">
                            <label class="form-label" for="new">Nouveau mot de passe</label>
                        </article>
                        <section class="form-outline mb-4">
                            <input type="password" name="confirmNew" required='required' class="form-control">
                                <label class="form-label" for="confirmNew">Confirmer le nouveau mot de passe</label>
                        </section>
                        <section class='row'>
                            <article class='col-md text-center'>
                                <a class="text-danger" href="<?php if (isset($_SESSION['client'])){
                                    echo "./HomeCustomer.php";
                                }else{
                                    echo "./Connexion.php";
                                }?>">Annuler</a>
                            </article>
                            <article class='col-md'>
                                <button type="submit" class="btn btn-primary btn-block">valider</button>
                            </article>
                        </section>
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
</html>