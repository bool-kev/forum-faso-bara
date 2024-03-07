<?php
    // session_start();

use App\Auth;
use App\Functions;
    
    echo Functions::navbar([
        "Home"=>$router->url("Acceuil"),
        "Jobs"=>$router->url("Acceuil")
    ],
    [
        "Se connecter"=>$router->url("login")
    ]);

    $error=$_SESSION['errors']??'';
    $success=$_SESSION['success']??'';
    // unset($_SESSION['errors'],$_SESSION['success']);
    // dump($error);
?>
<?php if(!empty($error)) echo Functions::alert("danger mt-2 mx-5",$error)?>
<?php if(!empty($success)) echo Functions::alert("success mt-2 mx-5",$success)?>
<div class="container">
    <h3 class="my-3 display-3">S'inscrire</h3>
<form action="<?=$router->url('traitement')?>" method="post" class="my-5 mx-5">
    <div class="form-group my-3 w-lg-50">
        <input type="text" class="form-control " name="username" placeholder="Nom et Prenom">
    </div>
    <div class="form-group my-3 w-lg-50">
        <input type="text" class="form-control " name="telephone" placeholder="Numero telephone">
    </div>
    <div class="form-group my-3 w-lg-50">
        <input type="text" class="form-control " name="ville" placeholder="Ville">
    </div>
    <div class="form-group my-3 w-lg-50">
        <input type="password" class="form-control " name="password[]" placeholder="Password">
    </div>
    <div class="form-group my-3 w-lg-50">
        <input type="password" class="form-control " name="password[]" placeholder="Confirmation password">
    </div>
    <input type="submit" class="btn btn-primary" value="sign up" name="sign_up">
</form>
</div>

<?php 
    session_unset();
?>