<?php

class Task extends Entity {

    public function setTask($value) {
        $nospace = str_replace(' ', '', $value);
        if (ctype_alpha($nospace) && strlen($value) <= 64) {
            return true;
        }
        
        return false;
    }

    public function setPriority($value) {
        if ($value < 4) {
            return true;
        }
        
        return false;
    }

    public function setSize($value) {
        if ($value < 4) {
            return true;
        }
        
        return false;
    }

    public function setGroup($value) {
        if ($value < 5) {
            return true;
        }
        
        return false;
    }

}
