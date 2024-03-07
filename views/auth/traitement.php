<?php

    use App\Auth;
    use App\Functions;
    $auth=new Auth("forum");
    if(isset($_POST['sign_in'])){
        
        echo Functions::alert("info","CONNEXION",10000);
        $test=$auth->login($_POST);
        
        if ($test){
            if (isset($_POST['remember'])){
                setcookie("telephone",$_POST['telephone']);
                setcookie("password",$_POST['password']);
            }
            
            header("location:{$router->url('home')}");
        }else{
            
            header("location:{$router->url('login')}");
        }
        
        
    }elseif(isset($_POST['sign_up'])){
        echo Functions::alert("info","INSCRIPTION",10000);
        $test=$auth->Register($_POST);
        // dd($test);
        header("location:{$router->url('register')}");
    }elseif(isset($_POST['updateUser'])){
        $user=$auth->getUser();
        $auth->UpdateUser($user,$_POST);
        header("location:{$router->url('profil')}");
        exit();
    }else
    {
        throw new Exception("NOT FOUND 404");
    }
?>

