<?php

    $errors = [];

/*     $anschlussLeistungLIS;
    $anzahlStellplätze;

    $täglicheFahrleistung;
    $täglicherNachladebedarf;

    $täglicherNachladebedarfZeit;
    $anzahlNachladungen; */

    // VALIDATION
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       
        if ($_POST['input_hausanschluss'] == '') {
            
            $errors[] = "Hausanschluss angeben!";

        }

        if ($_POST['input_gebäudelast'] == '') {
            
            $errors[] = "Gebäudelast angeben!";

        }

        if ($_POST['input_ladeleistung'] == '') {
            
            $errors[] = "AC-Ladeleistung angeben!";

        }

        if ($_POST['input_wirkleistungsfaktor'] == '') {
            
            $errors[] = "Wirkleistungsfaktor angeben!";

        }

        if ($_POST['input_gleichzeitigkeitsfaktor'] == '') {
            
            $errors[] = "Gleichzeitigkeitsfaktor angeben!";

        }

        if ($_POST['input_jahresfahrleistung'] == '') {
            
            $errors[] = "Jahresfahrleistung angeben!";

        }

        if ($_POST['input_anzahltage'] == '') {
            
            $errors[] = "Anzahl Tage angeben!";

        }

        if ($_POST['input_verbrauch'] == '') {
            
            $errors[] = "Energieverbrauch angeben!";

        }

        if ($_POST['input_ladeleistungfahrzeug'] == '') {
            
            $errors[] = "Ladeleistung des Fahrzeugs angeben!";

        }

        if ($_POST['input_ladeverlustzeit'] == '') {

            $errors[] = "Ladeverlustzeit angeben!";

        }

        if ($_POST['input_ladezeitraum'] == '') {
            
            $errors[] = "Ladezeitraum angeben!";

        }

        if($_POST['input_fahrzeugwechselzeit'] == '') {
            $errors[] = "Zeit zum Fahrzeugwechsel angeben!";
        } 

    }


    // HIER WEITER MACHEN
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {
        
        $anschlussLeistungLIS = $_POST['input_hausanschluss'] - $_POST['input_gebäudelast'];
        $anzahlStellplätze = $anschlussLeistungLIS *  $_POST['input_wirkleistungsfaktor'] * 1 / ($_POST['input_ladeleistung'] * 1 / ($_POST['input_gleichzeitigkeitsfaktor']));

        $täglicheFahrleistung = $_POST['input_jahresfahrleistung'] / $_POST['input_anzahltage'];
        $täglicherNachladebedarf = $täglicheFahrleistung * $_POST['input_verbrauch'] / 100;
    
        $täglicherNachladebedarfZeit = ($täglicherNachladebedarf / $_POST['input_ladeleistungfahrzeug']) + $_POST['input_ladeverlustzeit'];
        $anzahlNachladungen = $_POST['input_ladezeitraum'] / ($täglicherNachladebedarfZeit + $_POST['input_fahrzeugwechselzeit']);

    }
    

?>

<h1>SWG LIS Beratungstool</h1>

<?php 

    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>". $error ."</li>";
    }
    echo "</ul>";


?>


<form action="" method="post">
    
    <h2>Gebäude & Ladeinfrastruktur</h2>

    <div>
        <span>Bei einer verfügbaren Hausanschluss mit </span>
        <input type="number" name="input_hausanschluss" value="<?= $_POST['input_hausanschluss'];?>"> kW und einer Gebäudelast von 
        <input type="number" name="input_gebäudelast" value="<?= $_POST['input_gebäudelast'];?>"> kW verbleiben <?php echo isset($anschlussLeistungLIS) ? $anschlussLeistungLIS :  '___';  ?> kW Anschlussleistung für Ladeinfrastruktur.
    </div>

    <div>
        <span>Unter Annahme eines Wirkleistungsfaktors von </span>
        <input type="number" step="0.01" name="input_wirkleistungsfaktor" value="<?= $_POST['input_wirkleistungsfaktor'];?>"> und einem Gleichzeitigkeitsfaktor von 
        <input type="number" step="0.01" name="input_gleichzeitigkeitsfaktor" value="<?= $_POST['input_gleichzeitigkeitsfaktor'];?>">, können bei einer verfügbaren AC-Ladeleistung von 
        <input type="number" step="0.01" name="input_ladeleistung" value="<?= $_POST['input_ladeleistung'];?>"> kW,
        <?php echo isset($anzahlStellplätze) ? round($anzahlStellplätze, 2, PHP_ROUND_HALF_DOWN) :  '___';  ?> Stellplätze versorgt werden.
    </div>

    <h2>Fahrzeug & Fahrverhalten</h2>
    
    <div>
        <span>Bei einer jährlichen Fahrleistung von </span>
        <input type="number" name="input_jahresfahrleistung" value="<?= $_POST['input_jahresfahrleistung'];?>"> km, verteilt auf  
        <input type="number" name="input_anzahltage" value="<?= $_POST['input_anzahltage'];?>"> Tage (z.B. Werktage), ergibt sich eine tägliche Fahrleistung von 
        <?php echo isset($täglicheFahrleistung) ? round($täglicheFahrleistung, 2, PHP_ROUND_HALF_DOWN) :  '___';  ?> km.
    </div>
    <div>
        <span>Unter Annahme eines Energieverbrauchs von </span>
        <input type="number" name="input_verbrauch" value="<?= $_POST['input_verbrauch'];?>"> kWh / 100 km, ergibt sich daraus ein täglicher Nachladebedarf von 
        <?php echo isset($täglicherNachladebedarf) ? round($täglicherNachladebedarf, 2, PHP_ROUND_HALF_UP) :  '___';  ?>  kWh.
    </div>

    <h2>Ladezeit</h2>
    <div>
        <span>Unter Anbetracht einer fahrzeugseitig, möglichen Ladeleistung von </span>
        <input type="number" step="0.01" name="input_ladeleistungfahrzeug" value="<?= $_POST['input_ladeleistungfahrzeug'];?>"> kW und einer Zusatzzeit für Ladeverluste von
        <input type="number" step="0.01" name="input_ladeverlustzeit" value="<?= $_POST['input_ladeverlustzeit'];?>"> h, erfolgt die Nachladung des täglichen Bedarfs eines Fahrzeugs in 
        <?php echo isset($täglicherNachladebedarfZeit) ? round($täglicherNachladebedarfZeit, 2) :  '___';  ?> h.
    </div>
    <div>
        <span>Innerhalb eines verfügbaren Ladezeitraumes von</span>
        <input type="number" step="0.01" name="input_ladezeitraum" value="<?= $_POST['input_ladezeitraum'];?>"> h, sind bei einer Zeit zum Fahrzeugwechsel 
        <input type="number" step="0.01" name="input_fahrzeugwechselzeit" value="<?= $_POST['input_fahrzeugwechselzeit'];?>"> h,
        demnach <?php echo isset($anzahlNachladungen) ? round($anzahlNachladungen, 2) :  '___';  ?> Nachladungen möglich.
    </div>


    <div>
        <button type="submit">Berechnen</button>
    </div>

</form>