<?php
// Sur cette page on a également besoin du fichier de classe
require 'ClassFiles/Character.php';
// On oublie pas de démarrer la session pour récupérer les variables de session du vainqueur
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-3 d-flex justify-content-center">
            <p class="h1 alert alert-success">LE VAINQUEUR EST : </p>
        </div>
        <div class="row my-3 d-flex justify-content-center">
            <div class="card col-3" style="width: 18rem;">
            <!-- Et pour terminer, on affiche les statistiques du personnage qui sort vainqueur du combat ! -->
                <img src="<?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->img : "Aucun vainqueur n'a été désigné" ?>"
                    class="card-img-top w-100" alt="Image du vainqueur">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getCharacterType() : "Aucun vainqueur n'a été désigné" ?>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre de points de vie restants :
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getHealth() : "Aucun vainqueur n'a été désigné" ?>
                        /
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->basicHealth : "Aucun vainqueur n'a été désigné" ?>
                    </li>
                    <li class="list-group-item">Défense :
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getShieldName() : "Aucun vainqueur n'a été désigné" ?>
                    </li>
                    <li class="list-group-item">Valeur de la défense :
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getShieldValue() : "Aucun vainqueur n'a été désigné" ?>
                    </li>
                    <li class="list-group-item">Arme :
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getWeaponName() : "Aucun vainqueur n'a été désigné" ?>
                    </li>
                    <li class="list-group-item">Les dégâts de l'arme sont compris entre
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->minDamage . " et " . $_SESSION['winner']->maxDamage . " points": "Aucun vainqueur n'a été désigné" ?>
                    </li>
                    <li class="list-group-item">Rage :
                        <?= (isset($_SESSION['winner'])) ? $_SESSION['winner']->getRage() : "Aucun vainqueur n'a été désigné" ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row my-3 d-flex justify-content-center">
            <div class="col-3">
                <!-- On propose à l'utlisateur de faire un nouveau combat, pour cela on passe un paramètre d'URL newgame qui nous servira sur l'index à détruire la session encore existante -->
                <a class="btn btn-success w-100" href="index.php?newgame=yes">NOUVEAU COMBAT</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>