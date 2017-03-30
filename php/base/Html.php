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
        if(!isset($options['for'])) {
            $options['for'] = static::generateId($model, $attribute);
        }
        $label = Helper::removeArrayKey($options, 'label', ucfirst($attribute));
        return '<label '.static::generateOptions($options).'>'.$label.'</label>';
    }
    
    public static function activeDropdown($model, $attribute, $options) {
        /*
                                <select name="Game[team1][id]" class="form-control" id="game-field-team1-id">
                                    <option value="">Please select ...</option>
                                    <?php foreach (\app\Application::$app->params['teams'] as $key => $team) { echo '<option value="'.$key.'">'.$team.'</option>'; } ?>
                                </select>
         *          */
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
}
