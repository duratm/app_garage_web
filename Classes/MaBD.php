<?php
// Classe de connexion à une base de données
// S'inspire du pattern singleton pour n'ouvrir qu'une seule connexion
// Utilisation :
//    $bd = MaBD::getInstance(); // $bd est un objet PDO
class MaBD {

    static private $pdo = null; // Le singleton

    // Obenir le singleton
    static function getInstance(): ?PDO {

        if (self::$pdo == null) {
            $dsn = "pgsql:host=".$_ENV["POSTGRES_HOST"].";dbname=".$_ENV["POSTGRES_DB"].";user=".$_ENV["POSTGRES_USER"].";password=".$_ENV["POSTGRES_PASSWORD"];

            self::$pdo = new PDO($dsn);

        }
        return self::$pdo;
    }
}
