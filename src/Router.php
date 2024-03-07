<?php
    namespace App;
    require dirname(__DIR__).DIRECTORY_SEPARATOR."vendor/autoload.php";

use AltoRouter;
use Exception;

    class Router{
        /**
         * @var Altorouter
         */
        private $router;
        private $path;
        public function __construct(string $path)
        {
            $this->path=$path;
            $this->router=new AltoRouter();
        }

        public function get(string $url,string $view,?string $title=null):self
        {
            $this->router->map("GET",$url,$view,$title);
            return $this;
        }
        public function post(string $url,string $view,?string $title=null):self
        {
            $this->router->map("POST",$url,$view,$title);
            return $this;
        }
        public function map(string $url,string $view,?string $title=null):self
        {
            $this->router->map("POST|GET",$url,$view,$title);
            return $this;
        }

        public function url(string $name,array $params=[]):?string
        {
            return $this->router->generate($name,$params);
        }
        public function run():self
        {
            $match=$this->router->match();
            // dd($match);
            if($match===false){
                throw new Exception("NOT FOUND 404");
            }
            $router=$this;
            $view=$match['target'];
            $params=$match['params'];
            // dd($_SERVER);
            require $this->path.DIRECTORY_SEPARATOR."header.php";
            require $this->path.DIRECTORY_SEPARATOR.$view.".php";
            require $this->path.DIRECTORY_SEPARATOR."footer.php";
            return $this;
        }
    }
?>