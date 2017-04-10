<?php
namespace app;

/**
 * Description of View
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class View extends Component
{
    /**
     * The location of the registered JavaScript code.
     * The location is in the head part of the html document.
     */
    const POS_HEAD = 0;
    /**
     * The location of the registered JavaScript code.
     * The location is in the beginning of the body part of the html document.
     */
    const POS_BODY = 1;
    /**
     * The location of the registered JavaScript code.
     * The location is in the end of the body part of the html document.
     */
    const POS_END = 2;
    /**
     * The location of the registered JavaScript code.
     * This means the JavaScript code block will be enclosed within `jQuery(document).ready()`.
     */
    const POS_READY = 3;
    /**
     * The location of the registered JavaScript code.
     * This means the JavaScript code block will be enclosed within `jQuery(window).load()`.
     */
    const POS_LOAD = 4;
    /**
     * This is internally used as the placeholder for receiving the content registered for the head section.
     */
    const HEAD = '<![CDATA[BLOCK-HEAD]]>';
    /**
     * This is internally used as the placeholder for receiving the content registered for the beginning of the body section.
     */
    const BODY_BEGIN = '<![CDATA[BLOCK-BODY-BEGIN]]>';
    /**
     * This is internally used as the placeholder for receiving the content registered for the end of the body section.
     */
    const BODY_END = '<![CDATA[BLOCK-BODY-END]]>';
    /**
     * @var string[] array holding the registered JavaScript code.
     */
    protected $js_stack = [];
    /**
     * @var string[] array holding the registered JavaScript files.
     */
    protected $js_files = [];
    /**
     * @var string[] array holding the registered CSS code.
     */
    protected $css_stack = [];
    /**
     * @var string[] array holding the registered CSS files.
     */
    protected $css_files = [];
    
    /**
     * @var string the page title
     */
    public $title = '';

    /**
     * Resolves the view to the corresponding view file.
     * Therefore the view is searched in the current modules view directory. If
     * it wasn't found, the parent modules view directory is searched or an 
     * exception is thrown.
     * 
     * @param string $view the name of the view which should be resolved to an file
     * @return string the corresponding view file
     */
    private function resolveView($view) {
        if(strpos($view, '/') === 0) {
            // TODO: resolve View starting from "root"
            VarDumper::dump($view);
        } else {
            // TODO: go through parent modules, if the view isn't found in the active module!
            $module = Application::$app->activeController->module;
            return $module->basePath . '/' . $module->viewDir .'/'. Application::$app->activeController->getId() .'/'. $view . '.php';
        }
        // TODO: throw an exception if nothing found!
    }
    
    /**
     * Renders the view.
     * 
     * @param string $view the view which should be rendered
     * @param mixed[] $params parameters (name-value-pairs), which are made available to the view
     * @return string the rendering result
     * @throws \Exception if the view cannot be resolved
     */
    public function render($view, $params = []) {
        $file = $this->resolveView($view);
        if (!is_file($file)) {
            throw new \Exception('View ('.$file.') not found!');
        }
        return $this->renderPhpFile($file, $params);
    }

    /**
     * Renders the view file.
     * 
     * @param string $file the view file which should be rendered
     * @param mixed[] $params parameters (name-value-pairs), which are made available to the view
     * @return string the rendering result
     */
    public function renderPhpFile($file, $params = []) {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($file);
        return ob_get_clean();
    }
    
    /**
     * Renders a view in response of an ajax request.
     * Therefore the content is rendered and the registered JavaScript and CSS
     * code/files are applied, but not the layout.
     * 
     * @param string $view the view which should be rendered
     * @param mixed[] $params parameters (name-value-pairs), which are made available to the view
     * @return string the rendering result
     */
    public function renderAjax($view, $params) {
        $viewFile = $this->resolveView($view);

        ob_start();
        ob_implicit_flush(false);

        $this->beginPage();
        $this->head();
        $this->beginBody();
        echo $this->renderPhpFile($viewFile, $params);
        $this->endBody();
        $this->endPage();

        return ob_get_clean();
        
    }
    
    public function registerJs($js, $position = self::POS_HEAD) {
        $this->js_stack[$position][] = $js;
    }

    public function registerJsFile($file, $position = self::POS_HEAD) {
        if(!empty($file)) {
            $this->js_files[$position][] = $file;
        }
    }
    
    public function registerCss($css) {
        $this->css_stack[] = $css;
    }
    
    public function registerCssFile($file) {
        if(!empty($file)) {
            $this->css_files[] = $file;
        }
    }
    
    public function beginPage() {
        ob_start();
        ob_implicit_flush(false);
    }
    
    /**
     * Marks the ending of an HTML page.
     */
    public function endPage() {
        $content = ob_get_clean();

        echo strtr($content, [
            self::HEAD => $this->renderHeadHtml(),
            self::BODY_BEGIN => $this->renderBodyBeginHtml(),
            self::BODY_END => $this->renderBodyEndHtml(),
        ]);

        $this->clear();
    }
    
    /**
     * Marks the position of an HTML head section.
     */
    public function head()
    {
        echo self::HEAD;
    }
    
    /**
     * Marks the beginning of an HTML body section.
     */
    public function beginBody()
    {
        echo self::BODY_BEGIN;
    }

    /**
     * Marks the ending of an HTML body section.
     */
    public function endBody()
    {
        echo self::BODY_END;
    }
    
    public function clear() {
        $this->css_stack = [];
        $this->js_stack = [];
    }
    
    private function wrapCss($css) {
        return '<style type="text/css">'.$css.'</style>';
    }
    
    private function wrapCssFile($file) {
        return '<link rel="stylesheet" href="'.$file.'" />';
    }
    
    private function wrapJs($js) {
        return '<script type="text/javascript">'."\n".$js.'</script>';
    }
    
    private function wrapJsFile($file) {
        return '<script src="'.$file.'" type="text/javascript"></script>';
    }
    
    private function renderHeadHtml() {
        $lines = [];
        if (!empty($this->css_files)) {
            $lines[] = implode("\n", array_map([$this,'wrapCssFile'], $this->css_files));
        }
        if (!empty($this->css_stack)) {
            $lines[] = $this->wrapCss(implode("\n", $this->css_stack));
        }
        if (!empty($this->js_files[self::POS_HEAD])) {
            $lines[] = implode("\n", array_map([$this,'wrapJsFile'], $this->js_files[self::POS_HEAD]));
        }
        if (!empty($this->js_stack[self::POS_HEAD])) {
            $lines[] = $this->wrapJs(implode("\n", $this->js_stack[self::POS_HEAD])); // ['type' => 'text/javascript']
        }
        return empty($lines) ? '' : implode("\n", $lines);
    }
    
    private function renderBodyBeginHtml() {
        $lines = [];
        if (!empty($this->js_files[self::POS_BODY])) {
            $lines[] = implode("\n", array_map([$this,'wrapJsFile'], $this->js_files[self::POS_BODY]));
        }
        if (!empty($this->js_stack[self::POS_BODY])) {
            $lines[] = $this->wrapJs(implode("\n", $this->js_stack[self::POS_BODY]));
        }
        return empty($lines) ? '' : implode("\n", $lines);
    }
    
    private function renderBodyEndHtml() {
        $lines = [];
        if (!empty($this->js_files[self::POS_END])) {
            $lines[] = implode("\n", array_map([$this,'wrapJsFile'], $this->js_files[self::POS_END]));
        }
        if (!empty($this->js_stack[self::POS_END])) {
            $lines[] = $this->wrapJs(implode("\n", $this->js_stack[self::POS_END]));
        }

        if (!empty($this->js_stack[self::POS_READY])) {
            $js = "jQuery(document).ready(function () {\n" . implode("\n", $this->js_stack[self::POS_READY]) . "\n});";
            $lines[] = $this->wrapJs($js);
        }
        if (!empty($this->js_stack[self::POS_LOAD])) {
            $js = "jQuery(window).load(function () {\n" . implode("\n", $this->js_stack[self::POS_LOAD]) . "\n});";
            $lines[] = $this->wrapJs($js);
        }
        return empty($lines) ? '' : implode("\n", $lines);
    }
}