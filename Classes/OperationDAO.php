<?php
//require_once __DIR__ . "/Tarif.php";
class OperationDAO extends DAO {
    protected $class='Operation';
    public function getAllOperation(){
        $res = array();
        $stmt = $this->pdo->query('SELECT * FROM public.operation');
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $ope = new Operation($row);
            $res[] = $ope;
            $ope->setTarif($this->getTarifForOpe($ope));
        }
        return $res;
    }

    public function getTarifForOpe(Operation $ope): ?int {
        $stmt = $this->pdo->prepare('SELECT couthoraireactuelht FROM public.operation join public.tarif_mo using(codetarif) where codeope = ?');
        $stmt->execute([$ope->codeope]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res) {
            $tarif = new Tarif($res);
            return $tarif->couthoraireactuelht;
        }
        return null;
    }

    public static function getOpeContains(array $operations, string $libelle): ?array {
        $res = array();
        foreach ($operations as $operation){
            if (str_contains(strtoupper($operation->libelle), strtoupper($libelle))){
                $res[] = $operation;
            }
        }
        return $res;
    }

    public function getOpeBeetween(float $price1, float $price2) : array{
        $stmt = $this->pdo->prepare('SELECT operation.* FROM public.operation join public.tarif_mo using (codetarif) where couthoraireactuelht between coalesce(?,0) and ?');
        if ($price2 == 0){
            $price2 = 100000; //prix maximum
        }
        $stmt->execute([$price1, $price2]);
        $res = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ope){
            $operation = new Operation($ope);
            $res[] = $operation;
            $operation->setTarif($this->getTarifForOpe($operation));
        }
        return $res;
    }
}