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
            if(is_bool($value)) {
                $result .= $key;
            } else {
                $result .= $key . '="'.$value.'" ';
            }
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
        $defaults = ['type'=>'text', 'value'=>$model->$attribute, 'class'=>'form-control'];
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
        $defaults = ['class'=>'form-control'];
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
    
    public static function activeFormField($model, $attribute, $options = []) {
        $template = Helper::removeArrayKey($options, 'template', "{beginWrapper}\n{label}\n{input}\n{error}\n{endWrappter}");
        $labelOptions = Helper::removeArrayKey($options, 'labelOptions', []);
        $inputOptions = Helper::removeArrayKey($options, 'inputOptions', []);
        $errorOptions = Helper::removeArrayKey($options, 'errorOptions', []);
        $required = Helper::removeArrayKey($options, 'required', FALSE);
        
        if(!isset($options['class'])) { $options['class'] = 'form-group'; }
        if(is_bool($required) && $required) { $options['class'].=' required'; }
        if($model->hasErrors($attribute)) { $options['class'].=' has-error'; }
        
        $parts = ['{beginWrapper}'=>'<div '.static::generateOptions($options).'>', '{endWrappter}'=>'</div>'];
        $parts['{label}'] = static::activeLabel($model, $attribute, $labelOptions);
        if(isset($inputOptions['type']) && $inputOptions['type'] === 'dropdown') {
            Helper::removeArrayKey($inputOptions, 'type');
            $parts['{input}'] = static::activeDropdown($model, $attribute, $inputOptions);
        } else {
            $parts['{input}'] = static::activeInput($model, $attribute, $inputOptions);
        }
        
        $parts['{error}'] = static::activeError($model, $attribute, $errorOptions, TRUE);
        
        return strtr($template, $parts);
    }
    
    public static function activeCheckbox($model, $attribute, $options = []) {
        $wrapperOptions = Helper::removeArrayKey($options, 'wrapperOptions', []);
        if(!isset($wrapperOptions['class'])) {
            $wrapperOptions['class'] = 'checkbox';
        }
        $label = Helper::removeArrayKey($options, 'label', ucfirst($attribute));
        $labelOptions = Helper::removeArrayKey($options, 'labelOptions', []);
        $inputOptions = Helper::removeArrayKey($options, 'inputOptions', []);
        $name = Helper::removeArrayKey($options, 'name', static::generateName($model, $attribute));
        if($model->$attribute === TRUE || $model->$attribute === '1' || $model->$attribute === 1) {
            $inputOptions['checked'] = TRUE;
        }
        return '<div '.static::generateOptions($wrapperOptions).'><label '.static::generateOptions($labelOptions).'><input type="hidden" name="'.$name.'" value="0"><input type="checkbox" '.static::generateOptions($inputOptions).' name="'.$name.'" value="1"> '.$label.'</label></div>';
    }
}
