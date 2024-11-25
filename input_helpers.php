<?php
/**
 * Denne filen inneholder ulike funksjoner til å sanitere og validere input felt 
 * f.eks ved behandling av former for å registrere ny bruker, gjeste- eller admin-innlogging
 * 
 * Funksjoner i denne filen:
 * - check_honeypot()
 * - clean_input()
 * - validate_fields()
 * - validate_future_date()
 */

//Config-fil med statiske verdier: datoformat, feilmeldinger og valideringsregler
 include('config.php');

/**
 * Sjekker honeyput feltet for spam bot aktivitet
 * Honeyput er et felt som er gjemt for brukeren slik at de ikke kan fylle det ut.
 * Dersom det er utfylt indikerer det spambot submission av form.
 * 
 * @param string|null @honeypot_field: Verdien av honeyput feltet fra form submission
 * @return string|null Returnerer feilmelding dersom feltet er utfylt og null om det er tomt
 */
function check_honeypot($honeypot_field) {
    if (!empty($honeypot_field)) {
        return "Ugyldig innsending.";
    }
    return null;
}

/**
 * Funksjon som forenkler feltbehandling.
 * Den fjerner ekstra whitespace og saniterer input ved hjelp av filtere.
 * 
 * @param string $input: Input som skal saniteres
 * @param int|null $sanitize_filter: PHP filteret som brukes for sanitering (f.eks FILTER_SANITIZE_EMAIL)
 * @return string Sanitert input.
 * 
 * @link https://www.php.net/manual/en/function.filter-var.php - Filter_var
 * @link https://www.php.net/manual/en/filter.filters.sanitize.php - Saniteringsfilter
 */
function clean_input($input, $sanitize_filter = null) {
    $input = trim($input);
    return $sanitize_filter ? filter_var($input, $sanitize_filter) : $input;
}

/**
 * Validerer formfelt basert på de gitte valideringsreglene i $RULES
 * Funksjonen itererer gjennom et assosiativt array hvor hvert felt har en spesifikk valideringsregel.
 * Så sjekker den om felt-verdien matcher kriteriene og legger til en feilmelding i error-array
 * dersom valideringen feiler.
 * 
 * @param array $fields: Et assosiativt array med felter som skal valideres.
 * @param array &$errors: Referer til et assosiativt array hvor validerings feilmeldingene
 * skal lagres. Nøklene korresponderer til felt navnene og values er feilmeldingene
 */
function validate_fields($fields, &$errors) {
    global $RULES, $ERROR_MESSAGES;
    
    foreach ($fields as $field => $rule) {
        $value = $rule['value'];

        //Sjekker om felt er required og at de er tomme
        if ($rule['required'] && empty($value)) {
            $errors[$field] = sprintf($ERROR_MESSAGES['required'], ucfirst($field));
        }
        //Sjekker om det er en valideringsregel for feltet
        elseif (isset($rule['validering'])) {
            //If valideringsregelen er string (f.eks. regex)
            if (is_string($rule['validering']) && !preg_match($rule['validering'], $value)) {
                $errors[$field] = $rule['error_message'] ?: $ERROR_MESSAGES[$field] ?? 'Ugyldig verdi.';
            }
            //Dersom regelen er email filter
            elseif ($rule['validering'] === FILTER_VALIDATE_EMAIL && !filter_var($value, $rule['validering'])) {
                $errors[$field] = $rule['error_message'] ?: $ERROR_MESSAGES['email'];
            }
            //Validering av fødselsdato
            elseif ($field === 'birthdate') {
                $current_date = date(DATE_FORMAT);
                $dateObject = DateTime::createFromFormat(DATE_FORMAT, $value);
                //Sjekker dato format
                if (!$dateObject) {
                    $errors[$field] = $ERROR_MESSAGES['invalid_date_format'];
                }
                //Sjekker om fødselsdato er en fremtidig dato
                elseif ($value > $current_date) {
                    $errors[$field] = $ERROR_MESSAGES['future_date'];
                }
            }
            //Validerer passord
            elseif ($field === 'password' && !preg_match($rule['validering'], $value)) {
                $errors[$field] = $rule['error_message'] ?: $ERROR_MESSAGES['password'];
            }
        }
    }
}


/**
 * Funksjonen validerer at en oppgitt dato ikke er i fortiden.
 * Til bruk av fremtidige bookinger.
 * 
 * Lager et dateTime objekt fra en gitt dato string. Deretter legger til en feilmelding i 
 * &$errors array dersom formatet er ugyldig eller datoen er i fortiden.
 *
 * @param string $date: Datoen som skal valideres.
 * @param string $current_date: Dagens dato til sammenligning.
 * @param array &$errors: Assosiativt array hvor feilmeldinger lagres.
 * @param string $field_name: Navnet på feltet som valideres.
 */
function validate_future_date($date, $current_date, &$errors, $field_name = 'date') {
    if (!empty($date)) {
        $dateObject = DateTime::createFromFormat(DATE_FORMAT, $date);

        if (!$dateObject) {
            $errors[$field_name] = sprintf("Invalid dato. Bruk formatet %s.", DATE_FORMAT);
        }
        elseif ($date < $current_date) {
            $errors[$field_name] = "Invalid dato. Datoen kan ikke være i fortiden.";
        }
    }
}

?>