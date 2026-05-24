<?php

namespace App\Libraries ;

class UrlLib {

    private $controllerName = null ;
    private $methodName = null ;
    private $className = null ;

    private $title = null;

    public function __construct()
    {
//        $this->session = \Config\Services::session();
    }

    public function setControllerName( $controllerName )
    {
        $this->controllerName = $controllerName ;
    }

    public function setMethodName( $methodName )
    {
        $this->methodName = $methodName ;
    }

    public function setClassName( $className )
    {
        $this->className = $className ;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getControllerName()
    {
        return $this->controllerName ;
    }

    public function getMethodName()
    {
        return $this->methodName ;
    }

    public function getClassName()
    {
        return $this->className ;
    }


    public function getTitle()
    {
        return $this->title;
    }

}