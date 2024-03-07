<?php 
    namespace App;
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;

    class Mailer{
        public static function RegisterBody(string $username,string $email,string $token):string
        {
            return <<<HTML
            <p>Bienvenu <strong>$username</strong>,Votre compte a ete cree <br>Afin de confirmer votre enregistrement ,veuillez cliquer 
                <a href="http://localhost/Udemy/espace_membre/verification.php?email=$email&token=$token">Ici</a>
                
            </p>       
    HTML;
        }

        public static function RecuvePassBody(string $username,string $email,string $token):string
        {
            return <<<HTML
            <p>Salut <strong>$username</strong>,Une procedure de renitialisation de votre mot de passe a ete lance <br>Afin de confirmer votre Procedure ,veuillez cliquer 
                <a href="http://localhost/Udemy/espace_membre/new_pass.php?email=$email&token=$token">Renitialiser mon mot de passe</a>
                <br>NB:cet lien s'expire dans 5 minutes
            </p>       
    HTML;
        }
        public static function MailSender(PHPMailer $mail, string $username,string $email,string $object,string $token,string $body):bool
        {
            $mail->addAddress($email);
            $mail->Subject=$object;
            $mail->Body=$body;
            return $mail->send();

        }
        
        public static function initMailSender(string $to,string $alias_to=''):PHPMailer{
            
            $mail=new PHPMailer();
            $mail->isSMTP();
            $mail->Host="smtp.gmail.com";
            $mail->SMTPAuth=true;
            $mail->SMTPAutoTLS=true;
            $mail->Username="abdramanenacanabo1@gmail.com";
            $mail->Password="ozirpywxrzqmalpe";
            $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port=25;
            $mail->isHTML();
            $mail->setFrom($to,$alias_to);
            return $mail;
        }
    }
?>

