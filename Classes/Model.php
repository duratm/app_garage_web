<?php

class Model extends TableObject {
    static public $tableName = "public.Vehicle";
    static public $keyFieldsNames = [ 'noimmat' ];
    public $hasAutoIncrementedKey = false;
}