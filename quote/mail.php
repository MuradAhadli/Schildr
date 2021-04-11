
<?php
ini_set('display_errors', 0);
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
//$mail->IsSMTP();

$mail->CharSet  ="utf-8";
$mail->SMTPDebug  = 2;
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "schildr.marketing@gmail.com";
$mail->Password   = "Sch159753123";

//$mail->IsHTML(true);
$mail->AddAddress("info@schildr.global","sender");
$mail->SetFrom("info@schildr.global", "Schildr New Jersey");
$mail->AddReplyTo("info@schildr.global", "reply-to-name");
//$mail->AddCC("cc-recipient-email", "cc-recipient-name");
$mail->Subject = "Get Quote";
$first = $_POST['first'];
$last = $_POST['last'];
$photo1 = $_POST['photo1'];
$photo2 = $_POST['photo2'];
$photo3 = $_POST['photo3'];
$photo4 = $_POST['photo4'];
$photo5 = $_POST['photo5'];
$photo6 = $_POST['photo6'];
$photo7 = $_POST['photo7'];
$photo8 = $_POST['photo8'];
$model1 = $_POST['model1'];
$model2 = $_POST['model2'];
$model3 = $_POST['model3'];
$model4 = $_POST['model4'];
$model5 = $_POST['model5'];
$model6 = $_POST['model6'];
$width = $_POST['width'];
$height = $_POST['height'];
$message = $_POST['message'];
$email = $_POST['email'];
$number = $_POST['number'];
$zip = $_POST['zip'];
$content = "

 
 <html>
            <body>
                <table style='width:600px;'>
                    <tbody>
                        <tr>
                            <td style='width:150px'><strong>Name: </strong></td>
                            <td style='width:400px'>$first</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Last: </strong></td>
                            <td style='width:400px'>$last</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product1: </strong></td>
                            <td style='width:400px'>$photo1</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product2: </strong></td>
                            <td style='width:400px'>$photo2</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product3: </strong></td>
                            <td style='width:400px'>$photo3</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product4: </strong></td>
                            <td style='width:400px'>$photo4</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product5: </strong></td>
                            <td style='width:400px'>$photo5</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product6: </strong></td>
                            <td style='width:400px'>$photo6</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product7:: </strong></td>
                            <td style='width:400px'>$photo7</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Product8: </strong></td>
                            <td style='width:400px'>$photo8</td>
                        </tr>
                        
                        
                        
                        <tr>
                            <td style='width:150px'><strong>Model1: </strong></td>
                            <td style='width:400px'>$model1</td>
                        </tr>
                        
                        <tr>
                            <td style='width:150px'><strong>Model2: </strong></td>
                            <td style='width:400px'>$model2</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Model3: </strong></td>
                            <td style='width:400px'>$model3</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Model4: </strong></td>
                            <td style='width:400px'>$model4</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Model5: </strong></td>
                            <td style='width:400px'>$model5</td>
                        </tr>
                        <tr>
                            <td style='width:150px'><strong>Model6: </strong></td>
                            <td style='width:400px'>$model6</td>
                        </tr>
                        
                        
                          <tr>
                            <td style='width:150px'><strong>Width: </strong></td>
                            <td style='width:400px'>$width</td>
                        </tr>
                        
                          <tr>
                            <td style='width:150px'><strong>Height: </strong></td>
                            <td style='width:400px'>$height</td>
                        </tr>
                        
                          <tr>
                            <td style='width:150px'><strong>Message: </strong></td>
                            <td style='width:400px'>$message</td>
                        </tr>
                        
                          <tr>
                            <td style='width:150px'><strong>email: </strong></td>
                            <td style='width:400px'>$email</td>
                        </tr>
                        
                          <tr>
                            <td style='width:150px'><strong>Number: </strong></td>
                            <td style='width:400px'>$number</td>
                        </tr>
                          <tr>
                            <td style='width:150px'><strong>zip: </strong></td>
                            <td style='width:400px'>$zip</td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            </body>
        </html>
 
 
 ";

$mail->MsgHTML($content);


//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo "<SCRIPT type='text/javascript'>
            window.location='success.php?updated=true&updatedmsg=" . urlencode('Message has been sent.') . "';
        </script>";
}
?>