<?php
class AskForInterventionDAO extends DAO {
    protected $class='AskForIntervention';
    public function getOne(mixed $id): ?object {
        return null;
    }

    public function getAll(string $complementRequete = "", array $paramComplement = []): array {
        $res = array();
        $stmt = $this->pdo->query('SELECT * FROM public.askforintervention');
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[] = new AskForIntervention($row);
        }

        return $res;
    }

    public function getAllForDate(String $date1, String $date2): array {
        $res = array();
        $stmt = $this->pdo->prepare('SELECT * FROM askforintervention WHERE date BETWEEN ? AND ? ORDER BY date ASC, hour ASC');
        $stmt->execute(array($date1, $date2));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[] = new AskForIntervention($row);
        }

        return $res;
    }

    public function getAllForCustomer(int $customerid): array {
        $stmt = $this->pdo->prepare('SELECT * FROM public.askforintervention WHERE customerid=?');
        $stmt->execute([$customerid]);
        $res = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[] = new AskForIntervention($row);
        }
        return $res;
    }

    public function save(object $obj): int {
        return 0;
    }

    public function delete(object $obj): int {
        return 0;
    }

}


?>