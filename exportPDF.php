<?php

exportPDF();

function exportPDF() {
    
    $pdfAuthor = "Stadtwerke Göttingen AG"; 
    
    $headerLogo1 = '<img src="swg_climate_change.png">';
    $headerLogo2 = '<img src="swg_logo.png">';

    $date = date("d.m.Y");

    $pdfName = "beratungsprotokoll-elektromobilitaet-swg.pdf";
    
     
    //////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    
    // Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
    // tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
    // stark eingeschränkt.
    
    $html = '
    <table cellpadding="2" cellspacing="0" style="width: 100%; ">

        <tr>
        <td>'. nl2br(trim($headerLogo1)) .'</td>
        <td style="text-align:right">'. nl2br(trim($headerLogo2)) .'</td>
        </tr>

    </table>
 
    <br><br><br>
    <h2>Beratung: Ladeinfrastrukturplanung - Elektromobilität</h2>
    <br><br><br>
    

    <table cellpadding="2" cellspacing="0" style="width: 100%; margin-top:100px;">
        <br>
        <tr>
            <td><span style="font-weight: bold">Datum der Beratung: </span> <span>31.08.2019</span></td>
            <td><span style="font-weight: bold">Ort Beratung: </span> <span>Hauptverwaltung Stadtwerke</span></td>
        </tr>
        <br>
        <tr>
            <td><span style="font-weight: bold">Objekt-Bezeichnung: </span> <span>Tiefgarage Eiswiese</span></td>
            <td><span style="font-weight: bold">Objekt-Standort: </span> <span>Windausweg 72, 37081</span></td>
        </tr>

    </table>
    <br>

    <hr>

    <h4>Gebäude & Ladeinfrastruktur</h4>
    <p>Bei einem verfügbaren Haussanschluss mit 100 kW und einer Gebäudelast von 50 kW verbleiben 50 kW Anschlussleistung für Ladeinfrastruktur.
        <br>Unter Annahme eines Wirkleistungsfaktors von 0.85, können bei einer verfügbaren AC-Ladeleistung von 11 kW 50 Stellplätze versorgt werden.</p>
    
    <h4>Fahrzeug & Fahrverhalten</h4>
    <p>Bei einer jährlichen Fahrleistung von 12000 km, verteilt auf 255 Tage (z.B. Werktage), ergibt sich eine tägliche Fahrleistung von 40 km. 
    <br>Unter Annahme eines Energieverbrauchs von 20 kWh/100km ergibt sich daraus ein täglicher Nachladebedarf von 9 kWh.</p>
 
    <h4>Ladezeit</h4>
    <p>Unter Anbetracht einer fahrzeugseitig maximalen Ladeleistung von 7,2 kW und einer Zusatzzeit für Ladeverstlust von 0.5 h, erfolgt die Nachladung des täglichen Bedarfs eines E-PKW in 4 h.
    <br>Innerhalb eines verfügbaren Zeitraumes von 10 h, sind bei einer Zeit zum Fahrzeugwechsel 0,15 h demnach 5 Nachladungen möglich.</p>
  
    <h4>Ergebnis</h4>
    <p>Unter Annahme eines Nutzfaktors von 0.8 (z.B. privat 0,7, gewerblich 0,9) können mit der verfürbaren LIS-Anschlussleistung unter Einsatz eines dynamischen Lastmanagements
    30 Stellplätze parallel versorgt werden.</p>
    <br><br>

    <p><span style="font-weight: bold">Hinweis: </span> Alle Angaben beruhen auf statistisch ermittelten Durchschnittswerten und zur Orientierung.</p>
   
    <span style="font-weight: bold">Mit freundlichen Grüßen</span><br>Ihre Stadtwerke Göttingen

    ';
    
    //////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    // TCPDF Library laden
    require_once('TCPDF/tcpdf.php');
    
    // Erstellung des PDF Dokuments
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Dokumenteninformationen
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($pdfAuthor);
    $pdf->SetTitle('Beratungsprotokoll: Ladeinfrastruktur');
    $pdf->SetSubject('Beratungsprotokoll: Ladeinfrastruktur');
    
    // Header und Footer Informationen
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // Auswahl des Font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // Auswahl der Margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Automatisches Autobreak der Seiten
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // Image Scale 
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // Schriftart
    $pdf->SetFont('dejavusans', '', 10);
    
    // Neue Seite
    $pdf->AddPage();
    
    // Fügt den HTML Code in das PDF Dokument ein
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Ausgabe der PDF
    
    //Variante 1: PDF direkt an den Benutzer senden:
    $pdf->Output($pdfName, 'I');
    
    //Variante 2: PDF im Verzeichnis abspeichern:
    // $pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
    //echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
}


