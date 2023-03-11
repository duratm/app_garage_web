<?php
require_once "autoload.php";
session_start();
if (!isset($_SESSION['client'])){
    header('Location: Connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Garage : Mon Compte</title>
<link rel="icon" href="logo.ico" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
</head>
<body>
<div id="background"></div>
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
<main class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px;">
    <section class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="container">
            <section class="row justify-content-center">
                <section class="col-xl-7 col-md-10 bg-white  rounded-5 shadow-5-strong p-5">
                    <?php
                    if (isset($_POST['modif'])){
                        $customerBDD = new CustomerDAO(MaBD::getInstance());
                        $arrayCusto = ['customerid'=>$customerBDD->getCustomer($_SESSION['client']->mail)->customerid, 'surname'=>$_POST['surname'], 'name'=>$_POST['name'], 'address' => $_POST['address'], 'city'=>$_POST['city'], 'postalcode'=>$_POST['postalcode'], 'mail'=>$_POST['mail'], 'tel'=>$_POST['tel']];
                        $customer = new Customer($arrayCusto);
                        if ($_POST['mail'] == $_SESSION['client']->mail or $customerBDD->getCustomer($_POST['mail']) == null){
                            $res = $customerBDD->update($customer);
                            if ($res==1){
                                $_SESSION['client'] = $customer;
                            }
                        }
                        else {
                            echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                                Cette adresse existe déjà                                
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                </article>";
                        }
                    }
                    if (isset($_SESSION['mdpChangé'])){
                        echo "<article class='alert alert-warning alert-dismissible fade show' role='alert'>
                                Votre mot de passe a bien été changé                                
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                </article>";
                        unset($_SESSION['mdpChangé']);
                    }
                    ?>
                    <form method="post">
                        <article class="row mb-4">
                            <article class="col">
                                <article class="form-outline">
                                    <?php
                                    echo "<input type='text' required='required' name='surname' class='form-control' value=".$_SESSION['client']->surname.">";
                                    ?>
                                    <label class="form-label" for="surname">Prenom</label>
                                </article>
                            </article>
                            <article class="col">
                                <article class="col-md form-outline">
                                    <?php
                                    echo "<input type='text' required='required' class='form-control' name='name' value=".$_SESSION['client']->name.">";
                                    ?>
                                    <label class="form-label" for="name">Nom</label>
                                </article>
                            </article>
                        </article>
                        <article class="form-outline mb-4">
                            <?php
                            echo "<input type='text' required='required' class='form-control' name='address' value='".$_SESSION['client']->address."'>";
                            ?>
                            <label class="form-label" for="adresse">Adresse</label>
                        </article>
                        <article class="row mb-4">
                            <article class="col-sm-8">
                                <article class="form-outline">
                                    <?php
                                    echo "<input type='text' required='required' class='form-control' name='city' value=".$_SESSION['client']->city.">";
                                    ?>
                                    <label class="form-label" for="city">Ville</label>
                                </article>
                            </article>
                            <article class="col-sm">
                                <article class="form-outline">
                                    <?php
                                    echo "<input type='text' required='required' class='form-control' name='postalcode' value=".$_SESSION['client']->postalcode.">";
                                    ?>
                                    <label class="form-label" for="postalcode">Code postal</label>
                                </article>
                            </article>
                        </article>
                        <article class="form-outline mb-4">
                            <?php
                            echo "<input type='email' required='required' class='form-control' name='mail' value=".$_SESSION['client']->mail.">"
                            ?>
                            <label class="form-label" for="email">Mail</label>
                        </article>
                        <article class="form-outline mb-4">
                            <?php
                            echo "<input type='text' required='required' class='form-control' name='tel' value=".$_SESSION['client']->tel.">"
                            ?>
                            <label class="form-label" for="tel">Téléphone</label>
                        </article>
                        <button type="submit" name="modif" class="btn btn-primary btn-block btn-lg mb-4">Valider mes modifications</button>
                        <hr class="mb-4" />
                        <a href="./myVehicle.php" role="button" class="btn btn-primary btn-block btn-lg mb-4" href="./myVehicle.php">Mes véhicules</a>
                        <hr class="mb-4" />
                        <h2 class="text-center">Historique</h2>
                        <section class="overflow-auto accordion" id="accordionAsk" style="height: 200px;">
                            <?php
                            $askForIntervBDD = new AskForInterventionDAO(MaBD::getInstance());
                            $histo = $askForIntervBDD->getAllForCustomer($_SESSION['client']->customerid);
                            if (sizeof($histo) == 0){
                                echo "<h5 class='text-center'>Aucun rendez-vous pris</h5>";
                            }
                            else {
                                function compa($a, $b)
                                {
                                    if ($a->date == $b->date) {
                                        return 0;
                                    }
                                    return ($a->date > $b->date) ? -1 : 1;
                                }

                                usort($histo, 'compa');
                                foreach ($histo as $interv){
                                    echo $interv->toHtml();
                                }
                            }
                            ?>
                        </section>
                        <hr class="mb-4" />
                        <section class="row">
                            <article class="col text-center">
                                <a role="button" class="text-danger" data-mdb-toggle="modal" data-mdb-target="#supModal">supprimer mon compte</a>
                                <section class="modal fade" id="supModal" tabindex="-1" aria-labelledby="supModalLabel" aria-hidden="true">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <article class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </article>
                                            <article class="modal-body">voulez vous vraiment supprimer votre compte ? Aucun retour en arrière ne sera possible</article>
                                            <article class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Annuler</button>
                                                <a href="./deleteAccount.php" role="button" class="btn btn-danger">Supprimer</a>
                                            </article>
                                        </section>
                                    </section>
                                </section>
                            </article>
                            <article class="col text-center">
                                <a href="modifyMdp.php">Modifier votre mot de passe</a>
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
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
</body>
</html>



















