<?php

use App\Auth;
use App\Functions;
use Model\Notifications;
use Model\User;

echo Functions::navbar(
    [
        "Home" => $router->url("home")
    ],
    [
        "Recrutement" => $router->url('recruteur'),
        "profils" => $router->url("profil"),
        "Se deconnecter" => [$router->url("logout"), "btn-danger"]

    ],
    '<a class="nav-link btn" data-bs-toggle="modal" data-bs-target="#notification">Notifications</a>'.PHP_EOL
);
$auth=new Auth("forum");
$user = $auth->getUser();
if ($user === null) {
    header("Location:{$router->url('login')}");
    exit();
}
$page=(int)($_GET['page']??1);
// dd($page);
if( $page<=0 || !$pagination=$auth->getAllOffre($page,$user->id)) {throw new Exception("NOT FOUND");};
// dd($pagination);
extract($pagination);

/**
 * @var Notifications[]
 */
$notifs=$auth->getNotification($user->id);
if(($_GET['forbiden']??null)==='1')
{
    echo Functions::alert("danger mt-2","Vous n'avez pas les permissions pour acceder a cette page",5000);
}
?>
<h1 class="display-4 text-center my-3">Liste des Offres disponibles</h1>
<div class="container">
    <div class="modal fade" id="notification" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="notificationLabel">Mes notifications</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php if(empty($notifs)):?>
                    <p class="d-flex justify-content-center mt-5 text-info">Aucune notification disponible</p>
                <?php endif?>
                    <?php foreach ($notifs as $notif) : ?>
                        <?php 
                            $color=$notif->etat==="Accepter"?"text-success":($notif->etat==="Rejeter"?"text-danger":'');
                        ?>
                        <h4 class="fs-5 <?=$color?>"><?=$notif->etat?></h4>
                        <p>Votre demande a l'offre recrutement de <?=$notif->nbre?> au poste de <?=$notif->poste?> a ete <span class="fw-bold <?=$color?>"><?=$notif->etat?></span>
                            <a href="<?=$router->url('details_offre',['id'=>$notif->id])?>">Offre ci</a>
                        </p>
                        <hr>
                    <?php endforeach ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
        <?php if(empty($Offres)):?>
            <p class="d-flex justify-content-center mt-5 text-info">Aucun Recrutement en cours</p>
            <a href="<?=$router->url('new_offre')?>" class="btn btn-primary mt-5 d-flex justify-content-center">Je recrute</a>
        <?php endif?>
        <?php foreach($Offres as $offre){
            $url=$router->url("details_offre",["id"=>$offre->id]);
            echo <<<HTML
            <div class="offre border border-2 border-primary my-3 p-4 mx-2 row">
                <div class="col-md-9">
                    <i class="d-block fw-bold">#nbre=$offre->nbre</i>
                    <p class="ms-5">$offre->annonce</p>
                    <i class="d-block fw-bold text-success">$offre->etat</i>
                    <i class="d-block fw-bold float-end">Poste=$offre->poste</i>
                </div>
                <div class="col-md-3 my-auto">
                    <a class="btn btn-primary float-end mt-3 mt-md-0" href="$url">En savoir plus</a>
                </div>
            </div>
            
HTML;      
        }?>
        <?php if($page>1):$target=$page-1?>
            <a href="<?=$router->url("home")."?page={$target}"?>" class="btn btn-primary my-3  mx-5">Precedent<-</a>
        <?php endif?>
        <?php if($next===true):$target=$page+1?>
            <a href="<?=$router->url("home")."?page={$target}"?>" class="btn btn-primary my-3 float-end mx-5">Suivant-></a>
        <?php endif?>
        
</div>