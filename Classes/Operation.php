<?php

class Operation extends TableObject {
    static public $tableName = "public.operation";
    static public $keyFieldsNames = [ 'codeope' ];
    public $hasAutoIncrementedKey = false;
    private $tarif;

    public function setTarif(int $new){
        $this->tarif = $new;
    }

    public function getTarif(): ?int{
        return $this->tarif;
    }

    public function toHtml()
    {
        echo "<tr>
                <td>".$this->libelle."</td>
                <td>".$this->tarif." €</td>
                <td>".$this->duree." h</td>
                </tr>";
    }
}