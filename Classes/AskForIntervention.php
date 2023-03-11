<?php
class AskForIntervention extends TableObject {
    static public $tableName = "public.askforintervention";
    static public $keyFieldsNames = [ 'numdde' ];
    public $hasAutoIncrementedKey = true;

    function compa($a, $b)
    {
        if ($a->date == $b->date) {
            return 0;
        }
        return ($a->date < $b->date) ? -1 : 1;
    }

    function checkHour(String $date,bool $connected, String $hour): int {
        $currentDate = date("Y-m-d", time());
        $occupe = $date == $this->date && $hour == $this->hour;
        if ($connected) {
            if ($currentDate >= $date || $occupe) {
                echo "<article class='row'>
                     <button type='submit' value='$date $hour' name='horaire' class='btn btn-outline-secondary btn-rounded mb-1 btn-sm' disabled='disabled'>$hour</button>
                  </article>";
                if ($occupe) {
                    return 1;
                }
                return 0;
            }
            echo "<article class='row'>
                <button type='submit' value='$date $hour' name='horaire' class='btn btn-outline-primary btn-rounded mb-1 btn-sm'>$hour</button>
              </article>";
        }else{
            if ($currentDate >= $date || $occupe) {
                echo "<article class='row'>
                        <button type='submit' value='$date $hour' name='horaire' class='btn btn-outline-secondary btn-rounded mb-1 btn-sm' disabled='disabled'>$hour</button>
                      </article>";
                if ($occupe) {
                    return 1;
                }
                return 0;
            }
            echo "<article class='row'>
                    <a role='button' class='btn btn-outline-primary btn-rounded mb-1 btn-sm' data-mdb-toggle='modal' data-mdb-target='#connectModal'>$hour</a>
                  </article>";
        }

        return 0;
    }

    public function toHtml(){
        return "<div class='accordion-item'>
                <h2 class='accordion-header' id='heading".$this->numdde."'>
                  <button
                    class='accordion-button collapsed' type='button' data-mdb-toggle='collapse' data-mdb-target='#collapse".$this->numdde."' aria-expanded='false' aria-controls='collapse".$this->numdde."'>
                        Demande du ".$this->date." sur le véhicule : ".$this->vehicleimmat." état ".$this->askstate."
                    </button>
                </h2>
                <div id='collapse".$this->numdde."' class='accordion-collapse collapse' aria-labelledby='heading".$this->numdde."' data-mdb-parent='#accordionAsk'>
                  <div class='accordion-body'>
                    Heure : ".$this->hour."<br>
                    Description sommaire : ".$this->askdescription."
                  </div>
                </div>
              </div>";
    }
}
?>