<?php

namespace App\Core;

define('controllerPath', 'App\\Controllers\\');

class Core{

    public function __construct()
    {
        $this->run();
    }

    public function run()
    {
        
        if(isset($_GET['params'])) { $url = $_GET['params'];} 
        else { $url = null; }

        $url = $this->getURLInfo($url);

        $this->validateURL($url);

        $url['controller'] = controllerPath.$url['controller'];

        call_user_func(array($url['controller'], $url['method']), $url['params']);
      
    }

    private function getURLInfo($url){

        $params = null;

        if(!empty($url))
        {
            $url =  explode('/', $url);

            
            $controller = $url[0].'Controller';
            array_shift($url);

            if(isset($url[0]) && $url[0] != "" && !empty($url))
            {
                $method = $url[0];
                array_shift($url);
            }
            else
            {
                $method = 'index';
            }

            if(count($url) > 0)
            {
                $params = $url;
            }

        }
        else
        {
            $controller = 'homeController';
            $method = 'index';
        }

        return array('controller'=>$controller,'method'=>$method,'params'=>$params);
    }

    private function validateURL(&$url){

        $path = 'app/Controllers/'.$url['controller'].'.php';

        if(!file_exists($path))
        {
            $url['controller'] = 'erroController'; 
            $url['method'] = 'index';
        }
        elseif(file_exists($path)){
           
            $methods = call_user_func(array(controllerPath.$url['controller'],'getMethods'));

            if(array_search($url['method'], $methods) === false or $url['method'] == "getMethods"){
                $url['controller'] = 'erroController'; 
                $url['method'] = 'index';
            } 
        }

    }
}

?>
