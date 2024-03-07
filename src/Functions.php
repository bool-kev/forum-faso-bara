<?php
namespace App;

use Model\Offres;

class Functions{
    public static function alert(string $type,string $msg,int $duration=3000):string{
        $id="id".time();
        return <<<HTML
        <div class="alert alert-$type alert-dismissible" id="$id">
            $msg
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(()=>{
                    document.querySelector("#$id").remove()
                },$duration);
        </script>
    HTML;
    }

    public static function alert_redirect(string $type,string $msg,string $location,int $duration=5000):string{
        $id="id".time();
        return <<<HTML
        <div class="alert alert-$type alert-dismissible" id="$id">
            $msg <br>Vous serez rediriger par votre navigateur
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(()=>{
                    document.querySelector("#$id").remove();
                    document.location="$location";
                },$duration);
        </script>
    HTML;
    }

    public static function Token(int $len=20):string
    {
        $ch="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nbre=strlen($ch);
        $token='';
        for($i=0;$i<$nbre;$i++){
            $token.=$ch[rand(0,$nbre-1)];
        }
        return $token;
    }

    public static function navbar(array $left,array $right=null,string $sup='')
    {
        $link_left='';
        $link_right='';
        foreach($left as $link=>$target){
            $link_left.=<<<HTML
                <li class="nav-item">
                    <a class="nav-link btn" href="$target">$link</a>
                </li>
HTML .PHP_EOL;
        }
        foreach($right as $link=>$target){
            if(is_array($target)){
                $link_right.=<<<HTML
                <li class="nav-item ">
                    <form action="$target[0]" method="POST" class="d-flex justify-content-center">
                        <button class="nav-link btn  btn-primary  me-3 {$target[1]}" type="submit" >$link</button>
                    </form>
                </li>
                
HTML .PHP_EOL;
                
            }
            else{
                $link_right.=<<<HTML
                    <li class="nav-item ">
                        <a class="nav-link btn  btn-primary  me-3 " href="$target">$link</a>
                    </li>
HTML .PHP_EOL;
            }
        }
        $link_left.=<<<HTML
                <li class="nav-item">
                    $sup
                </li>
                
HTML .PHP_EOL;
        return <<<HTML
        <nav class="navbar navbar-expand-lg bg-secondary bg-opacity-50">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand me-5 ps-3 logo" href="/">FASO BARA</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    $link_left
                </ul>
                <ul class="navbar-nav ">
                    $link_right
                </ul>
            </div>
    
    </nav>
HTML;
    }
    public static function  all(...$vars):bool
    {
        foreach($vars as $var){
            if(empty($var)) return false;
        }
        return true;
    }

    public static function Forms(string $traitement='',Offres $offre=null,string $target="javascript:history.back()",string $link=null,string $name="lancer")
    {
        if($offre===null) $offre=new Offres();
        $data=["poste"=>'poste',"nbre"=>'nbre',"annonce"=>'annonce',"location"=>'location',"salaire"=>'salaire',"create_at"=>'create_at',"date_fin"=>'date_fin'];
        $tab=array_map(function($elt) use ($offre){
            return $offre->$elt??'';
        },$data);
        extract($tab);
        $create_at=$create_at?:date("Y-m-d");
        return <<<HTML
            <form action="$traitement" method="post" class="my-5 mx-5">
                <div class="form-group my-3 w-lg-50">
                    <label for="poste">Poste <i class="text-danger">*</i></label>
                    <input type="text" class="form-control " name="poste" id="poste" value="$poste">
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="nbre">Nombre de poste<i class="text-danger">*</i></label>
                    <input type="number" class="form-control " name="nbre" id="nbre" min="1" value="$nbre">
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="annonce">Annonce<i class="text-danger">*</i></label>
                    <textarea name="annonce" id="annonce"  rows="2" class="form-control " >$annonce</textarea>
                    <!-- <input type="text" class="form-control " name="annonce" id="annonce"> -->
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="location">Ville/Secteur</label>
                    <input type="text" class="form-control " name="location" id="location" min="1" value="$location">
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="salaire">Salaire</label>
                    <input type="text" class="form-control " name="salaire" id="salaire" value="$salaire">
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="create_at">Date debut de candidature<i class="text-danger">*</i></label>
                    <input type="date" class="form-control " name="create_at" id="create_at" value="$create_at">
                </div>
                <div class="form-group my-3 w-lg-50">
                    <label for="date">Date limite de candidature<i class="text-danger">*</i></label>
                    <input type="date" class="form-control " name="date" id="date" value="$date_fin">
                </div>
                <a class="btn btn-warning" href="$target"><-Retour</a>
                $link
                <input type="submit" class="btn btn-primary"  name="$name" value="$name">
            </form>
HTML;
    }
}
?>