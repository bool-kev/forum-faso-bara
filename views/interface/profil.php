<?php

use App\Auth;
use App\Functions;
    use Model\User;
    echo Functions::navbar([
        "Home"=>$router->url("home"),
        "Jobs"=>$router->url("home")
    ],
    [
        
    ]);
    $user=(new Auth("forum"))->getUser();
    if($user===null) {header("Location:{$router->url('login')}");exit();}
    $error=$_SESSION['errors']??'';
    $success=$_SESSION['success']??'';
    unset($_SESSION['errors'],$_SESSION['success']);
    
?>
<?php if(!empty($error)) echo Functions::alert("danger mt-2 mx-5",$error)?>
<?php if(!empty($success)) echo Functions::alert("success mt-2 mx-5",$success)?>
<h1 class="display-3 ms-5 mt-5">Vos informations personnelles</h1>
<form action="<?=$router->url('traitement')?>" method="post" class="my-5 mx-5">
    <div class="form-group my-3 mx-md-5">
            <label for="username" class="form-label">Nom et Prenom</label>
            <input type="text" class="form-control " name="username"  id="username" value="<?= $user->username?>">
    </div>
    <div class="form-group my-3 mx-md-5">
            <label for="telephone" class="form-label">Telephone</label>
        <input type="text" class="form-control " name="telephone" id="telephone" value="<?= $user->telephone?>">
    </div>
    <div class="form-group my-3 mx-md-5">
            <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control " name="ville" id="ville" value="<?= $user->ville?>">
    </div>
    <div class="form-group my-3 mx-md-5">
        <input class="btn btn-info" value="Mettre a jour le profils" type="submit" name="updateUser">
    </div>
    
</form>
