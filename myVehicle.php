<?php
require_once "autoload.php";
session_start();
if (!isset($_SESSION['client'])) {
    header('Location: connexion.php');
}

$vehicleBDD = new VehicleDAO(MaBD::getInstance());
$vehicles = $vehicleBDD->getVehicleForCustomer(intval($_SESSION['client']->customerid));
$modelBDD = new ModelDAO(MaBD::getInstance());
$brandBDD = new BrandDAO(MaBD::getInstance());

if (isset($_POST['newImmat'])) {

}
if (isset($_POST['supp'])) {
    $vehicleSupp = $vehicleBDD->getOne($_POST['immat']);
    $vehicleSupp->appartient = 0;
    $vehicleBDD->update($vehicleSupp);
    $page = $_SERVER['PHP_SELF'];
    $sec = "0";
    header("Refresh: $sec; url=$page");
}
$currentDate = date("Y-m-d", time());
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Garage : Mes Véhicules</title>
    <link rel="icon" href="logo.ico" type="image/x-icon" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
</head>
<body>
<header>
    <nav class="navbar bg-body-tertiary navbar-expand-lg justify-content-center">
        <a href="./index.php" class="navbar-brand"> <img src="./Images/logo.jpeg" height="60" alt=""> </a>
        <ul class="navbar-nav mr-auto">
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
                    }
                    else{
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
                <section class="col-xxl-8 col-xl-10 col-sm-12 bg-white rounded-5 shadow-5-strong p-5">
                    <form method="post">
                        <section class='row'>
                            <article class='col-md'>
                                <section class='form-outline mb-4'>
                                    <?php
                                    if (isset($_POST['ajout'])) {
                                        if (!isset($_POST['marque'])){
                                            echo 'Veuillez choisir une marque';
                                        }
                                        elseif (!isset($_POST['model'])){
                                            echo 'Veuillez choisir un modèle';
                                        }

                                        else {
                                            $arrayVehic = ['noimmat' => $_POST['newImmat'], 'noserie' => $_POST['noserie'], 'releasedate' => date($_POST['releasedate']), 'nummodel' => $_POST['model'], 'customerid' => $_SESSION['client']->customerid, 'appartient' => true];
                                            $newVehicle = new Vehicle($arrayVehic);
                                            if ($vehicleBDD->getVehicleFromImmatAppart($_POST['newImmat']) != null){
                                                echo 'impossible, ce véhicule est déjà ajouté à votre compte ou ne vous appartient pas';
                                            }
                                            elseif ($vehicleBDD->getVehicleFromImmatNonAppart($_POST['newImmat']) != null){
                                                $vehicleBDD->update($newVehicle);
                                            }
                                            else {
                                                $vehicleBDD->insert($newVehicle);
                                            }
                                            header('Location: myVehicle.php');
                                        }
                                    }

                                    ?>
                                    <input type="text" name="newImmat" class="form-control" placeholder="XX-XXX-XX"
                                           pattern="^([A-Za-z]{2}-?[0-9]{3}-?[A-Za-z]{2})?([0-9]{4}-?[A-Za-z]{2}-?[0-9]{2})?([0-9]{3}-?[A-Za-z]{3}-?[0-9]{2})?$" required>
                                    <label class="form-label" for="newImmat">Immatriculation</label>
                            </article>
                            <article class='col-md'>
                                <section class="form-outline">
                                    <input type="text" name="noserie" class="form-control" required="required" pattern="[A-Za-z0-9]{17}">
                                    <label class="form-label" for="noserie">N°série</label>
                                </section>
                            </article>
                        </section>
                        <section class='row mb-4'>
                            <article class='col-md'>
                                <select name="marque" id="listBrand" class="form-select" style="height: 2.25em" aria-label="select Brand Label" onchange="putModel()" required>
                                    <option value="0" selected>Choisir une marque</option>
                                    <?php
                                    $brandBDD->toSelect();
                                    ?>
                                </select>
                            </article>
                            <article class='col-md'>
                                <select name="model" id="listModel" class="form-select" style="height: 2.25em" aria-label="select Model Label" required>
                                    <option value="0" selected>Choisir un modèle</option>
                                </select>
                            </article>
                            <article class='col-md'>
                                <section class="form-outline">
                                    <input type="date" id="datepicker" name="releasedate" class="form-control" required="required" max="<?php echo $currentDate; ?>">
                                    <label class="form-label" for="releasedate">Date de mise en circulation</label>
                                </section>
                            </article>
                        </section>
                        <article class='col-md'>
                            <button type="submit" name="ajout" class="btn btn-primary btn-block btn-lg mb-4">Ajouter mon
                                véhicule
                            </button>
                        </article>

                <hr class="mb-4">
                </form>
                <?php
                if (count($vehicles) == 0) {
                    echo "<h5 class='text-center'>Aucun véhicule ajouté à votre compte</h5>";
                } else {
                    foreach ($vehicles as $vehicle) {
                        echo $vehicle->toForm();
                    }
                }
                ?>
                </section>
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
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker-full.min.js"></script>
<script src="./js/VehicleList.js"></script>
</body>
</html>