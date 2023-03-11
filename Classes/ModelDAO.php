<?php

class ModelDAO extends DAO {
    protected $class='Model';

    public function getAllModel() : array{
        $mod = array();
        $stmt = $this->pdo->query('SELECT * FROM public.model');
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $row){
            $mod[] = new Model($row);
        }
        return $mod;
    }

    public function getModel(String $numModel): ?Model{
        $stmt = $this->pdo->prepare('SELECT * FROM public.model where nummodel = ?');
        $stmt->execute([$numModel]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res)
            return new $this->class($res);
        return null;
    }

    public function getCodeFromLibelle(string $libelle) : ?int {
        $stmt = $this->pdo->prepare('SELECT nummodel FROM public.model where libelle = ?');
        $stmt->execute([$libelle]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res){
            return $res;
        }
        return null;
    }
}