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
    //public function sendEmail($mails=null)  //...ÌÓËÜÒÈ-ÎÒÏĞÀÂÊÀ...
    {
        if ($this->validate()) {
            //...ÎÄÈÍÎ×ÍÀß ÎÒÏĞÀÂÊÀ...
            /*
            Yii::$app->mailer->compose()
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            */

            //...ÎÄÈÍÎ×ÍÀß ÎÒÏĞÀÂÊÀ ÎÔÎĞÌËÅÍÍÎÃÎ ÏÈÑÜÌÀ...
            //\Yii::$app->mailer->compose('hello')  //...çäåñü óñòàíàâëèâàåòñÿ ğåçóëüòàò ğåíäåğèíãà âèäà â òåëî ñîîáùåíèÿ
            \Yii::$app->mailer->compose('hello', ['imageFileName' => 'img/151_0275.jpg'])
            //$message = 'hello';                 //...layouts Â web(ÅÑËÈ ÃÎÒÎÂÀß ÒĞÀÍÈÖÀ) ÈËÈ ÂÍÈÇÓ(ÅÑËÈ ÏĞÎÑÒÎ ÏÀĞÀÌÅÒĞ)...
            //\Yii::$app->mailer->compose('layouts/html', ['content' => $message])  //...layouts
                ->setTo($this->toEmail)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->subject)
                //->setTextBody($this->body) //...!!!ÒÓÒ ÍÅ ÍÓÆÍÎ...
                ->attach('img/151_0275.jpg')   //... + Ñ ÂËÎÆÅÍÈÅÌ...
                ->send();

            //...ÌÓËÜÒÈ-ÎÒÏĞÀÂÊÀ...
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
