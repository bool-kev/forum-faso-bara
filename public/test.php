<?php

use App\Functions;
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

    require dirname(__DIR__)."/vendor/autoload.php";
    require dirname(__DIR__)."/views/header.php";
    if(!empty($_POST)){
        if($_POST['via']==="infobip"){
            $base_url="l3jmpd.api.infobip.com";
            $api_key="4adcc81de2f1eed8bb58a8bab6a13724-75abbf26-18b0-45ef-9ca4-d32999b1ce02";

            $config=new Configuration(host:$base_url,apiKey:$api_key);

            $api=new SmsApi(config:$config);

            $destination=new SmsDestination(to:$_POST['number']);

            $message=new SmsTextualMessage(
                destinations:[$destination],
                text:$_POST['content'],
                from:"Dark SHADOW"
            );

            $request=new SmsAdvancedTextualRequest(messages:[$message]);

            try{
                $response=$api->sendSmsMessage($request);
                dd($response);
                echo Functions::alert("success mt-5","SMS envoye avec successs");
            }catch(Exception $e)
            {
                dd("Un erreur s'est produite");
            }
       }elseif($_POST['via']==="twilio"){

            $recovery_code="BQXD8LUPJD89JX157BE32BT3";
            $ssid="AC4536c48a24cad6f17a8642c30cd84fce";
            $token="007cdc3114d99b9fbcb3d9041b794921";

            
       }

        
    }

?>


<div class="container mt-5">
    <h1 class="display-2">Envoi de SMS avec infobip</h1>
    <form action="" method="POST">
        <div class="form-group my-2">
            <input type="text" class="form-control mx-2" placeholder="Numero" name="number">
        </div>
        <div class="form-group my-2">
            <input type="text" class="form-control mx-2" placeholder="Contenu de message" name="content">
        </div>
        <input type="submit" class="btn btn-primary">
    </form>
</div>