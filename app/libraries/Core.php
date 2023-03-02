<?php

class Core
{



    protected $currentControllers = 'Pages';
    protected $currentMethod = 'Index';
    protected $param =[] ;

    public function __construct()
    {
        $url = $this->getUrl();

        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this-> currentControllers=ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/'.$this->currentControllers.'.php' ;

        $this->currentControllers = new $this->currentControllers ;

        if(isset($url[1])){
            if(method_exists($this->currentControllers[1], $url[1])){
                $this -> currentMethod =$url[1] ;
                unset($url[1]) ;
            }
        }

        $this->param = $url? array_values($url) : [] ;

        call_user_func_array([$this->currentControllers , $this->currentMethod] , $this->param);
    }

    public function getUrl()
    {

        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
