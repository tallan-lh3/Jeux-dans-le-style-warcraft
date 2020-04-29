<?php

// Bon, c'est ici qu'il va falloir s'accrocher, prenez un café ça va être long :)

// On appelle dans un premier temps le fichier de classe
require 'ClassFiles/Character.php';
// On démarre ensuite la session afin de conserver et utiliser les variables de session précédemment créées
session_start();

// Si la vie du héros est supérieure à 0 ET que la vie de l'ennemi est supérieure à 0 ET que le compteur de mort n'est pas défini
// OU
// Si la vie du héros est supérieure à 0 ET que la vie de l'ennemi est supérieure à 0 ET que le compteur de mort est défini ET que la valeur du compteur est supérieure à 0
if($_SESSION['hero']->getHealth() > 0 && $_SESSION['enemy']->getHealth() > 0 && !isset($_SESSION['hero']->deathCounter) ||
$_SESSION['hero']->getHealth() > 0 && $_SESSION['enemy']->getHealth() > 0 && isset($_SESSION['hero']->deathCounter) && $_SESSION['hero']->deathCounter > 0){
    
    // Alors on initiliase un tableau à vide qui nous permettra de recenser toutes les informations du champ de bataille
    $battleReport = [];
    
    // ----------------------------------------------- ATTAQUE HÉROS ----------------------------------------------- \\
    
    // Si la rage du héros est supérieure ou égale à 100 ET que le dompteur d'handicap n'est pas défini
    // OU
    // Si la rage du héros est supérieure ou égale à 100 ET que le dompteur d'handicap est pas défini ET que la valeur du compteur de handicap est égale à 0
    // OU
    // Si la rage du héros est supérieure ou égale à 100 ET que le dompteur de mort est défini ET que la valeur du compteur de mort est supérieure à 0
    if($_SESSION['hero']->getRage() >= 100 && !isset($_SESSION['hero']->disableCounter) || 
    $_SESSION['hero']->getRage() >= 100 && isset($_SESSION['hero']->disableCounter) && $_SESSION['hero']->disableCounter == 0 ||
    $_SESSION['hero']->getRage() >= 100 && isset($_SESSION['hero']->deathCounter) && $_SESSION['hero']->deathCounter > 0) {

        // Alors on initialise un switch avec pour paramètre le type du héros
        switch($_SESSION['hero']->getCharacterType()){
            
            // Dans le cas où le type est égal à Paladin
            case 'Paladin':
                // On appelle la méthode attack en lui passant en paramètre (le minimum de dégâts x 3) et (le maximum de dégâts x 3)
                // x 3 correspond à la caractéristique du Paladin d'attaquer pour 3 fois sa valeur de dégâts initiale lorsqu'il est enragé
                $_SESSION['hero']->attack($_SESSION['hero']->minDamage * 3,$_SESSION['hero']->maxDamage * 3);
                // Si la valeur de l'attaque nouvellement définie est inférieure à la valeur de l'armure de l'ennemi
                if($_SESSION['hero']->getWeaponValue() < $_SESSION['enemy']->getShieldValue()){
                    // Alors cela ne sert à rien de faire attaquer le héros puisque l'ennemi est trop résistant,
                    // On initialise donc le tableau de rapport de bataille avec un message indiquant que le héros n'a pu passer l'armure / bouclier de l'ennemi
                    $battleReport['lackHeroPower'] = "L'attaque du Héros n'était pas assez puissante pour passer l'armure de l'ennemi !";
                } else {
                    // Sinon, cela veut dire que le héros tape suffisamment fort pour descendre les points de vie de l'ennemi,
                    // On appelle donc la méthode loseHealth permettant de faire perdre de la vie sur l'ennemi en lui passant en paramètre la valeur de l'attaque du héros
                    $_SESSION['enemy']->loseHealth($_SESSION['hero']->getWeaponValue());
                    // Le héros a fait mal à l'ennemi, celui-ci doit alors contrôler sa rage et donc en gagner,
                    // On appelle alors la méthode permettant cela en lui passant en paramètre la valeur du gain de rage de l'ennemi
                    $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
                }
                
            break;
            
            // Pour les héros les cas 'Paladin', 'Mage' et 'Assassin' se ressemblent, la seule différence provient du multiplicateur de dégâts à appliquer

            case 'Mage':
                $_SESSION['hero']->attack($_SESSION['hero']->minDamage * 4,$_SESSION['hero']->maxDamage * 4);
                if($_SESSION['hero']->getWeaponValue() < $_SESSION['enemy']->getShieldValue()){
                    $battleReport['lackHeroPower'] = "L'attaque du Héros n'était pas assez puissante pour passer l'armure de l'ennemi !";
                } else {
                    $_SESSION['enemy']->loseHealth($_SESSION['hero']->getWeaponValue());
                    $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
                }
            break;
            
            case 'Assassin':
                $_SESSION['hero']->attack($_SESSION['hero']->minDamage * 2,$_SESSION['hero']->maxDamage * 2);
                if($_SESSION['hero']->getWeaponValue() < $_SESSION['enemy']->getShieldValue()){
                    $battleReport['lackHeroPower'] = "L'attaque du Héros n'était pas assez puissante pour passer l'armure de l'ennemi !";
                } else {
                    $_SESSION['enemy']->loseHealth($_SESSION['hero']->getWeaponValue());
                    $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
                }
            break;
            
            // Pour le cas Développeur Web
            case 'Développeur Web':
                // Si la vie du héros est inférieure à celle de l'ennemi
                if($_SESSION['hero']->getHealth() < $_SESSION['enemy']->getHealth()) {
                    // Alors on réinitialise fictivement le combat,
                    // On redéfinit donc les valeurs de vie et de bouclier selon les basiques établis lors de la création des personnages
                    $_SESSION['hero']->setHealth($_SESSION['hero']->basicHealth);
                    $_SESSION['hero']->setShieldValue($_SESSION['hero']->basicShieldValue);
                    // Et bien sûr on stocke un message dans le rapport de bataille indiquant que le WebDev a réinitialisé les statistiques par défaut
                    $battleReport['reset'] = "VOUS N'ÊTES PAS PRÊTS !!!!! (Le développeur web a redémarré le combat !)";
                }
            break;
        }
    // Sinon si le compteur de handicap est défini ET que la valeur du compteur de handicap est supérieure à 0    
    }else if(isset($_SESSION['hero']->disableCounter) && $_SESSION['hero']->disableCounter > 0) {
        // Alors cela veut dire que le héros a eu le bras cassé par l'Uruk Haï et donc qu'il ne doit pas attaquer
        // On décrémente alors le compteur de handicap de 1,
        $_SESSION['hero']->disableCounter --;
        // Et on stocke dans le rapport de bataille un message indiquant que le héros n'a pu attaquer tout en indiquant le nombre de tours de handicap restant
        $battleReport['disableCounter'] = "Le héros ne peut pas attaquer ! Son bras est cassé pour encore " . $_SESSION['hero']->disableCounter . " tour(s) !";
    // Sinon
    } else {
        // Si le compteur de mort est défini ET que la valeur du compteur de mort est égale à 0
        if(isset($_SESSION['hero']->deathCounter) && $_SESSION['hero']->deathCounter == 0) {
            // Alors le combat est terminé puisque le Coronuviras a survecu pendant 5 tours,
            // On stocke donc un message dans le tableau de rapport de bataille
            $battleReport['deathCounterZero'] = "L'Ennemi a fini d'incanter son plus puissant sort, le Héros est mort !";
        }
        // On applique alors le scénario de combat basique, le héros attaque sans être enragé
        // On appelle alors la méthode attack afin de définir une valeur de dégâts sans multiplicateurs entre un min et un max précédemment définis
        $_SESSION['hero']->attack($_SESSION['hero']->minDamage,$_SESSION['hero']->maxDamage);
        // Même scénario que pour le cas enragé :
        // Si la valeur des dégâts du héros est inférieure à la valeur de l'armure de l'ennemi
        if($_SESSION['hero']->getWeaponValue() < $_SESSION['enemy']->getShieldValue()){
            // Alors on ne fait pas attaquer le héros et on stocke un message dans le rapport de bataille
            $battleReport['lackHeroPower'] = "L'attaque du Héros n'était pas assez puissante pour passer l'armure de l'ennemi !";
            // Toutefois, l'ennemi gagne quand même de la rage puisqu'il a reçu un coup
            $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
        } else {
            // Sinon, cela veut dire que le héros attaque suffisamment fort et va donc causer des dégâts à l'ennemi,
            // On appelle alors la méthode loseHealth pour faire perdre de la vie àl'ennemi
            $_SESSION['enemy']->loseHealth($_SESSION['hero']->getWeaponValue());
            // Puis on fait gagner de la rage à l'ennemi
            $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
        }
    }
    // Si le compteur de mort est défini ET que la valeur du compteur de mort est supérieure à 0
    if(isset($_SESSION['hero']->deathCounter) && $_SESSION['hero']->deathCounter > 0) {
        // Alors on décrémente la valeur
        $_SESSION['hero']->deathCounter --;
        // Et on sotkce un message dans le rapport de bataille indiquant le nombre de tours restant avant la mort du héros
        $battleReport['deathCounterZero'] = "L'Ennemi est en train d'incanter son plus puissant sort, le Héros va mourir dans " . $_SESSION['hero']->deathCounter . " !";
    }
    
    // ----------------------------------------------- ATTAQUE ENNEMIE ----------------------------------------------- \\
    
    // On retrouve le même fonctionnement pour les ennemis, je vous laisse le plaisir de commenter les parties similaires :D
    if($_SESSION['enemy']->getRage() >= 100) {
        switch($_SESSION['enemy']->getCharacterType()){
            
            case 'Revenant':
                $_SESSION['enemy']->attack($_SESSION['enemy']->minDamage + 300,$_SESSION['enemy']->maxDamage + 300);
                if($_SESSION['enemy']->getWeaponValue() < $_SESSION['hero']->getShieldValue()){
                    $battleReport['lackEnemyPower'] = "L'attaque de l'Ennemi n'était pas assez puissante pour passer l'armure du Héros !";
                } else {
                    $_SESSION['hero']->loseHealth($_SESSION['enemy']->getWeaponValue());
                    $_SESSION['hero']->controlRage($_SESSION['hero']->rageGain);
                }
                
            break;
            
            case 'Uruk Haï':
                // Si l'Uruk Haï est enragé, on crée un compteur d'handicap,
                // Celui-ci va nous aider dans les conditions du héros pour savoir s'il doit attaquer ou non,
                // Afin de le conserver entre chaque refresh, on le stocke dans une variable de session, qui, tant qu'à faire, sera la même qui contient l'objet
                $_SESSION['hero']->disableCounter = 2;
                $_SESSION['hero']->controlRage($_SESSION['hero']->rageGain);
                // Ici il s'agit d'un cas un peu particulier, on doit rappeler la méthode controlRage afin de faire redescendre directement la rade de l'ennemi à 0
                $_SESSION['enemy']->controlRage($_SESSION['enemy']->rageGain);
                $battleReport['breakArm'] = "Dans sa folie meurtrière, l'Ennemi casse le bras du Héros ! Il ne pourra plus agir pendant 2 tours !";
            break;
            
            case 'Coronuviras':
                // De même pour le Coronuviras, on initialise un compteur dans une session
                $_SESSION['hero']->deathCounter = 5;
                $_SESSION['hero']->controlRage($_SESSION['hero']->rageGain);
                $battleReport['startDeathCounter'] = "L'Ennemi incante un puissant sort, si le Héros ne le tue pas en moins de 5 tours il sera abattu !";
            break;
            
            case 'Le Bug':
                // Petite subtilité, pour le bug, une fois arrivé à 100 de rage, il redirige sur une page de wikipedia :)
                header('Location: https://fr.wikipedia.org/wiki/Bug_(informatique)');
            break;
        }
    } else {
        $_SESSION['enemy']->attack($_SESSION['enemy']->minDamage,$_SESSION['enemy']->maxDamage);
        if($_SESSION['enemy']->getWeaponValue() < $_SESSION['hero']->getShieldValue()){
            $battleReport['lackEnemyPower'] = "L'attaque de l'Ennemi n'était pas assez puissante pour passer l'armure du Héros !";
            $_SESSION['hero']->controlRage($_SESSION['hero']->rageGain);
        } else {
            $_SESSION['hero']->loseHealth($_SESSION['enemy']->getWeaponValue());
            $_SESSION['hero']->controlRage($_SESSION['hero']->rageGain);
        }
    }
// Sinon si le compteur de mort est défini ET que le compteur de mort est égal à 0
} else if(isset($_SESSION['hero']->deathCounter) && $_SESSION['hero']->deathCounter == 0){
    // Alors le vainqueur est l'ennemi,
    // On stocke donc les informations de l'ennemi dans une nouvelle variable de session pour définir le vainqueur et l'afficher sur la page winner.php
    $_SESSION['winner'] = $_SESSION['enemy'];
    // Puis on redirige directement l'utilisateur sur la page d'affichage du vainqueur
    header('Location: winner.php');
// Sinon si la vie du héros est inférieure ou égale à 0
} else if($_SESSION['hero']->getHealth() <= 0) {
    // Alors le vainqueur est l'ennemi
    $_SESSION['winner'] = $_SESSION['enemy'];
    header('Location: winner.php');
// Sinon
} else {
    // Le vainqueur est donc le héros
    $_SESSION['winner'] = $_SESSION['hero'];
    header('Location: winner.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>FIGHT !</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row my-3">
            <div class="card offset-1 col-3" style="width: 18rem;">
                <img src="<?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->img : "" ?>" class="card-img-top w-100"
                    alt="Image du héros">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getCharacterType() : "Vous n'avez pas choisi de héro" ?>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre de points de vie restants :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getHealth() : "Vous n'avez pas choisi de héro" ?>
                        /
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->basicHealth : "Vous n'avez pas choisi de héro" ?>
                    </li>
                    <li class="list-group-item">Défense :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getShieldName() : "Vous n'avez pas choisi de héro" ?>
                    </li>
                    <li class="list-group-item">Valeur de la défense :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getShieldValue() : "Vous n'avez pas choisi de héro" ?>
                    </li>
                    <li class="list-group-item">Arme :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getWeaponName() : "Vous n'avez pas choisi de héro" ?>
                    </li>
                    <li class="list-group-item">Les dégâts de l'arme sont compris entre
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->minDamage . " et " . $_SESSION['hero']->maxDamage . " points": "Vous n'avez pas choisi de héro" ?>
                    </li>
                    <li class="list-group-item">Rage :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getRage() : "Vous n'avez pas choisi de héro" ?>
                    </li>
                </ul>
            </div>
            <div class="col-4 mt-5">
                <img src="assets/versus.png" class="card-img w-100" alt="Versus logo">
                <div class="alert alert-warning" role="alert">
                <!-- Les différentes informations du rapport de bataille seront renvoyées ici -->
                    <h4 class="alert-heading">Résumé de la bataille</h4>
                    <p>Le héros attaque pour <span class="alert-link"><?= $_SESSION['hero']->getWeaponValue() ?></span>
                        points de dégâts.</p>
                    <?php
                if($_SESSION['hero']->getWeaponValue() < $_SESSION['enemy']->getShieldValue()) {
                    ?>
                    <p>Mais l'armure de l'Ennemi était trop résistante, il ne perd donc aucun point de vie.</p>
                    <?php
                } else if($_SESSION['enemy']->getShieldValue() > 0) {
                    ?>
                    <p>L'Ennemi n'encaisse donc que <span
                            class="alert-link"><?= $_SESSION['hero']->getWeaponValue() - $_SESSION['enemy']->getShieldValue()?></span>
                        points de dégâts grâce à son armure.</p>
                    <?php
                } else {
                    ?>
                    <p>L'Ennemi encaisse donc <span
                            class="alert-link"><?= $_SESSION['hero']->getWeaponValue() - $_SESSION['enemy']->getShieldValue()?></span>
                        points de dégâts.</p>
                    <?php
                }
                ?>
                    <hr>
                    <?php
                if($_SESSION['enemy']->getRage() < 100) {
                    ?>
                    <p>L'Ennemi gagne <span class="alert-link"><?= $_SESSION['enemy']->rageGain ?></span> points de
                        rage.</p>
                    <?php
                } else {
                    ?>
                    <p>L'Ennemi déclenchera sa capacité spéciale au prochain tour et retombera à 0 point de rage.</p>
                    <?php
                }
                ?>

                    <p>L'Ennemi attaque pour <span class="alert-link"><?= $_SESSION['enemy']->getWeaponValue() ?></span>
                        points de dégâts.</p>
                    <?php
                if($_SESSION['enemy']->getWeaponValue() < $_SESSION['hero']->getShieldValue()) {
                    ?>
                    <p>Mais l'armure du Héros était trop résistante, il ne perd donc aucun point de vie.</p>
                    <?php
                } else {
                    ?>
                    <p>Le Héros n'encaisse donc que <span
                            class="alert-link"><?= $_SESSION['enemy']->getWeaponValue() - $_SESSION['hero']->getShieldValue()?></span>
                        points de dégâts grâce à son armure.</p>
                    <?php
                }
                ?>
                    <hr>
                    <?php
                if($_SESSION['hero']->getRage() < 100) {
                    ?>
                    <p>Le Héros gagne <span class="alert-link"><?= $_SESSION['hero']->rageGain ?></span> points de rage.
                    </p>
                    <?php
                } else {
                    ?>
                    <p>Le Héros déclenchera sa capacité spéciale au prochain tour et retombera à 0 point de rage.</p>
                    <?php
                }
                ?>
                </div>
                <?php
            if(isset($battleReport)) {
                foreach($battleReport as $key => $report) {
                    if($key == "reset" || $key == "breakArm" || $key == "startDeathCounter" || $key == "disableCounter" || $key == "deathCounter" || $key == "deathCounterZero"){
                        ?>
                <div class="alert alert-danger alert-heading" role="alert">
                    <?= $report ?>
                </div>
                <?php
                    } else if($key == 'lackHeroPower'){
                        ?>
                <div class="alert alert-danger" role="alert">
                    <?= $report ?>
                </div>
                <?php
                    } else if($key == 'lackEnemyPower'){
                        ?>
                <div class="alert alert-danger" role="alert">
                    <?= $report ?>
                </div>
                <?php
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Bravo vous êtes tombé sur une erreur que je n'avais pas géré :D
                        </div>
                        <?php
                    }
                }
            }
                ?>
                <!-- Comme toutes les informations des 2 personnages sont stockées dans des variables de session, un simple refresh de la page suffit à créer un round supplémentaire ! -->
                <a class="btn btn-danger w-100" href="fight.php">ROUND SUIVANT</a>
                <?php
            ?>
            </div>
            <div class="col-3 card align-middle" style="width: 18rem;">
                <img src="<?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->img : "" ?>" class="card-img-top"
                    alt="Image de l'ennemi">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getCharacterType() : "L'ennemi n'a pas été défini" ?>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre de points de vie restants :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getHealth() : "L'ennemi n'a pas été défini" ?>
                        /
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->basicHealth : "L'ennemi n'a pas été défini" ?>
                    </li>
                    <li class="list-group-item">Défense :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getShieldName() : "L'ennemi n'a pas été défini" ?>
                    </li>
                    <li class="list-group-item">Valeur de la défense :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getShieldValue() : "L'ennemi n'a pas été défini" ?>
                    </li>
                    <li class="list-group-item">Arme :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getWeaponName() : "L'ennemi n'a pas été défini" ?>
                    </li>
                    <li class="list-group-item">Les dégâts de l'arme sont compris entre
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->minDamage . " et " . $_SESSION['enemy']->maxDamage . " points": "L'ennemi n'a pas été défini" ?>
                    </li>
                    <li class="list-group-item">Rage :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getRage() : "L'ennemi n'a pas été défini" ?>
                    </li>
                </ul>
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