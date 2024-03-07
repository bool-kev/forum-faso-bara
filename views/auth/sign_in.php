<?php

    use App\Functions;
    use App\Auth;
    $user=(new Auth("forum"))->getUser();
    if($user!==null) {header("Location:{$router->url('home')}");exit();}
    echo Functions::navbar([
        "Home"=>$router->url("Acceuil"),
        "Jobs"=>$router->url("Acceuil")
    ],
    [
        "S'inscrire"=>$router->url("register")
    ]);

?>
<div class="container">
    <?php if(isset($_SESSION['errors']))
    {
        echo Functions::alert("danger mt-2",$_SESSION['errors'],5000);
    }
    
    if(isset($_SESSION['success']))
    {
        echo Functions::alert("successs mt-2",$_SESSION['success'],5000);
    }
    unset($_SESSION['errors'],$_SESSION['success']);
    ?>
    <h3 class="my-3 display-3">Se connecter</h3>
<form action="<?=$router->url('traitement')?>" method="post" class="my-5 mx-5">
    <div class="form-group my-3 w-md-75">
        <input type="text" class="form-control " name="telephone" placeholder="Numero de Telephone" value="<?=$_COOKIE['tel']??''?>">
    </div>
    <div class="form-group my-3 w-md-75">
        <input type="password" class="form-control " name="password" placeholder="Password" value="<?=$_COOKIE['password']??''?>">
    </div>
    <div class="form-group my-3 ">
        <input type="checkbox" class="btn btn-light" name="remember" id="check" >
        <label for="check" class="form-label  ">Se souvenir de moi</label>
        <!-- <a class="text-decoration-none mx-4" href="<?php  //$router->url('forgot')?>">Mot de passe oublie</a> -->
    </div>
    <input type="submit" class="btn btn-primary" value="sign in" name="sign_in">
    <button  class="btn btn-secondary" id="reset" onclick="document.forms[0].email.value='';document.forms[0].password.value='';e.preventDefault()" >Reset</button>
</form>
</div>
<script>
    const form=document.forms[0];
    document.querySelector('#reset').addEventListener('click',(e)=>{
        e.preventDefault();
        form.email.value='';
        form.password.value='';
    })
</script>
<?php 
    session_unset();
 ?>