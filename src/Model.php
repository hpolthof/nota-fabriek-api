<?php

namespace Hpolthof\NotaFabriekApi;

abstract class Model
{
    public $id;
    public $created_at;
    public $updated_at;

    protected $client;

    // Should be overwritten
    protected $_name = '';

    public function __construct(NotaFabriek $client)
    {
        $this->client = $client;
    }

    /**
     * @return static[]
     * @throws \ReflectionException
     */
    public function all()
    {
        $result = [];
        $items = $this->client->all($this->_name);

        $rc = new \ReflectionClass($this);

        foreach ($items as $item) {
            $result[] = $rc->newInstance($this->client)->fill($item);
        }
        return $result;
    }

    public function save()
    {
        $data = $this->getFields();
        if (isset($this->props)) {
            $data['_props'] = $this->props;
        }

        try {
            if (!$this->id) {
                // Create
                $result = $this->client->store($this->_name, $data);
            } else {
                // Update
                $result = $this->client->update($this->_name, $this->id, $data);
            }

            $this->fill($result);
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function destroy()
    {
        try {
            $this->client->destroy($this->_name, $this->id);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    protected function getFields()
    {
        $result = [];

        $rc = new \ReflectionClass($this);
        $props = $rc->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $result[$prop->getName()] = $prop->getValue($this);
        }

        return $result;
    }

    public function fill($result)
    {
        $fields = array_keys($this->getFields());
        foreach ($fields as $field) {
            if (isset($result->{$field})) {
                $this->{$field} = $result->{$field};
            }

        }

        if (isset($this->props) && isset($result->_props)) {
            $this->resetProperties();
            foreach ($result->_props as $name => $value) {
                $this->setProperty($name, $value);
            }
        }

        return $this;
    }
}