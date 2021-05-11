<?php
    require "./bibioteca/PHPMailer/Exception.php";
    require "./bibioteca/PHPMailer/OAuth.php";
    require "./bibioteca/PHPMailer/PHPMailer.php";
    require "./bibioteca/PHPMailer/POP3.php";
    require "./bibioteca/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

   class Menssagem{
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = array('cod_status' => null, 'des_status' => '');

        public function __get($name)
        {
            return $this->$name;
        }
        public function __set($name, $value)
        {
            $this->$name = $value;
        }
        public function mensagemInvalida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }else{
                return true;
            }
        }
    }
    
    $men = new Menssagem(true);
    $men->__set('para',$_POST['para']);
    $men->__set('assunto',$_POST['assunto']);
    $men->__set('mensagem',$_POST['men']);

    if(!$men->mensagemInvalida()){
        echo 'Algum campo nao foi prenchido corretamente';
        die();
        header('Location: index.php?');
    }


    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = false;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'Matrixgamer52@gmail.com';                     // SMTP username
    $mail->Password   = 'MATRIX123@';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('Matrixgamer52@gmail.com', 'Web completo remetente');
    $mail->addAddress($men->__get('para'));     // Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $men->__get('assunto');
    $mail->Body    = $men->__get('mensagem');
    $mail->AltBody = 'Colocar o baulho com html';

    $mail->send();
    $men->status['cod_status'] = 1;
    $men->status['des_status']= 'Mensagem enviada com sucesso';;
} catch (Exception $e) {
    $men->status['cod_status'] = 2;
    $men->status['des_status'] = "Não foi possivel mandar a mensagem para o email. Detalhe do erro: {$mail->ErrorInfo}";
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <meta charset="utf-8">
        <title>Mandando o email
    </head>
    <body>
        <div class="container">
            
			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <? if($men->status['cod_status'] == 1){ ?>
                        <div class="container">
                            <h1 class="display-4 text-success">Sucessso</h1>
                            <p><?= $men->status['des_status'] ?></p>
                            <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                        </div>

                    <? } ?>
                    <? if($men->status['cod_status'] == 2){ ?>
                        <div class="container">
                            <h1 class="display-4 text-danger">Ops!</h1>
                            <p><?= $men->status['des_status'] ?></p>
                            <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                        </div>


                    <? } ?>
                </div>
            </div>
        </div>
    </body>

</html>