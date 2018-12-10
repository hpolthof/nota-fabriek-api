<?php

namespace Hpolthof\NotaFabriekApi;

trait HasProperties
{
    protected $props = [];

    public function setProperty($name, $value)
    {
        $this->props[$name] = $value;
        return $this;
    }

    public function getProperty($name, $default = null)
    {
        if (isset($this->props[$name])) {
            return $this->props[$name];
        }
        return $default;
    }

    public function getProperties()
    {
        return $this->props;
    }

    public function resetProperties()
    {
        $this->props = [];
        return $this;
    }
}