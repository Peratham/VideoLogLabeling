<?php
namespace app;

/**
 * Description of Validator
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class Validator
{
    public static function required($model, $attribute, $message = NULL) {
        if(empty($model->$attribute)) {
            $model->addError($attribute, $message!==NULL?$message:ucfirst($attribute).' can not be empty.');
            return FALSE;
        }
        return TRUE;
    }
    
    public static function maxLength($model, $attribute, $length, $message = NULL) {
        if(strlen($model->$attribute) > $length) {
            $model->addError($attribute, $message!==NULL?$message:ucfirst($attribute).' should contain at most '.$length.' characters.');
            return FALSE;
        }
        return TRUE;
    }
    
    public static function date($model, $attribute, $format = NULL, $message = NULL) {
        if(($format === NULL && strtotime($model->$attribute) === FALSE) || ($format !== NULL && date_create_from_format($format, $model->$attribute) == FALSE)) {
            $model->addError($attribute, $message!==NULL?$message:'The format of '.ucfirst($attribute).' is invalid.');
            return FALSE;
        }
        return TRUE;
    }
}
