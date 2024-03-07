<?php

use App\Router;

    require dirname(__DIR__).DIRECTORY_SEPARATOR."vendor/autoload.php";
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    $router=new Router(dirname(__DIR__).DIRECTORY_SEPARATOR."views");
    $router
        ->get("/","home","Acceuil")
        ->get("/login","auth/sign_in","login")
        ->get("/register","auth/sign_up","register")
        ->post("/traitement","auth/traitement",'traitement')
        ->post("/logout","auth/logout","logout")
        ->get('/myaccount','/interface/index','home')
        ->get('/myaccount/profil','interface/profil','profil')
        ->get('/myaccount/recruteur','interface/recruteur','recruteur')
        ->get('/myaccount/job-[i:id]','interface/offres/show','details_offre')
        ->post('/myaccount/post','interface/offres/post','postuler')
        ->map('/myaccount/newRecrutement','interface/offres/new_offre','new_offre')
        ->post('/myaccount/updateOffre-[i:id]','interface/offres/update_offre','updateOffre')
        ->map('/myaccount/suivi_offre-[i:id]','interface/offres/suivi_offre','suivi_offre')
        ->post('/myaccount/offre/request-[i:postulant]-[i:job]','interface/offres/request','request')
        ->run();  
?>