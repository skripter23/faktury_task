<?php

  // Připojení tcpdf
  require_once 'tcpdf/tcpdf.php'; 

  // Připojení mysql
  $mysql = new mysqli("localhost", "root", "", "faktury_task");
  $mysql->query("SET NAMES 'utf8'");
  
  // Kontrola připojení
  if($mysql->connect_error) {
    echo 'Error Number: '.$mysql->connect_errno.'<br>';
    echo 'Error: '.$mysql->connect_error;
  }

  // Získání dat z databáze
  $sql = mysqli_query($mysql, 'SELECT * FROM `faktury_task`');
  $result = mysqli_fetch_array($sql);

  /*
  
  Vytvořeni objektu TCPDF, který má parametry: 
  'P' - jako default PDF_ORIENTATION
  'mm' - jako default PDF_UNIT
  'A4' - jako default PDF_PAGE_FORMAT
  'true' - Unicode - true
  'UTF-8' - Encoding charset

  */
  $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
  $pdf->AddPage(); // Přidá stránku do pdf
  $pdf->setFontStretching(105); // Protahování písma
  $pdf->SetFont('freesans', 'B', 12); // touto metodou nastavujeme písmo
  $pdf->Text(8, 15, "Naše Andulka - "); // vypiseme text
  $pdf->SetTextColor(0, 0, 128); // pridavame barvu textu
  $pdf->Text(144, 15, "FAKTURA č. 1981000040");
  $pdf->Line(9,20,197,20); // vytvorime čáry
  $pdf->Line(197,20,197,275.5);
  $pdf->Line(9,20,9,275.5);
  $pdf->Line(9,275.5,197,275.5);
  $pdf->Line(108,20,108,115);
  $pdf->Line(9,115,197,115);
  $pdf->Line(9,125,197,125);
  $pdf->Line(9,148,197,148);
  $pdf->Line(9,160,197,160);
  $pdf->Line(9,235,197,235);
  $style = array('width' => 0.7, 'color' => array(0, 0, 0)); // Proměnná, která dělá linku mastnou
  $pdf->Line(108,34.8,108,92, $style);
  $pdf->Line(9,73,108,73, $style);
  $pdf->Line(9,92,197,92, $style);
  $pdf->Line(108,35,197,35, $style);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFont('freesans', '', 7);
  $pdf->Text(143, 270,"Ekonomický a informační systém POHODA");
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(19, 268, "QR Platba+F");
  $pdf->Image('images/malicka.jpg', 12, 25, 40, 25, '', '', '', false, 50, '', false, false, false, false, false, false); // Přidame obrázek do pdf
  $pdf->SetTextColor(0, 0, 128);
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(10, 22, "Dodavatel:");
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFont('freesans', 'B', 10);
  $pdf->Text(55, 25, "Naše Andulka - ");
  $pdf->SetFont('freesans', '', 9);
  $pdf->SetTextColor(0, 0, 128);
  $pdf->Text(55, 42, "IČ: ");
  $pdf->SetTextColor(0, 0, 0);
  $pdf->Text(61, 42, "{$result['dodavatel']}");
  $pdf->Text(55, 45.5, "Telefon: ");
  $pdf->Text(55.2, 49, "Mobil: ");
  $pdf->Text(55.2, 52.5, "E-mail: ");
  $pdf->Text(110, 22, "Variabilní s.: ");
  $pdf->Text(110, 25.5, "Objednávka č.: ");
  $pdf->Text(110, 29, "Objednávka ze dne: ");
  $pdf->Text(161, 22, "Konstantní s.: ");
  $pdf->SetTextColor(0, 0, 128);
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(110, 37, "Odběratel:");
  $pdf->Text(110, 94, "Konečný příjemce:");
  $pdf->SetFont('freesans', '', 9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->Text(125, 36.9, "IČ: ");
  $pdf->Text(132, 36.9, "{$result['odbiratel']}");
  $pdf->Text(125, 40.4, "DIČ: ");
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(12, 74, "Banka:");
  $pdf->Text(12, 78, "SWIFT:");
  $pdf->Text(12, 82, "IBAN:");
  $pdf->Text(12, 86, "Číslo účtu:");
  $pdf->Text(60, 86, "Kód banky:");
  $pdf->SetFont('freesans', '', 10);
  $pdf->Text(12, 94, "Datum vystavení:");
  $pdf->Text(12, 98.5, "Datum splatnosti:");
  $pdf->Text(12, 103, "Firma není plátcem DPH.");
  $pdf->Text(12, 108.5, "Forma úhrady:  ");
  $pdf->MultiCell(22, 3, '', 1, 'C', 0, 1, '65', '94', true); // Děláme 3 buňky
  $pdf->MultiCell(22, 3, '', 1, 'C', 0, 1, '65', '99', true);
  $pdf->MultiCell(22, 3, '', 1, 'C', 0, 1, '65', '104', true);
  $pdf->SetFont('freesans', '', 9);
  $pdf->Text(12, 117.5, "Označení dodávky:  ");
  $pdf->Text(120, 117.5, "Množství");
  $pdf->Text(160, 117.5, "J.cena");
  $pdf->Text(175, 117.5, "Kč Celkem");
  $pdf->Text(160, 140, "{$result['Castka']},00");
  $pdf->Text(178, 140, "{$result['Castka']},00");
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(12, 148, "Součet položek");
  $pdf->SetFont('freesans', '', 9);
  $pdf->Text(178, 148, "{$result['Castka']},00");
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFont('freesans', 'B', 10);
  $pdf->Text(12, 153, "CELKEM K ÚHRADĚ");
  $pdf->SetFont('freesans', '', 10);
  $pdf->Text(114, 153, "Částky jsou uvedeny v ");
  $pdf->SetFont('freesans', 'B', 10);
  $pdf->Text(152, 153, "Kč");
  $pdf->Text(176, 153, "{$result['Castka']},00");
  $pdf->SetFont('freesans', '', 10);
  $pdf->Text(12, 162, "Vystavil:  ");
  $pdf->SetFont('freesans', '', 7);
  $pdf->Text(12, 226, "Vydané jménem                     firmou:");
  $pdf->Text(12, 229, "Andulka services s.r.o. I Žižkova tř. 309/12, 37001 České Budějovice. I IČO:");
  $pdf->Text(12, 232, "281 36 659");
  $pdf->SetFont('freesans', '', 8);
  $pdf->Text(80, 253, "Převzal:");
  $pdf->Text(130, 253, "Razítko:");
  $pdf->Image('images/qrcode.jpg', 15, 240, 28, 28, '', '', '', false, 50, '', false, false, false, false, false, false); // qr code
  

  $pdf->Output(__DIR__ . '/priklad_soubor.pdf', 'F'); // Uložit jako soubor pdf do adresáře
  $pdf->Output("test.pdf"); // Výstup do prohlížeče
  $mysql->close();
?>