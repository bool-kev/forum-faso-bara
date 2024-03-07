<?php

use App\Functions;

$title = "Acceuil";
echo Functions::navbar(
    [
        "Home" => $router->url("Acceuil"),
        "Jobs" => $router->url("Acceuil")
    ],
    [
        "Se connecter" => $router->url("login"),
        "S'inscrire" => $router->url("register")
    ]
);

?>
<style>
    .body {
        height: 100vh;
        background-color: rgba(0, 0, 255, .75);
    }
</style>
<div class="container-fluid  body d-flex align-items-center justify-content-center ">
    <div class="btn btn-light p-4">Get Started</div>
    
</div>

<script>
    // document.querySelector(".content").style.height=window.screen.availHeight-180+'px';
</script>