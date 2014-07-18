<?php

class MyActiveRecord extends CActiveRecord {

    public function toString() {
        return json_encode($this->getAttributes());
    }

}
