<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $author
 * @property string $message
 * @property string $date_get
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'companyId', 'statusId', 'message'], 'required'],
            [['message'], 'string'],
            [['comment', 'date_get', 'date_start', 'date_finish', 'status'], 'safe'],
            [['author'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'companyId' => 'Компания',
            'companyLabel' => 'Компания',
            'message' => 'Задача',
            'comment' => 'Комментарий',
            'date_get' => 'Дата получения',
            'date_start' => 'Дата начала',
            'date_finish' => 'Дата завершения',
            'statusId' => 'Статус задачи',
            'statusLabel' => 'Статус задачи'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'statusId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusLabel()
    {
        return $this->status->label;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLabel()
    {
        return $this->company->label;
    }
    
}
