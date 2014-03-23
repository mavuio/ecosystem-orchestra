<?php

namespace Werkzeugh\EcosystemOrchestra;
use View;
use Exception;

class ControllerExtension implements \Werkzeugh\Ecosystem\ControllerExtensionInterface
{

    public $parentController;
    private $layoutTemplateName;
    private $contentTemplateName;
    private $initFunctionCallCount;

    // register parent controller, gets loaded soon after initializing, from the parent controller
    public function registerController($controller)
    {
        $this->parentController=$controller;
    }

    // gets called from each method in the controller to initialize ecosystem for current request
    public function init()
    {
        $this->initFunctionCallCount++;
    }

    public function setLayoutTemplate($bladeTemplateName)
    {
        $this->layoutTemplateName=$bladeTemplateName;
    }

    public function setContentTemplate($bladeTemplateName)
    {
        $this->contentTemplateName=$bladeTemplateName;
    }

    public function getLayoutTemplate()
    {
        return $this->layoutTemplateName;
    }

    public function getContentTemplate()
    {
        return $this->contentTemplateName;
    }

    public function createResponseWithData($data)
    {

        $layoutTemplate=$this->getLayoutTemplate();
        if(!$layoutTemplate)
        {
            throw new Exception("no Layout-Template set, cannot render response");
        }

        $response=View::make($layoutTemplate);

        $contentTemplate=$this->getContentTemplate();
        if($contentTemplate)
        {
                $response->nest('content',$contentTemplate);
        }

        View::share($data);

        return $response;

    }

}
