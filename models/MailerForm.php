<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

class MailerForm extends Model
{
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $subject;
    public $body;

    public function rules()
    {
        return [
            [['fromEmail', 'fromName', 'toEmail', 'subject', 'body'], 'required'],
            ['fromEmail', 'email'],
            ['toEmail', 'email']
        ];
    }

    public function sendEmail()
    //public function sendEmail($mails=null)  //...������-��������...
    {
        if ($this->validate()) {
            //...��������� ��������...
            /*
            Yii::$app->mailer->compose()
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            */

            //...��������� �������� ������������ ������...
            //\Yii::$app->mailer->compose('hello')  //...����� ��������������� ��������� ���������� ���� � ���� ���������
            \Yii::$app->mailer->compose('hello', ['imageFileName' => 'img/151_0275.jpg'])
            //$message = 'hello';                 //...layouts � web(���� ������� �������) ��� �����(���� ������ ��������)...
            //\Yii::$app->mailer->compose('layouts/html', ['content' => $message])  //...layouts
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                //->setTextBody($this->body) //...!!!��� �� �����...
                ->attach('img/151_0275.jpg')   //... + � ���������...
                ->send();

            //...������-��������...
            /*
            $messages = [];
            foreach ($mails as $user) {
               //print_r($user['email']); die;
               $messages[] = \Yii::$app->mailer->compose()
               ->setFrom([$this->fromEmail => $this->fromName])
               ->setSubject($this->subject)
               ->setTextBody($this->body)
               ->setTo($user['email']);
            }
            \Yii::$app->mailer->sendMultiple($messages);
            */

            return true;
        }
        return false;
    }
}
