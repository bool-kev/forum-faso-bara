<?php
//  dd($params);

use App\Auth;
use App\Functions;
use Model\Offres;

$auth=new Auth("forum");
$user = $auth->getUser();
if ($user === null) {
    header("Location:{$router->url('login')}");
    exit();
}
/**
 * @var Offres
 */
$job=$auth->getOffre($params['id']);
if($job===null){
    header("Location:{$router->url('home')}");
    exit(); 
}
?>

<?php if(isset($_SESSION['errors']))
    {
        echo Functions::alert("danger mt-2 mx-5",$_SESSION['errors'],5000);

    }

    if(isset($_SESSION['success']))
    {
        echo Functions::alert("success mt-2 mx-5",$_SESSION['success'],5000);
    }
    unset($_SESSION['errors'],$_SESSION['success']);
    ?>

<div class="container">
    <h3 class="my-3 display-4">Details sur l'offre d'emploi</h3>
    <div class="my-5 mx-5">
        <div class="form-group my-3 mx-md-5">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" class="form-control"  id="poste" value="<?= $job->poste?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="salire" class="form-label">Salaire</label>
                <input type="text" class="form-control "  id="salaire" value="<?= $job->salaire?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="nbre" class="form-label">Nombre de poste a pourvoir</label>
            <input type="text" class="form-control " name="nbre" id="nbre" value="<?= "$user->telephone"?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control " name="ville" id="ville" value="<?= $job->location?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="sect" class="form-label">Nombre de Poste</label>
            <input type="text" class="form-control " name="sect" id="sect" value="<?= $job->nbre?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="create_at" class="form-label">date debut candidature</label>
            <input type="text" class="form-control " name="create_at" id="create_at" value="<?= $job->create_at?>" disabled>
        </div>
        <div class="form-group my-3 mx-md-5">
                <label for="fin" class="form-label">date limite candidature</label>
            <input type="text" class="form-control " name="fin" id="fin" value="<?= $job->date_fin?>" disabled>
        </div>

        <div class="form-group my-3 mx-md-5">
            <a class="btn btn-danger" href="javascript:window.history.back()">Retour<-</a>
            
            <form action="<?=$router->url("postuler")?>" method="POST" class="d-inline ms-5">
                <button class="btn btn-info" value="<?= "{$job->id}"?>" name="job">Postuler</button>
            </form>
        </div>
    </div>
</div>