<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of XML_Model
 *
 * @author Bill Xue
 */
class XML_Model extends Memory_Model{
    /**
     * Constructor.
     * @param string $origin Filename of the xml file
     * @param string $keyfield  Name of the primary key field
     * @param string $entity	Entity name meaningful to the persistence
     */
    function __construct($origin = null, $keyfield = 'id', $entity = null) {
        parent::__construct();
        // guess at persistent name if not specified
        if ($origin == null)
            $this->_origin = get_class($this);
        else
            $this->_origin = $origin;
        // remember the other constructor fields
        $this->_keyfield = $keyfield;
        $this->_entity = $entity;
        // start with an empty collection
        $this->_data = array(); // an array of objects
        $this->fields = array(); // an array of strings
        // and populate the collection
        $this->load();
    }
    protected function load() {
        //---------------------
        if (file_exists($this->_origin)) {
            $first = true;
            $data = simplexml_load_file($this->_origin);
            foreach ($data->children() as $item) {
                if ($first) {
                    // populate field names from item children
                    foreach ($item->children() as $child) {
                        array_push($this->fields, $child->getName());
                    }
                    $first = false;
                }
                
                // build object from a row
                $record = new stdClass();
                $count = count($this->fields);
                for ($i = 0; $i < $count; $i++) {
                    $record->{$this->fields[$i]} = 
								(string) $item->{$this->fields[$i]};
                }
                $key = $record->{$this->_keyfield};
                $this->_data[$key] = $record;
            }
        }
        // --------------------
        // rebuild the keys table
        $this->reindex();
    }
    /**
     * Store the collection state appropriately, depending on persistence choice.
     * OVER-RIDE THIS METHOD in persistence choice implementations
     */
    protected function store()
    {
        // rebuild the keys table
        $this->reindex();
        //---------------------
		
        if(file_exists($this->_origin))
        {
            $xml = new DOMDocument();

            $xml_data = $xml->createElement(get_class($this));
            foreach($this->_data as $key => $record)
            {
                $task  = $xml->createElement("task");
                $record_array = (array) $record;
                foreach($record as $field => $value)
                {
                    $row = $xml->createElement($field, htmlspecialchars($value));
                    $task->appendChild($row);
                }
                $data->appendChild($task);
            }
            $xml->appendChild($data);
            $xml->save($this->_origin);
        }
        // --------------------
    }
}