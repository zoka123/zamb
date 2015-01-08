<?php

namespace Zantolov\Zamb\Menu;

class MenuItem
{
    protected $label;
    protected $url;
    protected $children = array();

    public function __construct($label, $url = null)
    {
        $this->label = $label;
        $this->url = $url;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function addChildren($item)
    {
        $this->children[] = $item;
    }

    public function isLink()
    {
        return !empty($this->url);
    }

    public function hasChildren()
    {
        return (count($this->children) > 0);
    }

    public function isDivider()
    {
        return empty($this->label);
    }

    public function getChildren()
    {
        return $this->children;
    }

}
