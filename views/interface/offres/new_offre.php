<?php
    // session_start();

    use App\Auth;
    use App\Functions;
    
    echo Functions::navbar([
        "Home"=>$router->url("home"),
        "Jobs"=>$router->url("home")
    ],
    [
        
    ]);
    
    $auth=new Auth("forum");
    $user = $auth->getUser();
    // dump($user);
    if ($user === null) {
        header("Location:{$router->url('login')}");
        exit();
    }

    
    
    if(!empty($_POST['lancer'])){
        if(Functions::all($_POST['poste'],$_POST['nbre'],$_POST['annonce'],$_POST['create_at'],$_POST['date']))
        {
            $auth->newOffre($user->id,$_POST);
        }else{
            $_SESSION['errors']="Remplir les champs obligatoires";
        }
    }
?>
<?php 
    $error=$_SESSION['errors']??'';
    $success=$_SESSION['success']??'';
    unset($_SESSION['errors'],$_SESSION['success']);
?>
<?php if(!empty($error)) echo Functions::alert("danger mt-2 mx-5",$error)?>
<?php if(!empty($success)) echo Functions::alert("success mt-2 mx-5",$success)?>
<div class="container">
    <h3 class="my-3 display-3">Lancer un nouveau recrutement</h3>
    <?= Functions::Forms()?>
</div>

