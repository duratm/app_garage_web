<?php
session_start();
require "autoload.php";
if (!(isset($_POST['min']) and isset($_POST['max']))){
    $_POST['min'] = 0;
    $_POST['max'] = 0;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Garage : Tarif</title>
<link rel="icon" href="logo.ico" type="image/x-icon" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet"/>

    </head>
    <body>
    <header>
        <nav class="navbar bg-body-tertiary navbar-expand-lg justify-content-center">
            <a href="./index.php" class="navbar-brand"> <img src="./Images/logo.jpeg" height="60" alt=""> </a>
            <ul class="navbar-nav mr-auto"  >
                <li class="nav-item"><a class="nav-link" href="./PrendreRDV.php">Prendre RDV</a></li>
                <li class="nav-item"><a class="nav-link active" href="./Tarif.php">Tarif</a></li>

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
                            <form method="post" class="row">
                                <article class="col-lg-4">
                                    <article class="btn-group mb-4">
                                        <input type="radio" class="btn-check" name="option" id="croissant" value="croissant" autocomplete="off" onclick="javascript: submit()" <?php if (isset($_POST['option']) && $_POST['option'] == 'croissant'){ echo 'checked="checked"';} else {echo '';}?>>
                                        <label class="btn btn-primary" for="croissant">Prix croissant</label>
                                        <input type="radio" class="btn-check" name="option" id="decroissant" value="decroissant" onclick="javascript: submit()" autocomplete="off" <?php if (isset($_POST['option']) && $_POST['option'] == 'decroissant'){ echo 'checked="checked"';} else {echo '';}?>>
                                        <label class="btn btn-primary" for="decroissant">Prix décroissant</label>
                                    </article>
                                    <article class="form-outline mb-4">
                                        <input type="text" name="min" class="form-control">
                                        <label class="form-label" for="min">Prix min</label>
                                    </article>
                                    <article class="form-outline mb-4">
                                        <input type="text" name="max" class="form-control">
                                        <label class="form-label" for="max">Prix max</label>
                                    </article>
                                </article>
                                <article class="col-lg">
                                    <article class="row">
                                        <article class="col">
                                            <article class="form-outline mb-4">
                                                <input class="form-control" type="text" name="rechercheOpe">
                                                <label class="form-label" for="rechercheOpe">Opération</label>
                                            </article>
                                        </article>
                                        <article class="col">
                                            <button type="submit" value="Rechercher le tarif" class="btn btn-primary">Rechercher</button>
                                        </article>
                                    </article>
                            </form>
                            <section class="overflow-y-scroll" style="max-height: 70vh">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Opération</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Durée estimée</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    function cmp($a, $b)
                                    {
                                        if ($a->getTarif() == $b->getTarif()) {
                                            return 0;
                                        }
                                        return ($a->getTarif() < $b->getTarif()) ? -1 : 1;
                                    }

                                    function reverseCmp($a, $b)
                                    {
                                        if ($a->getTarif() == $b->getTarif()) {
                                            return 0;
                                        }
                                        return ($a->getTarif() > $b->getTarif()) ? -1 : 1;
                                    }

                                    $opeBDD = new OperationDAO(MaBD::getInstance());
                                    if (empty($_POST['rechercheOpe'])) {
                                        $res = $opeBDD->getOpeBeetween(intval($_POST['min']), intval($_POST['max']));
                                    }

                                    else {
                                        $res = OperationDAO::getOpeContains($opeBDD->getOpeBeetween(intval($_POST['min']), intval($_POST['max'])), $_POST['rechercheOpe']);
                                    }

                                    if (isset($_POST['option'])){
                                        if ($_POST['option'] == "croissant") {
                                            usort($res, "cmp");
                                        }
                                        if ($_POST['option'] == "decroissant") {
                                            usort($res, "reverseCmp");
                                        }
                                    }
                                    foreach ($res as $ope) {
                                        echo $ope->toHtml();
                                    }
                                    if (sizeof($res) == 0){
                                        echo "<h3>Aucune opération trouvée</h3>";
                                    }

                                    ?>
                                    </section>
                                    </tbody>
                                </table>
                            </article>
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
</body>
</html>