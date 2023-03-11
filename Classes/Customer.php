<?php
class Customer extends TableObject {
    static public $tableName = "public.Customer";
    static public $keyFieldsNames = [ 'customerid' ];
    public $hasAutoIncrementedKey = true;

    static function tableHeader(): void {
        echo "<tr><th>Login</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Rôle</th></tr>";
    }

    public function toTableRow(): void {
        echo '<tr><td>', $this->login, '</td><td>', $this->nom,'</td><td>', $this->prénom,'</td><td>',$this->mail,'</td><td>',$this->rôle ,'</td></tr>', "\n";
    }
}
