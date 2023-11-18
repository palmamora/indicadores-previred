<?php
//import dependencies
require_once(__DIR__ . '/vendor/autoload.php');

use Goutte\Client;

function convertirStringFloat($valor)
{
    // Elimina los caracteres no numéricos y la coma
    $valor = str_replace(array("$", ".", " ", "%"), "", $valor);
    // Reemplaza la coma por un punto para tener un valor decimal válido
    $valor = str_replace(",", ".", $valor);
    // Convierte la cadena a número decimal (float)
    $valor = floatval($valor);
    return $valor;
}

function cortarDecimales($valor){
    $valor = number_format($valor,2,".","");
    return $valor;
}

$periodo = '';
$valoresUF = [];
$valorUTM = '';
$rentasMinimasImponibles = [];
$ahorroPrevisionalVoluntario = [];
$valorSIS = [];

//inicializando cliente
$client = new Client();
$url = 'https://www.previred.com/indicadores-previsionales/';
$crawler = $client->request('GET', $url);

//obteniendo periodo
$tablaPeriodo = $crawler->filter('table:contains("Para Cotizaciones a Pagar")')->eq(0);
$periodo = $tablaPeriodo->filter('tr')->eq(0)->filter('td')->eq(0)->text();
$periodo = str_replace(["(", ")", "."], "", $periodo);
$periodo = explode(' ', $periodo);
$periodo = $periodo[8] . ' ' . $periodo[9];

//obteniendo valores UF
$tablaUF = $crawler->filter('table:contains("VALOR UF")')->eq(0);
$tablaUF->filter('tr')->each(function ($row, $i) use (&$valoresUF) {
    if ($i > 0) {
        $valoresUF[] = $row->filter('td')->eq(1)->text();
    }
});

//obteniendo valor UTM
$tablaUTM = $crawler->filter('table:contains("UTM")')->eq(0);
$valorUTM = $tablaUTM->filter('tr')->eq(1)->filter('td')->eq(1)->text();

//obteniendo rentas mínimas imponibles
$tablaRentasMinimasImponibles = $crawler->filter('table:contains("RENTAS MÍNIMAS IMPONIBLES")')->eq(0);
$tablaRentasMinimasImponibles->filter('tr')->each(function ($row, $i) use (&$rentasMinimasImponibles) {
    if ($i > 0) {
        $rentasMinimasImponibles[] = $row->filter('td')->eq(1)->text();
    }
});

//obteniendo ahorro previsional voluntario
$tablaAPV = $crawler->filter('table:contains("AHORRO PREVISIONAL VOLUNTARIO")')->eq(0);
$tablaAPV->filter('tr')->each(function ($row, $i) use (&$ahorroPrevisionalVoluntario) {
    if ($i > 0) {
        //$ahorroPrevisionalVoluntario[] = $row->filter('td')->eq(0)->text();
        $ahorroPrevisionalVoluntario[] = $row->filter('td')->eq(1)->text();
    }
});

//obteniendo sis
$tablaSIS = $crawler->filter('table:contains("SIS")')->eq(0);
$tablaSIS->filter('tr')->each(function ($row, $i) use (&$valorSIS) {
    if ($i > 3) {
        $valorSIS[$i-3][0] = $row->filter('td')->eq(0)->text();
        $valorSIS[$i-3][1] = $row->filter('td')->eq(1)->text();
        $valorSIS[$i-3][2] = $row->filter('td')->eq(2)->text();
        $valorSIS[$i-3][3] = $row->filter('td')->eq(3)->text();
    }
});

//convirtiendo valores string a int
$valoresUF = array_map('convertirStringFloat', $valoresUF);
$valoresUF = array_map('cortarDecimales', $valoresUF);
$valorUTM = convertirStringFloat($valorUTM);
$rentasMinimasImponibles = array_map('convertirStringFloat', $rentasMinimasImponibles);
$ahorroPrevisionalVoluntario = array_map('convertirStringFloat', $ahorroPrevisionalVoluntario);
//$valorSIS = array_map('convertirStringFloat', $valorSIS);
//$valorSIS = array_map('cortarDecimales', $valorSIS);

// echo 'Valor UF<br>';
// print_r($valoresUF);
// echo '<hr>';
// echo 'Valor UTM<br>';
// print_r($valorUTM);
// echo '<hr>';
// echo 'Rentas Mínimas Imponibles<br>';
// print_r($rentasMinimasImponibles);
// echo '<hr>';
// echo 'Ahorro Previsional Voluntario<br>';
// print_r($ahorroPrevisionalVoluntario);
// echo '<hr>';
// echo 'Valores SIS<br>';
// print_r($valorSIS);

header('Content-Type: application/json');
echo json_encode([
    'periodo' => $periodo,
    'valoresUF' => $valoresUF,
    'valorUTM' => $valorUTM,
    'rentasMinimasImponibles' => $rentasMinimasImponibles,
    'ahorroPrevisionalVoluntario' => $ahorroPrevisionalVoluntario,
    'valorSIS' => $valorSIS
]);

