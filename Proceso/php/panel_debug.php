<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// require_once("tu_archivo_de_conexion.php"); // <-- Cambiar por el archivo real de conexión
require_once "../../Conexion/conexioni.php";
$recorrido = $_SESSION['RecorridoAsignado'] ?? '';
$usuario = $_SESSION['NombreUsuario'] ?? 'Repartidor';

file_put_contents('log_debug.txt', "Inicio del script\n", FILE_APPEND);

$query = "
  SELECT HojaDeRuta.id as hdrid, TransClientes.RazonSocial, TransClientes.Retirado
  FROM HojaDeRuta
  INNER JOIN TransClientes ON TransClientes.id = HojaDeRuta.idTransClientes
  WHERE HojaDeRuta.Estado='Abierto' AND HojaDeRuta.Recorrido='$recorrido'
  LIMIT 1
";

file_put_contents('log_debug.txt', "Antes del query\n", FILE_APPEND);

$res = $mysqli->query($query);

if (!$res) {
    file_put_contents('log_debug.txt', "ERROR QUERY: " . $mysqli->error . "\n", FILE_APPEND);
    die("Error en la consulta: " . $mysqli->error);
}

$row = $res->fetch_assoc();

file_put_contents('log_debug.txt', "Después del fetch_assoc\n", FILE_APPEND);

echo '<pre>';
print_r($row);
echo '</pre>';
file_put_contents('log_debug.txt', "Fin del script\n", FILE_APPEND);
