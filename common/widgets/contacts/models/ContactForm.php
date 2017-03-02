<?php

namespace common\widgets\contacts\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $email;    
    public $time;
    public $text;
    public $header;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['name', 'phone'], 'required'],            
            ['email', 'email'],
            [['name', 'time', 'text', 'header'], 'string'],                        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'header' => 'Заголовок',
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'time' => 'Время звонка',
            'text' => 'Сообщение',     
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function contact($header, $email)
    {
        $style_table = "width: 80%; margin: 25px 0 40px 0; text-align: left;";        
        $body = "<div style='padding: 10px 0 30px 10px'>
                <h2>".str_replace('<br>', ' ', $header)."</h2>                
                <table style='$style_table' border='1' cellpadding='6'>
                <tr><td><b>ФИО</b></td><td>".$this->name."</td></tr>                
                <tr><td><b>Телефон</b></td><td>".$this->phone."</td></tr>";                
        if ($this->email !== NULL) {
            $body .= "<tr><td><b>E-mail</b></td><td>".$this->email."</td></tr>";
        }            
        if ($this->text !== NULL) {
            $body .= "<tr><td><b>Сообщение</b></td><td>".$this->text."</td></tr>";                   
        }            
        $body .= "</table>
                <p>Сообщение c <a href=''></a> (IP: ".Yii::$app->request->getUserIP().")</p>
                </div>";
        
        $messages = [];
            
        foreach ($email as $email) {
            $messages[] = Yii::$app->mailer->compose()
                ->setTo($email)                     
                ->setFrom('info@dovjenko.ru')
                ->setSubject('Сообщение с сайта')
                ->setHtmlBody($body);
        }
        try {
            Yii::$app->mailer->sendMultiple($messages);
            return true;
        }
        catch (\Exception $email) {
            return false;
        }
    }
}
