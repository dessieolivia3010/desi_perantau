<?php
class PDF {
    protected $buf = '';
    public function __construct(){}
    public function AddPage(){}
    public function SetFont($f,$s='',$size=12){ $this->size = $size; }
    public function Cell($w,$h,$txt='',$b=0,$ln=0,$align=''){ $this->buf .= $txt . "\n"; }
    public function Ln($h=4){ $this->buf .= "\n"; }
    public function Output($dest='I',$name='report.pdf'){
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        echo $this->buf;
    }
}
?>