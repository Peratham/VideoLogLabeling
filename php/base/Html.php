<?php
namespace app;

/**
 * Description of Html
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class Html
{
    public static function generateOptions($options, $default = []) {
        $options = array_merge($default, $options);
        $result = '';
        foreach ($options as $key => $value) {
            $result .= $key . '="'.$value.'" ';
        }
        return $result;
    }
    
    public static function generateName($model, $attribute) {
        return $model->getName() . '['.$attribute.']';
    }
    
    public static function generateId($model, $attribute) {
        $prefix = 'field';
        return  strtolower($model->getName() . '-' . $prefix . '-' . $attribute);
    }
    
    public static function activeInput($model, $attribute, $options) {
        $defaults = ['type'=>'text', 'value'=>$model->$attribute];
        if(!isset($options['name'])) {
            $defaults['name'] = static::generateName($model, $attribute);
        }
        if(!isset($options['id'])) {
            $defaults['id'] = static::generateId($model, $attribute);
        }
        return '<input ' . static::generateOptions($options, $defaults) . '>';
    }
    
    public static function activeLabel($model, $attribute, $options) {
        $defaults = ['class'=>'control-label'];
        if(!isset($options['for'])) {
            $options['for'] = static::generateId($model, $attribute);
        }
        $label = Helper::removeArrayKey($options, 'label', ucfirst($attribute));
        return '<label '.static::generateOptions($options, $defaults).'>'.$label.'</label>';
    }
    
    public static function activeDropdown($model, $attribute, $options) {
        $defaults = [];
        if(!isset($options['name'])) {
            $defaults['name'] = static::generateName($model, $attribute);
        }
        if(!isset($options['id'])) {
            $defaults['id'] = static::generateId($model, $attribute);
        }
        $items = Helper::removeArrayKey($options, 'items', []);
        $prompt = Helper::removeArrayKey($options, 'prompt', []);
        return '<select '.static::generateOptions($options, $defaults).'>'.static::generateSelectOptions($items, $model->$attribute, $prompt).'</select>';
    }
    
    public static function generateSelectOptions($items, $selection = NULL, $prompt = NULL) {
        $lines = [];
        if($prompt !== NULL) {
            $lines[] = '<option value="">'.(!empty($prompt)?$prompt:'Please select ...').'</option>';
        }
        foreach ($items as $key => $item) {
            $lines[] = '<option value="'.$key.'"'.((string)$key===$selection?' selected':'').'>'.$item.'</option>';
        }
        return implode("\n", $lines);
    }
    
    /**
     * 
     * @param Model $model
     * @param string $attribute
     */
    public static function activeError($model, $attribute, $options = [], $firstOnly = FALSE) {
        $default = ['class'=>'text-danger'];
        if($model->hasErrors($attribute)) {
            $message = '';
            if($firstOnly) {
                $message .= $model->getFirstError($attribute);
            } else {
                $message .= '<ul>';
                foreach ($model->getErrors($attribute) as $error) {
                    $message .= '<li>'.$error.'</li>';
                }
                $message .= '</ul>';
            }
            return '<div '.static::generateOptions($options,$default).'>'.$message.'</div>';
        }
        return '';
    }
    
    /**
     * 
     * @param Model $model
     * @param mixed[] $options
     * @return string
     */
    public static function getErrorSummary($model, $options) {
        if($model->hasErrors()) {
            $message = '<div class="alert alert-danger" role="alert">';
            $message .= '<p><strong><u>Please correct the following errors:</u></strong></p>';
            $errors = $model->getErrors();
            foreach ($errors as $attribute => $error) {
                $message .= '<i>'.ucfirst($attribute).'</i>';
                $message .= static::activeError($model, $attribute, ['class'=>'']);
            }
            $message .= '</div>';
            return $message;
        }
        return '';
    }
}
