<?php 
    namespace App;
    if (session_status()===PHP_SESSION_NONE){
        session_start();
    }
    use Exception;
use Model\Notifications;
use Model\Offres;
use Model\Postulants;
use Model\User;
    use PDO;
    use PDOException;
    
    class Auth{
        
        public $pdo;
        public static $PAGE_ITEMS=5;
        
        public function __construct(string  $dbname)
        {
            try{
                $this->pdo=new PDO("mysql:host=127.0.0.1;dbname=$dbname",'root','',[
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
                ]);
            }catch(PDOException $e){
                echo "Erreur de connection a la base de donne".$e->getMessage();
                exit(-1);
            }
        }

        public function login(array $post)
        {
            extract($post);
            if (!isset($telephone,$password)) return null;
            $query=$this->pdo->prepare("SELECT * FROM Users WHERE telephone=?");
            $query->execute([$telephone]);
            $user=$query->fetch();
            if ($user!==false){
                if(password_verify($password,$user['password'])){
                    $_SESSION['auth']=$user['id'];
                    return $user;
                }
            }
            $_SESSION['errors']="Vos identifiants sont incorrect";
            return null;
        }
        

        public function Register(array $post)
        {
            if (session_status()===PHP_SESSION_NONE){
                session_start();
            }
            extract($post);
            if(!(empty($telephone) or empty($username) or empty($password) or empty($ville)) ){
                // dd($username,$password,$email);
                if(!preg_match("/^[0-9]{8,}$/",$telephone)){
                    $_SESSION['errors']="Numero de Telephone invalide";
                    return null;
                }

                if(empty($pass=trim($password[0]))||($pass!=trim($password[1]))){
                    $_SESSION['errors']="Les mots de passes de concordent pas";
                    return null;
                }
                $query=$this->pdo->prepare("SELECT * FROM Users WHERE telephone=:telephone");
                $query->execute(["telephone"=>$telephone]);
                $user=$query->fetch();
                // dd($user);
                if ($user!==false){
                    $_SESSION['errors']="Cet numero de telephone est deja enregistre";
                    return null;
                }
                $query=$this->pdo->prepare("INSERT INTO Users(username,telephone,ville,password) VALUES (:username,:tel,:ville,:password)");
                $query->execute(
                    [
                        "username"=>$username,
                        "tel"=>$telephone,
                        "ville"=>$ville,
                        "password"=>password_hash($password[0],PASSWORD_DEFAULT)
                    ]
                );
                $_SESSION['success']='Inscription reussi ';
                return true; 
            }
            $_SESSION['errors']="Tous les champ sont obligatoires";
            return null;
        }

        public function UpdateUser(User $user,array $post)
        {
            extract($post);
            if(!(empty($username)  OR empty($ville) OR empty($telephone)))
            {
                if(!preg_match("/^[0-9]{8,}$/",$telephone)){
                    $_SESSION['errors']="Numero de Telephone invalide";
                    return null;
                }
                if($telephone!==$user->telephone){
                    $query=$this->pdo->prepare("SELECT * FROM Users WHERE telephone=:telephone");
                    $query->execute(["telephone"=>$telephone]);
                    $result=$query->fetch();
                    if ($result!==false){
                        $_SESSION['errors']="Cet numero de telephone est deja utilise par quelqu'un d'autre";
                        return null;
                    }
                }
                $query=$this->pdo->prepare("UPDATE Users SET username=:username,ville=:ville,telephone=:telephone WHERE id=:id");
                $query->execute([
                    "id"=>$user->id,
                    "username"=>$username,
                    "ville"=>$ville,
                    "telephone"=>$telephone
                ]);
                $_SESSION['success']='Votre Profils a ete mis a jour '; 
                return true;           
            }else{
                $_SESSION['errors']="Tous les champ sont obligatoires";
                return null;
            }
        }
        public function getUser():User|null
        {
            if (session_status()===PHP_SESSION_NONE){
                session_start();
            }
            if ( ! isset($_SESSION['auth'])){
                return null;
            }
            $query=$this->pdo->prepare("SELECT * FROM Users WHERE id=:id");
            $query->execute(['id'=>$_SESSION['auth']]);
            $query->setFetchMode(PDO::FETCH_CLASS,User::class);
            $user=$query->fetch();
            // $user=$query->fetchAll(PDO::FETCH_CLASS,User::class);
            return $user?:null;
        }

        public function newOffre(int $id,array $post)
        {
            if((int) $post['nbre']===0){
                $_SESSION['errors']="Nombre de poste invalide";
            }else{
                $query=$this
                    ->pdo
                    ->prepare("INSERT INTO Offres(recruteur,poste,nbre,annonce,salaire,location,create_at,date_fin) VALUES(:recruteur,:poste,:nbre,:annonce,:salaire,:location,:debut,:fin)");
                $query->execute([
                    "recruteur"=>$id,
                    "poste"=>$post['poste'],
                    "nbre"=>$post['nbre'],
                    "annonce"=>$post['annonce'],
                    "salaire"=>$post['salaire']??'',
                    "location"=>$post['location'],
                    "debut"=>$post['create_at'],
                    "fin"=>$post['date']
                ]);
                $_SESSION['success']="Recrutement lancer avec success";
            }
        }
        
        public function updateOffre(int $id,array $post)
        {
            if((int) $post['nbre']===0){
                $_SESSION['errors']="Nombre de poste invalide";
            }else{
                $query=$this
                    ->pdo
                    ->prepare("UPDATE Offres SET poste=:poste,nbre=:nbre,annonce=:annonce,salaire=:salaire,location=:location,create_at=:debut,date_fin=:fin WHERE id=:id");
                $query->execute([
                    "id"=>$id,
                    "poste"=>$post['poste'],
                    "nbre"=>$post['nbre'],
                    "annonce"=>$post['annonce'],
                    "salaire"=>$post['salaire']??'',
                    "location"=>$post['location'],
                    "debut"=>$post['create_at'],
                    "fin"=>$post['date']
                ]);
                $_SESSION['success']="Votre Offre a ete bien mis a jour";
            }
        }
        public function getOffre(int $id):?Offres
        {
            $query=$this->pdo->prepare("SELECT * FROM Offres WHERE id=:id");
            $query->execute(['id'=>$id]);
            $query->setFetchMode(PDO::FETCH_CLASS,Offres::class);
            $user=$query->fetch();
            return $user?:null;
        }

        public function getAllOffre(int $page,int $id=0)
        {
            $totalPage=(int) ceil(($this->pdo->query("SELECT * FROM Offres WHERE recruteur<>$id")->rowCount())/self::$PAGE_ITEMS);
            // dump($totalPage);
            if($totalPage!==0 AND $page>$totalPage) return null;
            $endpoint=(int)(($page-1)*self::$PAGE_ITEMS);
            $sql="SELECT * FROM Offres WHERE recruteur<>".$id." ORDER BY id DESC LIMIT ". self::$PAGE_ITEMS." OFFSET ".$endpoint;
            // dd($sql);
            $query=$this->pdo->query($sql);
            $tab=$query->fetchAll(PDO::FETCH_CLASS,Offres::class);
            // dd($tab);
            return ["Offres"=>$tab,"next"=>($totalPage-$page)>0];

        }

        /**
         * @return Offres[]|null
         */
        public function getMyoffre(int $id)
        {
            $query=$this->pdo->prepare("SELECT * FROM Offres WHERE recruteur=:recruteur");
            $query->execute([
                "recruteur"=>$id
            ]);
            $tab=$query->fetchAll(PDO::FETCH_CLASS,Offres::class);
            if ($tab===false) return null;
            return $tab;
        }

        public function getPostulant(int $job,string $filter=null)
        {
            $sql="SELECT * FROM Postulants INNER JOIN Users ON postulant=id WHERE offre=$job";
            $sql.=$filter?" AND etat='$filter'":'';
            $sql.=" ORDER BY create_at";
            // dd($sql);
            $query=$this->pdo->query($sql);
            return $query->fetchAll(PDO::FETCH_CLASS,Postulants::class)?:[];
        }

        public function Postuler(int $postulant,int $offre)
        {
            $query=$this->pdo->query("SELECT * FROM Postulants WHERE postulant={$postulant} AND offre={$offre}");
            if($query->fetch()!==false) return null;
            $query=$this->pdo->prepare("INSERT INTO Postulants (postulant,offre,create_at) VALUE(:postulant,:offre,:date)");
            $query->execute([
                "postulant"=>$postulant,
                "offre"=>$offre,
                "date"=>date("Y-m-d-H-m-s")
            ]);
            return $postulant;
        }

        public function getNotification(int $id)
        {
            $query=$this->pdo->query("SELECT P.etat,J.poste,J.nbre,J.id FROM Postulants P INNER JOIN Users U ON P.postulant=U.id INNER JOIN Offres J ON P.offre=J.id WHERE U.id=$id AND P.etat<>'En attente de validation'");
            $tab=$query->fetchAll(PDO::FETCH_CLASS,Notifications::class);
            return $tab;

        }
    }
?>
