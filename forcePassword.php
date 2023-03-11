
<?php

function testpassword($mdp)	{ // $mdp le mot de passe passé en paramètre

// On récupère la longueur du mot de passe	
    $longueur = strlen($mdp);

// On fait une boucle pour lire chaque lettre
    for($i = 0; $i < $longueur; $i++) 	{

        // On sélectionne une à une chaque lettre
        // $i étant à 0 lors du premier passage de la boucle
        $lettre = $mdp[$i];

        if ($lettre>='a' && $lettre<='z'){
            // On ajoute 1 point pour une minuscule
            $point = $point + 1;

            // On rajoute le bonus pour une minuscule
            $point_min = 1;
        }
        else if ($lettre>='A' && $lettre <='Z'){
            // On ajoute 2 points pour une majuscule
            $point = $point + 2;

            // On rajoute le bonus pour une majuscule
            $point_maj = 2;
        }
        else if ($lettre>='0' && $lettre<='9'){
            // On ajoute 3 points pour un chiffre
            $point = $point + 3;

            // On rajoute le bonus pour un chiffre
            $point_chiffre = 3;
        }
        else {
            // On ajoute 5 points pour un caractère autre
            $point = $point + 5;

            // On rajoute le bonus pour un caractère autre
            $point_caracteres = 5;
        }
    }

// Calcul du coefficient points/longueur
    $etape1 = $point / $longueur;

// Calcul du coefficient de la diversité des types de caractères...
    $etape2 = $point_min + $point_maj + $point_chiffre + $point_caracteres;

// Multiplication du coefficient de diversité avec celui de la longueur
    $resultat = $etape1 * $etape2;

// Multiplication du résultat par la longueur de la chaîne
    $final = $resultat * $longueur;

    return $final;

}