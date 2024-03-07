<?php
    // session_start();

    use App\Auth;
    use App\Functions;
    echo Functions::navbar([
        "Home"=>$router->url("home")
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
  
    $job=$auth->getOffre($params['id']);
    if($job===null){
        header("Location:{$router->url('home')}");
        exit(); 
    }
    
    if(!empty($_POST['update'])){
        
        if(Functions::all($_POST['poste'],$_POST['nbre'],$_POST['annonce'],$_POST['create_at'],$_POST['date']))
        {   if($user->id!==$job->recruteur)
            {
                $_SESSION['errors']="Vous n'avez pas les permissions pour modifier cette offre";
            }else{
                $auth->updateOffre($job->id,$_POST);
                $job=$auth->getOffre($job->id);
            }
            
        }else{
            $_SESSION['errors']="Remplir les champs obligatoires";
        }
    }elseif(!empty($_POST['drop'])) {
        if($user->id!==$job->recruteur)
        {
            $_SESSION['errors']="Vous n'avez pas les permissions pour supprimer cette offre";
        }else{
            $auth->pdo->exec("DELETE FROM Offres WHERE id=$job->id");
            header("Location:{$router->url('recruteur')}");
            exit();
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
    <h3 class="my-3 display-3">Modifier mon recrutement</h3>
    <?= Functions::Forms("",$job,$router->url('recruteur'),'<input type="submit" class="btn btn-danger"  name="drop" value="Supprimer">','update')?>
</div>