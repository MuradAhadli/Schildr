<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/2/2018
 * Time: 4:35 PM
 */

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <style type="text/css">

        .btn-subscribe {
            padding: 10px 25px;
            background-color: #A4DA22;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .body {
            background-color:#E8E8E8
        }
        .wrapper {
            max-width:600px;
            border-radius:6px;
            background: none;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .message {
            max-width:600px;
            border-radius:6px;
            background-color:#ffffff;
            line-height:150%;
            font-family:Helvetica;
            font-size:14px;
            color:#333333;
            padding:20px
        }
    </style>
</head>
<body>

<center>
    <table border="0" cellpadding="20" cellspacing="0" height="100%" width="100%" class="body">
        <tbody><tr>
            <td align="center" valign="top">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                    <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="logo">
                                            <img src="<?php
                                            $url = '';
                                            if(@$_SERVER['HTTPS'] && @$_SERVER['HTTPS'] != 'off'){
                                                $url .= 'https://';
                                            }else{
                                                $url .= 'http://';
                                            }

                                            $url .= $_SERVER['SERVER_NAME'];

                                            echo $url;
                                            ?>/app/media/img/logo.jpg" alt="" border="0" width="191" height="84">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="message" >
                                <tbody>
                                <tr>
                                    <td align="left" valign="top">

                                        <div class="password-reset">
                                            <p><?= Html::encode(yii::t('db', 'Hello')) ?> <?= Html::encode($user->firstname. ' '.$user->lastname) ?>,</p>

                                            <p>
                                                <?= Html::encode(yii::t('db', 'Follow the link below to reset your password')) ?>:
                                            </p>

                                            <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
                                        </div>

                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</center>
</body>
</html>