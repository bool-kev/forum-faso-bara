<?php
use App\Auth;
    
    $auth=new Auth("forum");
    $user = $auth->getUser();
    if (empty($_POST)||$user === null || !$offre=(int)$_POST['job']??false) {
        header("Location:{$router->url('login')}");
        exit();
    }
    $test=$auth->Postuler($user->id,$offre);
    if($test===null) $_SESSION['errors']="Vous avez deja postuler a cette annonce";
    else $_SESSION['success']="Votre candidature a ete bien recu";
?>
<script>
    window.history.back();
</script>