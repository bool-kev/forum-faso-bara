<?php

use App\Auth;

    extract($params);
    $target=$router->url('suivi_offre',['id'=>$job]);
    if(!empty($_POST)){
        $auth=new Auth("forum");
        
        /**
         * @var PDOStatement
         */
        $query=$auth->pdo->prepare("UPDATE Postulants SET etat=:etat WHERE postulant=:postulant AND offre=:job");
        $query2=$auth->pdo->prepare("UPDATE Offres SET etat=:etat WHERE id=$job");
        if(!empty($_POST['accept'])){
            $postulants=count($auth->getPostulant($job,"Accepter"));
            if($postulants>=$auth->getOffre($job)->nbre)
            {
                $_SESSION['errors']="L'effectif est deja au complet";
                $query2->execute([
                    "etat"=>"Satisfait"
                ]);

            }else{
            $query->execute([
                "postulant"=>$postulant,
                "job"=>$job,
                "etat"=>"Accepter"
            ]);
        }
        }elseif(!empty($_POST['drop'])){
            $query->execute([
                "postulant"=>$postulant,
                "job"=>$job,
                "etat"=>"Rejeter"
            ]);
        }elseif(!empty($_POST['annuler'])){
            $query->execute([
                "postulant"=>$postulant,
                "job"=>$job,
                "etat"=>"En attente de validation"
            ]);
            $query2->execute([
                "etat"=>"En cours"
            ]);
        }
    }
    header("Location:$target");
    exit();
?>