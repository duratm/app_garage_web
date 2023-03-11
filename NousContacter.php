<?php
    require_once "autoload.php";
    session_start();

    if (isset($_POST['submit'])) {
        $_SESSION['envoyé'] = true;
        unset($_POST);
    }

    $nom = '';
    $email = '';
    if (isset($_SESSION['client'])) {
        $nom = $_SESSION['client']->name;
        $email = $_SESSION['client']->mail;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Garage : Contacts</title>
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
                <li class="nav-item"><a class="nav-link active" href="./NousContacter.php">Nous contacter</a></li>
            </ul>
        </nav>
    </header>
    <main class="bg-image" style="background-image: url('./Images/background.jpg'); height: 1000px; ">
        <section class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
            <section class="container">
                <section class="row justify-content-center">
                    <section class="col-xl-10 col-sm-12 bg-white rounded-5 shadow-5-strong p-5">
                        <?php
                        if (isset($_SESSION['envoyé'])){
                            echo "<article class='alert alert-success alert-dismissible fade show' role='alert'>
                                      Message envoyé avec succès
                                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label'Close'></button>
                                  </article>";
                            unset($_SESSION['envoyé']);
                        }
                        ?>
                        <h1 class="text-center text-dark mb-4">Envoyez-nous un mail  : <a href="http://garagesports.alwaysdata.net">(inutilisable en local allez plutot sur notre site en cliquant)</a></h1>
                        <form method="POST" class="col">
                            <article class="row mb-4">
                                <article class="col">
                                    <article class="form-outline">
                                        <input type="text" class="form-control" name="nom" id="nom" <?php echo "value='$nom'" ?> required="required"/>
                                        <label class="form-label" for="nom">Nom</label>
                                    </article>
                                </article>
                                <article class="col">
                                    <article class="form-outline">
                                        <input type="email" class="form-control" name="email" id="email" <?php echo "value='$email'" ?>  required="required"/>
                                        <label class="form-label" for="email">Adresse Mail</label>
                                    </article>
                                </article>
                            </article>
                                <article class="form-outline mb-4">
                                    <textarea class="form-control" name="message" id="message" rows="4" required="required"></textarea>
                                    <label class="form-label" for="message">Message</label>
                                </article>
                            <article class="row">
                                <article class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Envoyer</button>
                                </article>
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
    <script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
    </body>
    </html>