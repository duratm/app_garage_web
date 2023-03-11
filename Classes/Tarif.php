<?php

class Tarif extends TableObject {
    static public $tableName = "public.tarif_mo";
    static public $keyFieldsNames = [ 'codetarif' ];
    public $hasAutoIncrementedKey = true;
}