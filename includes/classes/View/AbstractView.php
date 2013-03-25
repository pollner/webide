<?php
abstract class AbstractView
{
    protected $_template = 'default.php';
    protected $_properties = array();

    // constructor
    public function __construct($template = '', array $data = array())
    {
        if ($template !== '') {
            $this->setTemplate($template);
        }
        if (!empty($data)) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
        }
    }
   
    // set a new view template
    public function setTemplate($template)
    {
        $template = $template . '.php';
        if (!file_exists($template)) {
            throw new ViewException('The specified view template does not exist.');  
        }
        $this->_template = $template;
    }
     
    // get the view template
    public function getTemplate()
    {
        return $this->_template;
    }
     
    // set a new property for the view
    public function __set($name, $value)
    {
        $this->_properties[$name] = $value;
    }

    // get the specified property from the view
    public function __get($name)
    {
        if (!isset($this->_properties[$name])) {
            throw new ViewException('The requested property is not valid for this view.');     
        }
        return $this->_properties[$name];
    }

    // remove the specified property from the view
    public function __unset($name)
    {
        if (isset($this->_properties[$name])) {
            unset($this->_properties[$name]);
        }
    }
   
    // add a new view (implemented by view subclasses)
    abstract public function addView(AbstractView $view);
   
    // remove a view (implemented by view subclasses)
    abstract public function removeView(AbstractView $view);
   
    // render the view template
    public function render()
    {
        if ($this->_template !== '') {
           extract($this->_properties);
           ob_start();
           include($this->_template);
           return ob_get_clean();
        }
    }
}// End AbstractView class

class View extends AbstractView {

}
ini_set('display_errors','on');
$V=new View();
echo "DEBUG";
print_r($V);
?>