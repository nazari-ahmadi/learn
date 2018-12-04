<?php namespace Sepehr\Service\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Maps Form Widget
 */
class Maps extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'sepehr_service_maps';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('maps');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/maps.css', 'sepehr.service');
        $this->addJs('js/maps.js', 'sepehr.service');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
