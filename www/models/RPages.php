<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_pages".
 *
 * @property integer $id
 * @property string $page_name
 * @property string $title
 * @property string $text
 */
class RPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_name', 'title', 'text'], 'required'],
            [['text'], 'string'],
            [['page_name'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_name' => 'Название страницы',
            'title' => 'Заголовок',
            'text' => 'Текст',
        ];
    }
}
