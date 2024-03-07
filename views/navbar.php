<?php
    // dd($router->url('login'));
    $path="/bootstrap/dist/";
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?=$path.'css/bootstrap.min.css'?>">
    <style>
        .sign{
            display: inline-block !important;
        }

        .logo{
            font-weight: bold;
            font-style: italic;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="content">
    <nav class="navbar navbar-expand-lg bg-secondary bg-opacity-50">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand me-5 ps-3 logo" href="/">FASO BARA</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link btn "  href="/">Acceuil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn " href="#Offres">Offres</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link btn-md btn-primary me-3 text-center" href="<?=$router->url('register')?>">S'inscrire</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link btn-md btn-primary me-3 text-center" href="<?=$router->url('login')?>">Se connecter</a>
                    </li>
                </ul>
            </div>
    
    </nav>

