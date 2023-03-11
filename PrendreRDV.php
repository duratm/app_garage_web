<?php
require_once __DIR__ . "/autoload.php";
session_start();

function getWeek(String $date): array {
    $startDate = date_create($date);
    $endDate = date_create($date);

    $WeekNumber = $startDate->format('w');
    switch ($WeekNumber) {
        case "0":
            date_add($startDate, date_interval_create_from_date_string("1 day"));
            date_add($endDate, date_interval_create_from_date_string("6 day"));
            break;
        
        case "1":
            date_add($endDate, date_interval_create_from_date_string("5 day"));
            break;

        case "2":
            date_add($startDate, date_interval_create_from_date_string("-1 day"));
            date_add($endDate, date_interval_create_from_date_string("4 day"));
            break;

        case "3" :
            date_add($startDate, date_interval_create_from_date_string("-2 day"));
            date_add($endDate, date_interval_create_from_date_string("3 day"));
            break;

        case "4":
            date_add($startDate, date_interval_create_from_date_string("-3 day"));
            date_add($endDate, date_interval_create_from_date_string("2 day"));
            break;

        case "5":
            date_add($startDate, date_interval_create_from_date_string("-4 day"));
            date_add($endDate, date_interval_create_from_date_string("1 day"));
            break;

        default:
            date_add($startDate, date_interval_create_from_date_string("-5 day"));
    }
    
    $res['start'] = $startDate->format('Y-m-d');
    $res['end'] = $endDate->format('Y-m-d');
    return $res;
}

function checkMorning(int $id, array $res, String $date): int {
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'08h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'08h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'08h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'08h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'09h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'09h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'09h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'09h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'10h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'10h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'10h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'10h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'11h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'11h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'11h45');
    return $id;
}

function checkAfternoon(int $id, array $res, String $date): int {
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'14h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'14h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'14h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'14h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'15h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'15h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'15h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'15h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h45');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'16h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'17h00');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'17h15');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'17h30');
    $id += $res[$id]->checkHour($date, isset($_SESSION['client']),'17h45');
    return $id;
}

$pdo = MaBD::getInstance();
$askForInterventionDAO = new AskForInterventionDAO($pdo);


if(!isset($_SESSION['day'])) {
    $currentDate = date("Y-m-d", time());
    $week = getWeek($currentDate);
}


if (isset($_POST['day'])) {
    $week = getWeek($_POST['day']);
}

$res = $askForInterventionDAO->getAllForDate($week['start'], $week['end']);
$res[count($res)] = new AskForIntervention(array('date' => '0000-00-00', 'hour' =>'0h00'));


if (isset($_POST['horaire'])) {
    if(isset($_SESSION['client'])){
        $_SESSION['date']=explode(' ',$_POST['horaire'])[0];
        $_SESSION['hour']=explode(' ',$_POST['horaire'])[1];
        header("Location: Reserver.php");
        echo "tu es connecté";
    }else{
        echo '<script>
                if (confirm("Vous devez être connecté pour pouvoir prendre un rendez-vous")) {
            window.location.replace("Connexion.php");
        
                } else {
                    //do nothing
                }
               </script>';
    }

}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Garage : Prendre un rendez-vous</title>
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
                        <h1 class="text-center mb-4">Choisissez un horaire</h1>
                        <form method="post">
                            <article class='col-md mb-4'>
                                <section class="form-outline">
                                    <input type="date" id="datepicker" name="day" class="form-control" onchange="submit()" placeholder="Date RDV" min="<?php echo $currentDate; ?>"/>
                                    <label class="form-label" for="day">Date de rendez-vous</label>
                                </section>
                            </article>
                        </form>
                <form class="container overflow-x-scroll" method="post" style="height: 70vh">
                    <section class="row">
                        <article class="col">
                            <p>Lun
                                <?php
                                $date = date_create($week['start']);
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
                                <article class="row">
                                    <?php
                                    $id = checkMorning(0, $res, $date->format("Y-m-d"));
    
                                    ?>
                                </article>
                                <hr>
                                <article class="row">
                                    <?php
                                    $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                    ?>
                                </article>
                            </section>
                        </article>
                        <article class="col">
                            <p>Mar 
                                <?php
                                $date = date_create($week['start']);
                                date_add($date, date_interval_create_from_date_string('1 day'));
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
<article class="row">
                                <?php 
                                $id = checkMorning($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                            <hr>
<article class="row">
                                <?php 
                                $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
</section>
                        </article>
                        <article class="col"> 
                            <p>Mer 
                                <?php
                                $date = date_create($week['start']);
                                date_add($date, date_interval_create_from_date_string('2 day'));
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
<article class="row">
                                <?php 
                                $id = checkMorning($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                            <hr>
<article class="row">
                                <?php 
                                $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
</section>
                        </article>
                        <article class="col">
                            <p>Jeu 
                                <?php
                                $date = date_create($week['start']);
                                date_add($date, date_interval_create_from_date_string('3 day'));
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
<article class="row">
                                <?php 
                                $id = checkMorning($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                            <hr>
<article class="row">
                                <?php 
                                $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
</section>
                        </article>
                        <article class="col">
                            <p>Ven 
                                <?php
                                $date = date_create($week['start']);
                                date_add($date, date_interval_create_from_date_string('4 day'));
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
<article class="row">
                                <?php 
                                $id = checkMorning($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                            <hr>
<article class="row">
                                <?php 
                                $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
</section>
                        </article>
                        <article class="col">
                            <p>Sam
                                <?php
                                $date = date_create($week['start']);
                                date_add($date, date_interval_create_from_date_string('5 day'));
                                echo $date->format("d/m");
                                ?>
                            </p>
                            <section class="col">
<article class="row">
                                <?php 
                                $id = checkMorning($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                            <hr>
<article class="row">
                                <?php 
                                $id = checkAfternoon($id, $res, $date->format("Y-m-d"));
                                ?> 
                            </article>
                    </article>
                    </section>
                </form>
                    </section>
                </section>
            </section>
        </section>
        <?php
        if (!isset($_SESSION['client'])) {
            echo "<section class='modal fade' id='connectModal' tabindex='-1' aria-labelledby='connectModalLabel' aria-hidden='true'>
                    <section class='modal-dialog'>
                        <section class='modal-content'>
                            <article class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Attention</h5>
                                <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'></button>
                            </article>
                            <article class='modal-body'>Vous devez être connecté pour pouvoir prendre un rendez-vous</article>
                            <article class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>Annuler</button>
                                <a href='./Connexion.php' role='button' class='btn btn-danger'>Me connecter</a>
                            </article>
                        </section>
                    </section>
                </section>";
        }
        ?>
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
    </body>
    </html>