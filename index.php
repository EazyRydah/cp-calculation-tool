<?php

    $errors = [];

    $anschlussLeistungLIS;
    $anzahlStellplätze;

    $täglicheFahrleistung;
    $täglicherNachladebedarf;

    $täglicherNachladebedarfZeit;
    $anzahlNachladungen;






    // VALIDATION
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       
        if ($_POST['input_hausanschluss'] == '') {
            
            $errors[] = "Hausanschluss angeben!";

        }

        if ($_POST['input_last'] == '') {
            
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

    }


    // HIER WEITER MACHEN
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {
        
        $anschlussLeistungLIS = $_POST['input_hausanschluss'] - $_POST['input_gebäudelast'];
        $anzahlStellplätze = 1;

        $täglicheFahrleistung;
        $täglicherNachladebedarf;
    
        $täglicherNachladebedarfZeit;
        $anzahlNachladungen;

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
        <input type="number" name="input_last" value="<?= $_POST['input_last'];?>"> kW verbleiben <?=  "____"; ?> kW Anschlussleistung für Ladeinfrastruktur.
    </div>

    <div>
        <span>Unter Annahme eines Wirkleistungsfaktors von </span>
        <input type="number" step="0.01" name="input_wirkleistungsfaktor" value="<?= $_POST['input_wirkleistungsfaktor'];?>"> und einem Gleichzeitigkeitsfaktor von 
        <input type="number" step="0.01" name="input_gleichzeitigkeitsfaktor" value="<?= $_POST['input_gleichzeitigkeitsfaktor'];?>">, können bei einer verfügbaren AC-Ladeleistung von 
        <input type="number" step="0.01" name="input_ladeleistung" value="<?= $_POST['input_ladeleistung'];?>"> kW,
        <?= "____"; ?> Stellplätze versorgt werden.
    </div>

    <h2>Fahrzeug & Fahrverhalten</h2>
    
    <div>
        <span>Bei einer jährlichen Fahrleistung von </span>
        <input type="number" name="input_jahresfahrleistung" value="<?= $_POST['input_jahresfahrleistung'];?>"> km, verteilt auf  
        <input type="number" name="input_anzahltage" value="<?= $_POST['input_anzahltage'];?>"> Tage (z.B. Werktage), ergibt sich eine tägliche Fahrleistung von 
        <?= "____" ?> km.
    </div>
    <div>
        <span>Unter Annahme eines Energieverbrauchs von </span>
        <input type="number" name="input_verbrauch" value="<?= $_POST['input_verbrauch'];?>"> kWh / 100 km, ergibt sich daraus ein täglicher Nachladebedarf von 
        <?= "____" ?> kWh.
    </div>

    <h2>Ladezeit</h2>
    <div>
        <span>Unter Anbetracht einer fahrzeugseitig, möglichen Ladeleistung von </span>
        <input type="number" step="0.01" name="input_ladeleistungfahrzeug" value="<?= $_POST['input_ladeleistungfahrzeug'];?>"> kW und einer Zusatzzeit für Ladeverluste von
        <input type="number" step="0.01" name="input_ladeverlustzeit" value="<?= $_POST['input_ladeverlustzeit'];?>"> h, erfolgt die Nachladung des täglichen Bedarfs eines Fahrzeugs in 
        <?= "____" ?> h.
    </div>
    <div>
        <span>Innerhalb eines verfügbaren Ladezeitraumes von</span>
        <input type="number" step="0.01" name="input_ladezeitraum" value="<?= $_POST['input_ladezeitraum'];?>"> h, sind demnach <?= "____" ?> Nachladungen möglich.
    </div>


    <div>
        <button type="submit">Berechnen</button>
    </div>

</form>