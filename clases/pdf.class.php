<?php 

require('fpdf/fpdf.php');

class PDF extends FPDF{

    // Cabecera de página
    function Header(){

        $title = 'Tickets Pendientes';

        // Logo
        $this->Image('images/img5.png',10,8,20);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(100,10,$title,0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Generado el '.$this->getFecha().' - Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function getFecha(){

        $hora = new DateTime();
        $hora->setTimezone(new DateTimeZone('America/Caracas'));

        $fecha    = date("d-m-Y");
        $fhora     = $hora->format("H:i:s");

        return $fecha.' a las '.$fhora;
    }

}


 ?>