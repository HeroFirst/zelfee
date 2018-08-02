<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 22.11.2016
 * Time: 3:27
 */

namespace Zelfi\Modules\Mail;


use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    /**
     * @param $email
     * @param $firstName
     * @param $password
     * @return bool
     */

    public static function sendAddMemmberToTeam($email){
        $mail = new PHPMailer;

        $mail->setFrom('no-reply@zelfi.ru', 'Зеленый фитнес');
        $mail->addAddress($email);
        $mail->Subject = 'Зеленый фитнес - Приглашение в команду';
        $mail->isHTML(true);
        $mail->Body = '
                <p>Добро пожаловать на официальный сайт социально-спортивного движения "Зеленый Фитнес"!</p>

                <p>Капитан команды участников "ЗФ" приглашает вас пройти регистрацию на сайте <a href="http://'.$_SERVER['HTTP_HOST'].'/register">"Зеленый Фитнес"</a>! </p>

                <p>  После регистрации перейдите в личный кабинет и примите/отклоните приглашение в команду. </p> 
<br/>
                <b> На сайте "ЗФ" реализована программа бонусов и подарков - регистрируйся на сайте , участвуй в мероприятиях ЗФ, зарабатывай баллы и получи велосипед по итогам сезона!</b>
                ';
        $mail->CharSet = 'utf-8';

        return $mail->send();
    }
    
    
    
    public static function sendRegistrationData($email, $firstName, $password){
        $mail = new PHPMailer;

        $mail->setFrom('no-reply@zelfi.ru', 'Зеленый фитнес');
        $mail->addAddress($email);
        $mail->Subject = 'Зеленый фитнес - Регистрация';
        $mail->isHTML(true);
        $mail->Body = '
                <p>'.$firstName.', добро пожаловать на официальный сайт Культурно-спортивного движения <a href="http://'.$_SERVER['HTTP_HOST'].'">"Зеленый Фитнес"</a>!</p>
                <br/>
                <p>Твой логин: '.$email.'. А вот пароль: '.$password.'</p>
                <br/>
                <p>На нашем сайте реализована программа бонусов и подарков - регистрируйся на сайте , участвуй в мероприятиях ЗФ, зарабатывай баллы и получай крутые подарки!</p>
                ';
        $mail->CharSet = 'utf-8';

        return $mail->send();
    }

    public static function sendStoreOrderConfirm($email, $firstName, $orderId, $orderName, $orderCount){
        if (!is_null($email) && 0 !== strlen($email)){
            $mail = new PHPMailer;

            $mail->setFrom('store@zelfi.ru', 'Зеленый фитнес');
            $mail->addAddress($email);
            $mail->Subject = 'Зеленый фитнес - Магазин';
            $mail->isHTML(true);
            $mail->Body = '
                <p>'.$firstName.', благодарим за заказ в магазине проекта <a href="http://'.$_SERVER['HTTP_HOST'].'">"Зеленый Фитнес"</a>!</p>
                <br/>
                <p>Номер заказа: №'.$orderId.'. Товар: '.$orderName.'. Количество: '.$orderCount.'</p>
                <br/>
                <p>В ближайшее время с Вами свяжутся для уточнения заказа.</p>
                ';
            $mail->CharSet = 'utf-8';

            return $mail->send();
        }

        return false;
    }

    public static function sendStoreOrderNewNotification($userId, $userName, $orderId, $orderName, $count, $user_email = null, $user_phone = null){
        $mail = new PHPMailer;

        $mail->setFrom('store@zelfi.ru', 'Зеленый фитнес');
        $mail->addAddress('promo.zf@gmail.com');
        $mail->Subject = 'Зеленый фитнес - Магазин. Новый Заказ';
        $mail->isHTML(true);
        $mail->Body = '
                <p>В магазине новый заказ: </p>
                <br/>
                <p>Номер заказа: №'.$orderId.'</p>
                <p>Название товара: '.$orderName.'</p>
                <p>Количество: '.$count.'</p>
                <p>Пользователь: '.$userName.' (id'.sprintf('%06d',$userId).')</p>
                <p>Email: '.(!is_null($user_email) ? $user_email : '-').'</p>
                <p>Номер телефона: '.(!is_null($user_phone) ? $user_phone : '-').'</p>

                ';
        $mail->CharSet = 'utf-8';

        return $mail->send();
    }
}