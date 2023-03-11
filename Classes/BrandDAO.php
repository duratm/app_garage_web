<?php
class BrandDAO extends DAO {
    protected $class='Brand';


    public function getAllBrand() : array{
        $brand = array();
        $stmt = $this->pdo->query('SELECT * FROM public.brand');
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $row){
            $brand[] = new Brand($row);
        }
        return $brand;
    }


    public function getBrand(String $numBrand): ?Brand{
        $stmt = $this->pdo->prepare('SELECT * FROM public.brand where numbrand = ?');
        $stmt->execute([$numBrand]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res)
            return new $this->class($res);
        return null;
    }
    public function getNumBrandFromModel(String $numModel): ?int{
        $stmt = $this->pdo->prepare('SELECT numbrand FROM public.model where nummodel = ?');
        $stmt->execute([$numModel]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res){
            return $res['numbrand'];
        }
        return null;
    }

    public function toSelect(){
        $res = $this->getAllBrand();
        foreach ($res as $brand){
            $num = $brand->numbrand;
            echo "<option value='$num'>".$brand->libelle."</option>";
        }
    }
}
?>