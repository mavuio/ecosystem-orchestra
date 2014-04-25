<?php namespace Werkzeugh\EcosystemOrchestra;

class EcoAsset
{

    // this class maps Orchestra\Asset:: to EcoAsset::
    // it also adds some functionality to the add-function

    function env()
    {
        static $env;
        if (!$env) {
            $env=new \Orchestra\Asset\Environment(\App::make('orchestra.asset.dispatcher'));
        }
        return $env;
    }


    public function add($key,$url=NULL,$dependencies=NULL)
    {
        if(!$url)
            $url=$this->getAssetUrlForKey($key);

        $this->env()->add($key,$url,$dependencies);
    }

    public function styles()
    {
        $ret=$this->env()->styles();
        $ret=preg_replace('#^.*removed\.css.*$#mi','',$ret);
        return $ret;
    }

    public function scripts()
    {
        $ret=$this->env()->scripts();
        $ret=preg_replace('#^.*removed\.js.*$#mi','',$ret);
        return $ret;
    }


    public function getAssetUrlForKey($key)
    {
        $map=array(
            'jquery'=>'/bower_components/jquery/dist/jquery.min.js',
            'angular'=>'/bower_components/angular/angular.min.js',
            'backend-css'=>'/css/backend/backend.css',
            'frontend-css'=>'/css/frontend/frontend.css',
            'fontawesome4'=>'/bower_components/font-awesome/css/font-awesome.min.css',
            );
        return $map[$key];

    }

    public function __call($method, $parameters)
    {
        // echo "<li>calling $method on env ".implode(',',$parameters);
        return call_user_func_array(array($this->env(), $method), $parameters);
    }

}
