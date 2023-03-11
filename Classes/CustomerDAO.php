<?php
// Classe pour l'accès à la table Inscrits
class CustomerDAO extends DAO {
    protected $class = "Customer";

    public function checkAuthentification(string $mail, string $mdp): ?Customer {
        $stmtGetCrypt = $this->pdo->prepare("SELECT * FROM $this->table WHERE mail=?");
        $stmtGetCrypt->execute(array($mail));
        $rowCrypt = $stmtGetCrypt->fetch(PDO::FETCH_ASSOC);
        if ($rowCrypt) {
            $customerBDD = new Customer($rowCrypt);
            $equal = password_verify($mdp, $customerBDD->mdp);
            if ($equal)
                return $customerBDD;
        }
        return null;
    }


    public function getCustomer(string $email): ?Customer
    {
        $stmt = $this->pdo->prepare("SELECT * FROM public.customer where mail=?");
        $stmt->execute([$email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res)
            return new $this->class($res);
        return null;
    }

    public function delete(object $obj): int
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.vehicle where customerid=?');
        $stmt->execute([$obj->customerid]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $vehicleBDD = new VehicleDAO(MaBD::getInstance());
        while ($res != null){
            $vehicleBDD->delete(new Vehicle($res));
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return parent::delete($obj);
    }


}