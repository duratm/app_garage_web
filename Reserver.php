<?php
require_once __DIR__ . "/autoload.php";
session_start();

$pdo = MaBD::getInstance();
$askForInterventionDAO = new AskForInterventionDAO($pdo);
if(!isset($_SESSION['hour']) || !isset($_SESSION['date'])){
    header("Location: index.php");
}
$date = new DateTime($_SESSION['date']);
if (isset($_POST['submit'])) {
    if (! $_POST['car'] == '') {
        $customerId = $_SESSION['client']->customerid;
        $hour = $_SESSION['hour'];
        $desc = $_POST['desc'];
        $currentKm = $_POST['kilom'];
        $intervention = new AskForIntervention(['numdde' => '', 'date' => $date->format("Y-m-d"), 'hour' => $hour, 'askdescription' => $desc, 'currentkm' => $currentKm, 'askstate' => 'PLANIFIEE', 'askfordevis' => 'FALSE', 'vehicleimmat' => $_POST['car'], 'customerid' => $customerId, 'operatorlogin' => null, 'billnum' => null]);
        $res = $askForInterventionDAO->insert($intervention);
        if ($res == 1) {
            unset($_SESSION['hour']);
            unset($_SESSION['date']);
            $_SESSION['success'] = "Votre rendez-vous a bien été pris en compte";
            header('location: index.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Garage : index</title>
<link rel="icon" href="logo.ico" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>
    <link href="Styles/Reserver.css" rel="stylesheet"/>

</head>
<body>
<header>
    <nav class="navbar bg-body-tertiary navbar-expand-lg justify-content-center">
        <a href="./index.php" class="navbar-brand"> <img src="./Images/logo.jpeg" height="60" alt=""> </a>
        <ul class="navbar-nav mr-auto"  >
            <li class="nav-item"><a class="nav-link active" href="./PrendreRDV.php">Prendre RDV</a></li>
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
</header>
<main class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px; ">
    <section class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="container">
            <section class="row justify-content-center">
                <section class="col-xl-10 col-sm-12 bg-white rounded-5 shadow-5-strong p-5">
                    <?php
                    if (isset($_POST['submit'])) {
                        if ($_POST['car'] == '') {
                            echo "<article class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Sélectionnez une voiture valide ! si vous n'en avez pas, ajoutez-en une.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                            </article>";
                        }
                    }
                    ?>
                    <h1 class="text-center mb-4">Fixer votre rendez-vous</h1>
                    <form method="post">
                        <article class="row mb-4">
                            <article class="col-md">
                                <section class="form-outline">
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $date->format('Y-m-d'); ?>" readonly>
                                    <label for="date" class="form-label">Date</label>
                                </section>
                            </article>
                            <article class="col-md">
                                <section class="form-outline">
                                    <input type="text" class="form-control" id="hour" name="hour" value="<?php echo $_SESSION['hour']; ?>" readonly>
                                    <label for="hour" class="form-label">Heure</label>
                                </section>
                            </article>
                            <article class="col-md">
                                <section class="form-outline">
                                    <?php
                                    $vehicleBDD = new VehicleDAO(MaBD::getInstance());
                                    $vehicles = $vehicleBDD->getVehicleForCustomer(intval($_SESSION['client']->customerid));
                                    echo"<select name='car' class='form-select' id='car-select' aria-label='Select vehicle'>";
                                    echo"<option value='' selected>Véhicule</option>";
                                    foreach ($vehicles as $vehicle){
                                        echo $vehicle->toOption();
                                    }
                                    echo "</select>";
                                    ?>
                                </section>
                            </article>
                            <article class="col-md">
                                <section class="form-outline">
                                    <input type="number" class="form-control" name="kilom" min="0" max="999999">
                                    <label for='kilom' class="form-label">Kilométrage du véhicule</label>
                                </section>
                            </article>
                        </article>
                        <article class="row mb-4">
                            <section class="form-outline">
                                <textarea id="desc" name="desc" class="form-control" rows="5"></textarea>
                                <label for='desc' class="form-label">Description</label>
                            </section>
                        </article>
                        <article class="row">
                            <button class="btn btn-primary btn-block text-center" name="submit" type="submit">Prendre le rendez-vous</button>
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
</html>