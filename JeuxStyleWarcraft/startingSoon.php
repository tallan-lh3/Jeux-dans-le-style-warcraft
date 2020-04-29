<?php
// On va chercher le fichier de classe contenant toutes les informations sur un personnage
require "ClassFiles/Character.php";
// Pour créer des variables de session et pouvoir les réutiliser sur chacune des pages concernées, on démarre la session
session_start();
// Si le tableau superglobal POST contient une clé 'characterChoice' (qui correspond au choix du héros)
if(isset($_POST['characterChoice'])) {
    // On fait un switch sur la valeur de ce POST
    switch($_POST['characterChoice']) {
        // Dans le cas paladin
        case "paladin":
            // Initialisation d'une nouvelle variable définissant le type du personnage
            $characterType = "Paladin";
            // Initialisation d'une nouvelle variable définissant la vie du personnage selon un random entre une valeur minimale et maximale
            $health = rand(2000,3000);
            // Initialisation d'une nouvelle variable définissant la rage du personnage
            $rage = 0;
            // Initialisation d'une nouvelle variable définissant le nom de l'armure / bouclier du personnage
            $shieldName = "Armure de plaques";
            // Initialisation d'une nouvelle variable définissant la valeur de l'armure / bouclier du personnage selon un random entre une valeur minimale et maximale
            $shieldValue = rand(800, 1500);
            // Initialisation d'une nouvelle variable définissant le nom de l'arme du personnage
            $weaponName = "Espadon";
            // Création de l'objet correspondant en instanciant la classe Character, pour répondre aux attentes du contructeur, on passe en paramètre de la classe toutes les variables nécessaires précédemment initialisées
            $Paladin = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            // Pour conserver cet objet et rendre le tout dynamique sans avoir à faire des conditions pour chaque scénario de combat,
            // on stocke l'objet dans une variable de session 'hero'
            $_SESSION['hero'] = $Paladin;
            // A cette variable de session, on ajoute quelques paramètres nécessaire au bon fonctionnement :
            // - l'image du personnage
            $_SESSION['hero']->img = "http://www.tipux.com/files/gfx_m_pic/8443/1294_400x600.jpg";
            // - le minimum de dégâts du personnage
            $_SESSION['hero']->minDamage = 400;
            // - le maximum de dégâts du personnage
            $_SESSION['hero']->maxDamage = 600;
            // - la valeur du gain de rage du personnage
            $_SESSION['hero']->rageGain = 30;
            // - la vie basique du personnage à sa création
            $_SESSION['hero']->basicHealth = $health;
            // - la valeur basique de la protection de l'armure / bouclier du personnage
            $_SESSION['hero']->basicShieldValue = $shieldValue;
        break;
        case "mage":
            $characterType = "Mage";
            $health = rand(1000,1500);
            $rage = 0;
            $shieldName = "Robe noire";
            $shieldValue = rand(500, 700);
            $weaponName = "Bâton des flammes froides";
            $Mage = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['hero'] = $Mage;
            $_SESSION['hero']->img = "http://www.tipux.com/files/gfx_m_pic/7940/1306_400x600.jpg";
            $_SESSION['hero']->minDamage = 600;
            $_SESSION['hero']->maxDamage = 800;
            $_SESSION['hero']->rageGain = 20;
            $_SESSION['hero']->basicHealth = $health;
            $_SESSION['hero']->basicShieldValue = $shieldValue;
        break;
        case "assassin":
            $characterType = "Assassin";
            $health = rand(800,1300);
            $rage = 0;
            $shieldName = "Cape de voleur";
            $shieldValue = rand(300, 400);
            $weaponName = "Dague empoisonnée";
            $Assassin = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['hero'] = $Assassin;
            $_SESSION['hero']->img = "http://www.tipux.com/files/gfx_m_pic/2812/1296_400x600.jpg";
            $_SESSION['hero']->minDamage = 600;
            $_SESSION['hero']->maxDamage = 800;
            $_SESSION['hero']->rageGain = 20;
            $_SESSION['hero']->basicHealth = $health;
            $_SESSION['hero']->basicShieldValue = $shieldValue;
        break;
        case "webDev":
            $characterType = "Développeur Web";
            $health = rand(1500,1800);
            $rage = 0;
            $shieldName = "Armure de câbles RJ-45";
            $shieldValue = rand(300, 500);
            $weaponName = "Ordinateur vieillissant";
            $WebDev = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['hero'] = $WebDev;
            $_SESSION['hero']->img = "http://www.tipux.com/files/gfx_m_pic/a087/1308_400x600.jpg";
            $_SESSION['hero']->minDamage = 400;
            $_SESSION['hero']->maxDamage = 700;
            $_SESSION['hero']->rageGain = 40;
            $_SESSION['hero']->basicHealth = $health;
            $_SESSION['hero']->basicShieldValue = $shieldValue;
        break;
    }
    // On ne donne pas la possibilité à l'utilisateur de choisir son ennemi, on le définit donc aléatoirement avec un random entre 1 et 4
    $enemyRand = rand(1,4);
    // Le fonctionnement de ce switch est le même que pour les héros, si ce n'est qu'ici on se base sur un random généré par la machine pour définir l'ennemi
    switch($enemyRand){
        case 1:
            $characterType = "Revenant";
            $health = rand(1000,1300);
            $rage = 0;
            $shieldName = "Aucune protection";
            $shieldValue = 0;
            $weaponName = "Ongles";
            $Revenant = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['enemy'] = $Revenant;
            $_SESSION['enemy']->img = "https://fac.img.pmdstatic.net/fit/http.3A.2F.2Fprd2-bone-image.2Es3-website-eu-west-1.2Eamazonaws.2Ecom.2Fprismamedia_people.2F2017.2F06.2F30.2Fc9d52544-ac11-4e20-8b6a-3b216fce713d.2Ejpeg/326x326/quality/80/crop-from/center/johnny-hallyday.jpeg";
            $_SESSION['enemy']->minDamage = 200;
            $_SESSION['enemy']->maxDamage = 400;
            $_SESSION['enemy']->rageGain = 20;
            $_SESSION['enemy']->basicHealth = $health;
            $_SESSION['enemy']->basicShieldValue = $shieldValue;
        break;
        case 2:
            $characterType = "Uruk Haï";
            $health = rand(1500,2000);
            $rage = 0;
            $shieldName = "Armure de piques";
            $shieldValue = rand(700, 1000);
            $weaponName = "Fléau";
            $Uruk = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['enemy'] = $Uruk;
            $_SESSION['enemy']->img = "https://i.pinimg.com/originals/d5/a4/f5/d5a4f5e9b407f4ca16ae93046fb44952.jpg";
            $_SESSION['enemy']->minDamage = 500;
            $_SESSION['enemy']->maxDamage = 800;
            $_SESSION['enemy']->rageGain = 20;
            $_SESSION['enemy']->basicHealth = $health;
            $_SESSION['enemy']->basicShieldValue = $shieldValue;
        break;
        case 3:
            $characterType = "Coronuviras";
            $health = rand(2000,3000);
            $rage = 0;
            $shieldName = "Armure en peau de chauve-souris";
            $shieldValue = rand(500, 700);
            $weaponName = "Masse";
            $Coronuviras = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['enemy'] = $Coronuviras;
            $_SESSION['enemy']->img = "https://steamuserimages-a.akamaihd.net/ugc/101730239251247513/413E42510311D458D6CA753A56E2A37D05570053/";
            $_SESSION['enemy']->minDamage = 700;
            $_SESSION['enemy']->maxDamage = 1000;
            $_SESSION['enemy']->rageGain = 20;
            $_SESSION['enemy']->basicHealth = $health;
            $_SESSION['enemy']->basicShieldValue = $shieldValue;
        break;
        case 4:
            $characterType = "Le Bug";
            $health = rand(1,9999);
            $rage = 0;
            $shieldName = "Armure d'erreurs système";
            $shieldValue = rand(10, 600);
            $weaponName = "AiremeTiréAireÉfÉToile";
            $Bug = new Character($characterType, $health, $rage, $shieldName, $shieldValue, $weaponName);
            $_SESSION['enemy'] = $Bug;
            $_SESSION['enemy']->img = "https://static.turbosquid.com/Preview/2016/03/14__23_58_21/MinecraftCreeper02.jpg2a29f0cd-04de-4935-998b-8fe7735414efZoom.jpg";
            $_SESSION['enemy']->minDamage = 500;
            $_SESSION['enemy']->maxDamage = 800;
            $_SESSION['enemy']->rageGain = 5;
            $_SESSION['enemy']->basicHealth = $health;
            $_SESSION['enemy']->basicShieldValue = $shieldValue;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Warcraft 4 - Préparation du combat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <!-- La page starting soon nous donne un premier visuel du combat : on retrouve une carte avec le choix du héros contre une carte ennemi choisie par la machine -->

    <div class="container-fluid">
        <div class="row my-3">
            <div class="card offset-1 col-3" style="width: 18rem;">
            <!-- Comme les objets sont stockés dans des variables de session, on ne fait plus appel à l'objet mais directement à ces variables -->
                <img src="<?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->img : "" ?>" class="card-img-top w-100"
                    alt="Image du héros">
                <div class="card-body">
                    <h5 class="card-title">
                    <!-- Idem pour les interactions avec la classe, une méthode sera appelée en passant par la variable de session (qui contient l'objet) -->
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getCharacterType() : "Vous n'avez pas choisi de héro" ?>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre de points de vie :
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->getHealth() : "Vous n'avez pas choisi de héro" ?>
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
                    <li class="list-group-item">Les dégâts de l'arme seront compris entre
                        <?= (isset($_SESSION['hero'])) ? $_SESSION['hero']->minDamage . " et " . $_SESSION['hero']->maxDamage . " points": "Vous n'avez pas choisi de héro" ?>
                    </li>
                </ul>
            </div>
            <div class="col-4 mt-5">
                <img src="assets/versus.png" class="card-img w-100" alt="Versus logo">
                <form action="fight.php" method="post">
                    <button type="submit" class="btn btn-danger w-100 align-middle" href="fight.php">FIGHT !</a>
                </form>
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
                    <li class="list-group-item">Nombre de points de vie :
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->getHealth() : "L'ennemi n'a pas été défini" ?>
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
                    <li class="list-group-item">Les dégâts de l'arme seront compris entre
                        <?= (isset($_SESSION['enemy'])) ? $_SESSION['enemy']->minDamage . " et " . $_SESSION['enemy']->maxDamage . " points": "L'ennemi n'a pas été défini" ?>
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