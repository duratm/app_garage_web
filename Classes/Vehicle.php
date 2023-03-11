<?php

class Vehicle extends TableObject {
    static public $tableName = "public.Vehicle";
    static public $keyFieldsNames = [ 'noimmat' ];
    public $hasAutoIncrementedKey = false;

    public function toForm(){
        $modelBDD = new ModelDAO(MaBD::getInstance());
        $brandBDD = new BrandDAO(MaBD::getInstance());
        $model = $modelBDD->getModel($this->nummodel)->libelle;
        $marque = $brandBDD->getBrand($brandBDD->getNumBrandFromModel($this->nummodel))->libelle;
        return "<form method='post'>
                <section class='row'>
                    <article class='col-md'>
                        <section class='form-outline mb-4'>
                            <input readonly='readonly' class='form-control active' type='text' name='immat' value='$this->noimmat'>
                            <label class='form-label' for='immat'>Immatriculation</label>
                        </section>
                    </article>
                    <article class='col-md'>
                        <section class='form-outline mb-4'>
                            <input readonly='readonly' class='form-control active' name='marque' type='text' value='$marque'>
                            <label class='form-label' for='marque'>Marque</label>
                        </section>
                    </article>
                    <article class='col-md'>
                        <section class='form-outline mb-4'>
                            <input readonly='readonly' class='form-control' type='text' value='$model' name='model'>
                            <label class='form-label' for='model'>Model</label>
                        </section>
                    </article>
                    <article class='col-auto'>
                        <section class='mb-4'>
                            <button type='submit' class='btn text-danger' name='supp[]'><svg xmlns='http://www.w3.org/2000/svg' width='1.5em' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                              <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                              <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                            </svg></button>
                        </section>
                    </article>
                </section>
                </form>";
    }

    public function toOption(){
        $modelBDD = new ModelDAO(MaBD::getInstance());
        $brandBDD = new BrandDAO(MaBD::getInstance());
        $model = $modelBDD->getModel($this->nummodel)->libelle;
        $marque = $brandBDD->getBrand($brandBDD->getNumBrandFromModel($this->nummodel))->libelle;
        return "<option value='$this->noimmat'>$this->noimmat $marque $model</option>";
    }
}