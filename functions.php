// VALIDATION

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       
        if ($_POST['input_hausanschluss'] == '') {
            
            $errors[] = "Hausanschluss angeben!";

        }

        if ($_POST['input_last'] == '') {
            
            $errors[] = "Gebäudelast angeben!";

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