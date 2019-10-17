<?php

$errors = [];

// VALIDATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['input_date'] == '') {
        
        $errors[] = "Datum der Beratung angeben!";

    }

    if ($_POST['input_location'] == '') {
        
        $errors[] = "Ort der Beratung angeben!";

    }

    if ($_POST['input_objectLabel'] == '') {
        
        $errors[] = "Objekt-Bezeichnung angeben!";

    }

    if ($_POST['input_objectLocation'] == '') {
        
        $errors[] = "Objekt-Standort angeben!";

    }

    
    if ($_POST['input_hausanschluss'] == '') {
        
        $errors[] = "Hausanschluss angeben!";

    }

    if ($_POST['input_gebäudelast'] == '') {
        
        $errors[] = "Gebäudelast angeben!";

    }

    if ($_POST['input_wirkleistungsfaktor'] == '') {
        
        $errors[] = "Wirkleistungsfaktor angeben!";

    }

    
    if ($_POST['input_ladeleistung'] == '') {
        
        $errors[] = "AC-Ladeleistung angeben!";

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

    if ($_POST['input_fahrzeugwechselzeit'] == '') {

        $errors[] = "Zeit zum Fahrzeugwechsel angeben!";

    } 

    if ($_POST['input_nutzungsfaktor'] == '') {

        $errors[] = "Nutzungsfaktor angeben!";

    } 

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {
    
    $anschlussLeistungLIS = $_POST['input_hausanschluss'] - $_POST['input_gebäudelast'];

    $anzahlStellplätze = $anschlussLeistungLIS *  $_POST['input_wirkleistungsfaktor'] * 1 / ($_POST['input_ladeleistung']);

    $täglicheFahrleistung = $_POST['input_jahresfahrleistung'] / $_POST['input_anzahltage'];

    $täglicherNachladebedarf = $täglicheFahrleistung * $_POST['input_verbrauch'] / 100;

    $täglicherNachladebedarfZeit = ($täglicherNachladebedarf / $_POST['input_ladeleistungfahrzeug']) + $_POST['input_ladeverlustzeit'];

    $anzahlNachladungen = $_POST['input_ladezeitraum'] / ($täglicherNachladebedarfZeit + $_POST['input_fahrzeugwechselzeit']);

    $anzahlStellplätzeLastmanagement = $anzahlNachladungen * $anzahlStellplätze * 1 / $_POST['input_nutzungsfaktor'];

    $results = [
        'anschlussleistungLIS' => $anschlussLeistungLIS,
        'anzahlStellplätze' => $anzahlStellplätze,
        'täglicheFahrleistung' => $täglicheFahrleistung,
        'täglicherNachladebedarf' => $täglicherNachladebedarf,
        'täglicherNachladebedarfZeit' => $täglicherNachladebedarfZeit,
        'anzahlNachladungen' => $anzahlNachladungen,
        'anzahlStellplätzeLastmanagement' => $anzahlStellplätzeLastmanagement
    ];

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

    <label for="date">Datum der Beratung</label>
    <input type="date" name="input_date" id="date" value="<?= $_POST['input_date']; ?>">

    <label for="location">Ort der Beratung</label>
    <input type="text" name="input_location" id="location" value="<?php echo isset($_POST['input_location']) ?  $_POST['input_location'] :  '' ; ?>">

    <label for="objectLabel">Objekt-Bezeichnug</label>
    <input type="text" name="input_objectLabel" id="objectLabel" value="<?php echo isset($_POST['input_objectLabel']) ?  $_POST['input_objectLabel'] :  '' ; ?>">

    <label for="objectLocation">Objekt-Standort</label>
    <input type="text" name="input_objectLocation" id="objectLocation" value="<?php echo isset($_POST['input_objectLocation']) ?  $_POST['input_objectLocation'] :  '' ; ?>">

    <hr>

    <h2>Gebäude & Ladeinfrastruktur</h2>

    <div>
        <span>Bei einer verfügbaren Hausanschluss mit </span>
        <input type="number" name="input_hausanschluss" value="<?= $_POST['input_hausanschluss'];?>"> kW und einer Gebäudelast von 
        <input type="number" name="input_gebäudelast" value="<?= $_POST['input_gebäudelast'];?>"> kW verbleiben <?php echo isset($anschlussLeistungLIS) ? "<strong>". $anschlussLeistungLIS . "</strong>" :  '___';  ?> kW Anschlussleistung für Ladeinfrastruktur.
    </div>

    <div>
        <span>Unter Annahme eines Wirkleistungsfaktors von </span>
        <input type="number" step="0.01" name="input_wirkleistungsfaktor" value="<?= $_POST['input_wirkleistungsfaktor'];?>">, können bei einer verfügbaren AC-Ladeleistung von 
        <input type="number" step="0.01" name="input_ladeleistung" value="<?= $_POST['input_ladeleistung'];?>"> kW
        <?php echo isset($anzahlStellplätze) ? "<strong>". round($anzahlStellplätze, 2, PHP_ROUND_HALF_DOWN) . "</strong>" :  '___';  ?> Stellplätze versorgt werden.
    </div>

    <h2>Fahrzeug & Fahrverhalten</h2>
    
    <div>
        <span>Bei einer jährlichen Fahrleistung von </span>
        <input type="number" name="input_jahresfahrleistung" value="<?= $_POST['input_jahresfahrleistung'];?>"> km, verteilt auf  
        <input type="number" name="input_anzahltage" value="<?= $_POST['input_anzahltage'];?>"> Tage (z.B. Werktage), ergibt sich eine tägliche Fahrleistung von 
        <?php echo isset($täglicheFahrleistung) ? "<strong>". round($täglicheFahrleistung, 2, PHP_ROUND_HALF_DOWN) . "</strong>"  :  '___';  ?> km.
    </div>

    <div>
        <span>Unter Annahme eines Energieverbrauchs von </span>
        <input type="number" name="input_verbrauch" value="<?= $_POST['input_verbrauch'];?>"> kWh / 100 km, ergibt sich daraus ein täglicher Nachladebedarf von 
        <?php echo isset($täglicherNachladebedarf) ? "<strong>". round($täglicherNachladebedarf, 2, PHP_ROUND_HALF_UP) . "</strong>" :  '___';  ?>  kWh.
    </div>

    <h2>Ladezeit</h2>

    <div>
        <span>Unter Anbetracht einer fahrzeugseitig, möglichen Ladeleistung von </span>
        <input type="number" step="0.01" name="input_ladeleistungfahrzeug" value="<?= $_POST['input_ladeleistungfahrzeug'];?>"> kW und einer Zusatzzeit für Ladeverluste von
        <input type="number" step="0.01" name="input_ladeverlustzeit" value="<?= $_POST['input_ladeverlustzeit'];?>"> h, erfolgt die Nachladung des täglichen Bedarfs eines Fahrzeugs in 
        <?php echo isset($täglicherNachladebedarfZeit) ? "<strong>". round($täglicherNachladebedarfZeit, 2) . "</strong>" :  '___';  ?> h.
    </div>
    <div>
        <span>Innerhalb eines verfügbaren Ladezeitraumes von</span>
        <input type="number" step="0.01" name="input_ladezeitraum" value="<?= $_POST['input_ladezeitraum'];?>"> h, sind bei einer Zeit zum Fahrzeugwechsel 
        <input type="number" step="0.01" name="input_fahrzeugwechselzeit" value="<?= $_POST['input_fahrzeugwechselzeit'];?>"> h,
        demnach <?php echo isset($anzahlNachladungen) ? "<strong>".  round($anzahlNachladungen, 2) . "</strong>" :  '___';  ?> Nachladungen möglich.
    </div>

    <h2>Ergebnis</h2>

    <div>
    <span>Unter Annahme eines Nutzungsfaktors von
    <input type="number" step="0.01" name="input_nutzungsfaktor" value="<?= $_POST['input_nutzungsfaktor'];?>"> (z.B. privat 0.6, gewerblich 0.9)
    können mit der verfügbaren LIS-Anschlussleistung können unter Einsatz eines dynamischen Lastmanagements 
    <?php echo isset($anzahlStellplätzeLastmanagement) ?  "<strong>". round($anzahlStellplätzeLastmanagement, 2) . "</strong>" :  '___';  ?> Stellplätze parallel versorgt werden.</span>
    </div>

    <div>
        <button type="submit">Berechnen</button>
    </div>

</form>

<!-- PDF Export -->
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)):  ?>

    <form action="exportPDF.php" method="post">
        <div>

        <!-- Standartangaben -->
        <input type="hidden" name="input_date" value="<?= $_POST['input_date'] ;?>">
        <input type="hidden" name="input_location" value="<?= $_POST['input_location'] ;?>">
        <input type="hidden" name="input_objectLabel" value="<?= $_POST['input_objectLabel'] ;?>">
        <input type="hidden" name="input_objectLocation" value="<?= $_POST['input_objectLocation'] ;?>">


        <!-- Gebäude & Ladeinfrastruktur -->
        <input type="hidden" name="input_hausanschluss" value="<?= $_POST['input_hausanschluss'] ;?>">
        <input type="hidden" name="input_gebäudelast" value="<?= $_POST['input_gebäudelast'] ;?>">
        <input type="hidden" name="anschlussLeistungLIS" value="<?= $anschlussLeistungLIS ;?>">

        <input type="hidden" name="input_wirkleistungsfaktor" value="<?= $_POST['input_wirkleistungsfaktor'] ;?>">
        <input type="hidden" name="input_ladeleistung" value="<?= $_POST['input_ladeleistung'];?>">
        <input type="hidden" name="anzahlStellplätze" value="<?= $anzahlStellplätze ;?>">


        <!-- Fahrzeug & Fahrverhalten -->
        <input type="hidden" name="input_jahresfahrleistung" value="<?= $_POST['input_jahresfahrleistung'] ;?>">
        <input type="hidden" name="input_anzahltage" value="<?= $_POST['input_anzahltage'] ;?>">
        <input type="hidden" name="täglicheFahrleistung" value="<?= $täglicheFahrleistung ;?>">

        <input type="hidden" name="input_verbrauch" value="<?= $_POST['input_verbrauch'] ;?>">
        <input type="hidden" name="täglicherNachladebedarf" value="<?= $täglicherNachladebedarf ;?>">
       
        <!-- Ladezeit -->
        <input type="hidden" name="input_ladeleistungfahrzeug" value="<?= $_POST['input_ladeleistungfahrzeug'] ;?>">
        <input type="hidden" name="input_ladeverlustzeit" value="<?= $_POST['input_ladeverlustzeit'];?>">
        <input type="hidden" name="täglicherNachladebedarfZeit" value="<?= $täglicherNachladebedarfZeit ;?>">
        <input type="hidden" name="input_ladezeitraum" value="<?= $_POST['input_ladezeitraum'] ;?>">
        <input type="hidden" name="input_fahrzeugwechselzeit" value="<?= $_POST['input_fahrzeugwechselzeit'] ;?>">
        <input type="hidden" name="anzahlNachladungen" value="<?= $anzahlNachladungen ;?>">
        
        <!-- Ergebnis -->
        <input type="hidden" name="input_nutzungsfaktor" value="<?= $_POST['input_nutzungsfaktor'] ;?>">
        <input type="hidden" name="anzahlStellplätzeLastmanagement" value="<?= $anzahlStellplätzeLastmanagement ;?>">

        <button type="submit">PDF Export</button>

        </div>
    </form>

<?php endif; ?>



