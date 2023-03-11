<?php

class VehicleDAO extends DAO {
    protected $class='Vehicle';

    public function getVehicleForCustomer(int $id): array
    {
        $res = array();
        $stmt = $this->pdo->prepare('SELECT * FROM public.vehicle where customerid = ? and appartient = true');
        $stmt->execute([$id]);
        $step = 0;
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $res[$step] = new Vehicle($row);
            $step++;
        }
        return $res;
    }

    public function getVehicleFromImmatAppart(string $immat): ?Vehicle{
        $stmt = $this->pdo->prepare('SELECT * FROM public.vehicle where noimmat=? and appartient=true');
        $stmt->execute([$immat]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res){
            return new Vehicle($res);
        }
        return null;
    }

    public function getVehicleFromImmatNonAppart(string $immat): ?Vehicle{
        $stmt = $this->pdo->prepare('SELECT * FROM public.vehicle where noimmat=? and appartient=false');
        $stmt->execute([$immat]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res){
            return new Vehicle($res);
        }
        return null;
    }
}