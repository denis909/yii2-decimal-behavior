<?php

namespace denis909\yii;

use \yii\db\ActiveRecord;

class DecimalBehavior extends \yii\base\Behavior
{

	public $attributes = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate'
        ];
    }

    public function beforeValidate($event)
    {
    	foreach($this->attributes as $attribute)
    	{
    		if ($event->sender->isAttributeSafe($attribute))
    		{
    			$event->sender->{$attribute} = str_replace(',', '.', $event->sender->{$attribute});
    		}
    	}
    }    

    public function afterFind($event)
    {
    	foreach($this->attributes as $attribute)
    	{
    		if (strpos($event->sender->{$attribute}, '.') !== false)
    		{
    			$event->sender->{$attribute} = rtrim($event->sender->{$attribute}, '0');

    			$event->sender->{$attribute} = rtrim($event->sender->{$attribute}, '.');
    		}
    	}
    }

}