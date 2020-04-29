<?php
// Si la superglobale $_GET contient une clé 'newGame'
if(isset($_GET['newgame'])) {
    // Alors on détruit la session actuelle,
    session_destroy();
    // et on redirige sur cette même page (afin de redonner un meilleur aspect à l'URL)
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Warcraft 4 - Choose your fighter !</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<!-- Création des cards pour la sélection du héros -->
<div class="container-fluid" id="chooseYou">
    <form action="startingSoon.php" method="post" class="h-100">
        <div class="row align-items-end justify-content-around h-100">
            <div class="card h-100" style="width: 18rem;">
                <img src="http://www.tipux.com/files/gfx_m_pic/8443/1294_400x600.jpg" class="card-img-top"
                    alt="Au bûcher !">
                <div class="card-body">
                    <h5 class="card-title">Le paladin</h5>
                    <p class="card-text">AU BÛCHER !!</p>
                    <button type="submit" name="characterChoice" value="paladin" class="btn btn-primary">Sélectionner</a>
                </div>
            </div>
            <div class="card h-100" style="width: 18rem;">
                <img src="http://www.tipux.com/files/gfx_m_pic/7940/1306_400x600.jpg" class="card-img-top"
                    alt="Un marron !">
                <div class="card-body">
                    <h5 class="card-title">Le mage</h5>
                    <p class="card-text">Qu'est-ce qui est petit et marron ?</p>
                    <button type="submit" name="characterChoice" value="mage" class="btn btn-primary">Sélectionner</a>
                </div>
            </div>
            <div class="card h-100" style="width: 18rem;">
                <img src="http://www.tipux.com/files/gfx_m_pic/2812/1296_400x600.jpg" class="card-img-top"
                    alt="Fils d'unijambiste">
                <div class="card-body">
                    <h5 class="card-title">L'assassin</h5>
                    <p class="card-text">Il ne mange pas de graines</p>
                    <button type="submit" name="characterChoice" value="assassin" class="btn btn-primary">Sélectionner</a>
                </div>
            </div>
            <div class="card h-100" style="width: 18rem;">
                <img src="http://www.tipux.com/files/gfx_m_pic/a087/1308_400x600.jpg" class="card-img-top"
                    alt="C'est pas faux">
                <div class="card-body">
                    <h5 class="card-title">Le développeur web</h5>
                    <p class="card-text">C'est pas faux</p>
                    <button type="submit" name="characterChoice" value="webDev" class="btn btn-primary">Sélectionner</a>
                </div>
            </div>
        </div>

    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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