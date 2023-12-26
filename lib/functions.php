<?php
require __DIR__ . '/../vendor/autoload.php';


        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
    function verifica_dados($con){
        if(isset($_POST['env']) && $_POST['env'] == "form"){
            $email = addslashes($_POST['email']);
            $sql = $con->prepare("SELECT email FROM usuarios WHERE email = ?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $get = $sql->get_result();
            $total = $get->num_rows;

            if($total > 0){
                $dados = $get->fetch_assoc();
                add_dados_recover($con, $email);
                echo "tem";
            }
            else{
                echo "não tem";

            }
        }
    }

    function add_dados_recover($con, $email){
        $rash = md5(rand());
        $sql = $con->prepare("INSERT INTO recover_solicitation (email, rash) VALUES (?, ?)");
        $sql->bind_param("ss", $email, $rash);
        $sql->execute();

        if($sql->affected_rows > 0){
            enviar_email($con, $email, $rash);

        }
    }

    function enviar_email($con, $email, $rash){


        $mail = new PHPMailer(true); // 'true' ativa exceções para lidar com erros
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // ou SMTP::DEBUG_OFF para desativar

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kappelanderson@gmail.com';
        $mail->Password = 'aghouyalqsfkvkev';
        $mail->SMTPSecure = 'tls'; // ou 'ssl'
        $mail->Port = 587; // ou 465
        
        $mail->setFrom('kappelanderson@gmail.com', 'Anderson Programador');
        $mail->addAddress($email, 'Usuário');
        $mail->Subject = 'Esqueceu a senha | Navalheiro';
        $mail->IsHTML(true);

        $mail->Body = "<h2>Você solicitou uma nova senha?</h2>
        <hr>
        <p>Olá, Usuário.

        Lamentamos saber que você está tendo problemas para entrar no aplicativo Navalheiro. Recebemos uma mensagem informando que você esqueceu sua senha. Se foi você, pode recuperar o acesso à sua conta ou redefinir a senha agora.</p>
        <h5>Não foi você que tentou alterar os seus dados, então ignore essa mensagem</h5>
        <a href='google.com?rash={$rash}'
        style='        cursor: pointer;'
        ><button  style='color: white;background-color: #4942E4; 
        width: 200px; font-size: 17px; height:40px;
        border: none;
        border-radius: 10px;
        '>Redefina sua senha</button>
        </a>
        ";
        if ($mail->send()) {
            echo 'E-mail enviado com sucesso';
        } else {
            echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
        }
        
    }
?>