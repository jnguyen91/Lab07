<?php

/**
 * CSV-persisted collection.
 * 
 * @author      JLP
 * @copyright           Copyright (c) 2010-2017, James L. Parry
 * ------------------------------------------------------------------------
 */
class XML_Model extends Memory_Model
{
//---------------------------------------------------------------------------
//  Housekeeping methods
//---------------------------------------------------------------------------

    protected $xml = null;
    
    /**
    * Constructor.
    * @param string $origin Filename of the XML file
    * @param string $keyfield  Name of the primary key field
    * @param string $entity Entity name meaningful to the persistence
    */
    function __construct($origin = null, $keyfield = 'id', $entity = null)
    {
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
        $this->_fields = array(); // an array of strings
        // and populate the collection
        $this->load();
    }

    /**
    * Load the collection state appropriately, depending on persistence choice.
    * OVER-RIDE THIS METHOD in persistence choice implementations
    */
    protected function load()
    {
        //---------------------
        $this->xml = simplexml_load_file($this->_origin);

        // Have all the field names even if file is empty
        $this->_fields[] = 'id';
        $this->_fields[] = 'task';
        $this->_fields[] = 'priority';
        $this->_fields[] = 'size';
        $this->_fields[] = 'group';
        $this->_fields[] = 'deadline';
        $this->_fields[] = 'status';
        $this->_fields[] = 'flag';

        foreach ($this->xml->tasks->item as $item)
        {   
            $record = new stdClass();
            $record->id = (int) $item->id;
            $record->task = (string) $item->task;
            $record->priority = (int) $item->priority;
            $record->size = (int) $item->size;
            $record->group = (int) $item->group;
            $record->deadline = (string) $item->deadline;
            $record->status = (int) $item->status;
            $record->flag = (int) $item->flag;
            $this->_data[$record->id] = $record;
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
        $this->parseXML();
        // rebuild the keys table
        $this->reindex();
        //---------------------
        if (($handle = fopen($this->_origin, "w")) !== FALSE)
        {
            //save it with appropriate indentations
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($this->xml->asXML());

            fputs($handle, $dom->saveXML());
            fclose($handle);
        }
        // --------------------
    }
        
    protected function parseXML(){
        //save it with appropriate indentations
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $xml = new SimpleXMLElement('<xml></xml>');
        $tasks = $xml->addChild('tasks');

        foreach ($this->_data as $key => $record) {
            $item = $tasks->addChild('item');
            //parse value
            foreach ($this->fields() as $field) {
                $item->addChild($field, $record->$field);
            }
        }
        $this->xml = $xml;
    }
}