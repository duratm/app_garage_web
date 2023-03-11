<?php

class TarifDAO extends DAO {
    protected $class='Tarif';
    public function getAllTarif(): array{
        $res = array();
        $stmt = $this->pdo->query('SELECT * FROM public.tarif_mo');
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[] = new Tarif($row);
        }
        return $res;
    }
}