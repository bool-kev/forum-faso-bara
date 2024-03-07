<?php
    use App\Auth;
    use App\Functions;
use Model\Postulants;

    echo Functions::navbar([
        "Home"=>$router->url("home")
    ],
    [
        "Precedent"=>$router->url("recruteur")
    ]);
    
    $auth=new Auth("forum");
    $user = $auth->getUser();
    // dump($user);
    if ($user === null) {
        header("Location:{$router->url('login')}");
        exit();
    }
  
    $job=$auth->getOffre($params['id']);
    if($job===null){
        header("Location:{$router->url('home')}");
        exit(); 
    }

    if($user->id!==$job->recruteur)
    {
        header("Location:{$router->url('home')}?forbiden=1");
        exit(); 
    }
    /**
     * @var Postulants[]
     */
    $postulants=$auth->getPostulant($job->id);
    // dd($postulants);
    if(isset($_SESSION['errors']))
    {
        echo Functions::alert("danger mt-2 mx-5",$_SESSION['errors'],5000);
        unset($_SESSION['errors']);

    }
?>
<div class="container">
    <h1 class="display-5">Liste des postulant</h1>
    <div class="row mt-5">
        <?php if(empty($postulants)):?>
           <p class=" d-flex justify-content-center mt-5 text-info">Aucun Postulant pour l'instant</p>
           <a href="<?=$router->url('recruteur')?>" class="btn btn-primary mt-5 d-flex justify-content-center">Coming Soon</a>
       <?php endif?>
       <?php foreach($postulants as $postulant){
            $btn='';
            $class='';
            $link=$router->url("request",["postulant"=>$postulant->id,"job"=>$job->id]);
            $attribut=$postulant->etat!=="En attente de validation"?"disabled":'';
            $color=$postulant->etat==="Accepter"?"text-success":($postulant->etat==="Rejeter"?"text-danger":"");
            if($postulant->etat!=="En attente de validation"){
                $class=" visually-hidden";
                $btn="<form action='$link' method='post' class='d-inline '><input type='submit' class='btn btn-danger mb-2'  value='annuler' name='annuler'></form>".PHP_EOL;
            }
            echo <<<HTML
            <div class="border border-2 border-secondary mb-3" >
                <div class="left d-inline ps-3">
                    <i class="d-block "><span class="fw-bold">Nom et Prenom: </span>$postulant->username</i>
                    <i class="d-block"><span class="fw-bold">#Telephone:</span>$postulant->telephone</i>
                    <i class="d-block $color"><span class="fw-bold ">statut:</span>$postulant->etat</i>
                    <i class="d-block"><span class="fw-bold">Date:</span>$postulant->create_at</i>
                </div>
                <div class="right d-inline float-end">
                    $btn
                    <form action="$link" method="post" class="d-inline "><input type="submit" class="btn btn-success mb-2 $class"  value="Accepter" name="accept" $attribut></form>
                    <form action="$link" method="post" class="d-inline"><input type="submit" class="btn btn-warning  mb-2 $class"  value="rejeter" name="drop" $attribut></form>
                </div>
            </div>
HTML;
       }?>
    </div>
</div>