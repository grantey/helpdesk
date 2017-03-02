<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $date_create
 * @property string $date_update
 * @property string $title
 * @property string $preview
 * @property string $text
 * @property integer $active
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'alias'], 'string', 'max' => 200],
            
            [['date_published', 'preview', 'text', 'alias'], 'safe'],
            [['text'], 'string'],
            [['active'], 'integer'],            
            [['preview'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_create' => 'Дата создания',
            'date_published' => 'Дата публикации',
            'date_update' => 'Дата изменения',
            'title' => 'Заголовок',
            'alias' => 'Url-адрес',
            'preview' => 'Анонс',
            'text' => 'Текст новости',
            'active' => 'Опубликовано',
        ];
    }
    
    public static function findByID ($id)
    {
       return static::findOne(['id' => $id]);
    }
    
    /**
     * behavior for transliterate title to alias
     * 
     * @return type @string
     */

    public function behaviors()
    {
	return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'title',
                'out_attribute' => 'alias',
                'translit' => true
            ]
	];
    }

/*
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            \file_put_contents('test.txt', $this->title);
            
            $this->alias = '234';

            return true;
        }
        return false;
    }*/
}
