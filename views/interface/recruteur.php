<?php

use App\Auth;
use App\Functions;
echo Functions::navbar(
    [
        "Home" => $router->url("home")
    ],
    [
       "Recruter"=>$router->url("new_offre")
    ]
);
$auth=new Auth("forum");
$user=$auth->getUser();
if($user===null) {header("Location:{$router->url('login')}");exit();}
/**
 * @var Offfres[]
 */
$offres=$auth->getMyOffre($user->id);
// dd($offres);
?>

<h1 class="display-4 text-center my-3">Vos recrutement </h1>
<div class="container">
        <?php if(empty($offres)):?>
           
            <p class=" d-flex justify-content-center mt-5 text-info">Aucun Recrutement en cours</p>
            <a href="<?=$router->url('new_offre')?>" class="btn btn-primary mt-5 d-flex justify-content-center">Je recrute</a>
        <?php endif?>
        <?php foreach($offres as $offre){
            $modif=$router->url("updateOffre",["id"=>$offre->id]);
            $suivi=$router->url("suivi_offre",["id"=>$offre->id]);
            // dd($auth->getPostulant($offre->id));
            $postulant=count($auth->getPostulant($offre->id));
            echo <<<HTML
            <div class="offre border border-2 border-primary my-3 p-4 mx-2 row">
                <div class="col-md-9">
                    <i class="d-block fw-bold">#postulants=$postulant</i>
                    <p class="ms-5">Recrutement de <i class="fw-bold">$offre->nbre</i> Personnes au poste de <i class="fw-bold">$offre->poste</i></p>
                    <i class="d-block fw-bold text-success">$offre->etat</i>
                </div>
                <div class="col-md-3 my-auto">
                    <form action="$modif" method="post" class="d-inline mt-3 mt-md-0 "><input type="submit" class="btn btn-warning  "  value="Modifier"></form>
                    <form action="$suivi" method="post" class="d-inline mt-md-0 mt-md-3 mt-lg-0 ms-lg-3"><input type="submit" class="btn btn-primary  "  value="suivis"></form>
                    
                </div>
            </div>
            
HTML;      
        }?>
        
</div>