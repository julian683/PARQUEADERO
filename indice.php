<?php
// index.php
require_once 'Parqueadero.php';
require_once 'Automovil.php';
require_once 'Motocicleta.php';
require_once 'Cliente.php';

// Crear una instancia del parqueadero
$parqueadero = new Parqueadero();

function mostrarMenu() {
    echo "\nParqueadero El Aguacate - Menú Principal\n";
    echo "1. Ingresar vehículo\n";
    echo "2. Registrar salida de vehículo\n";
    echo "3. Buscar vehículo\n";
    echo "4. Ver ocupación del parqueadero\n";
    echo "5. Salir\n";
    echo "Seleccione una opción: ";
}

function ingresarVehiculo($parqueadero) {
    echo "\nIngreso de Vehículo\n";
    echo "Tipo de vehículo (1: Automóvil, 2: Motocicleta): ";
    $tipo = trim(fgets(STDIN));
    echo "Placa: ";
    $placa = trim(fgets(STDIN));
    echo "Marca: ";
    $marca = trim(fgets(STDIN));
    echo "Color: ";
    $color = trim(fgets(STDIN));
    echo "Nombre del cliente: ";
    $nombre = trim(fgets(STDIN));
    echo "Documento del cliente: ";
    $documento = trim(fgets(STDIN));

    $cliente = new Cliente($nombre, $documento);
    $vehiculo = ($tipo == 1) ? new Automovil($placa, $marca, $color) : new Motocicleta($placa, $marca, $color);

    if ($parqueadero->ingresarVehiculo($vehiculo, $cliente)) {
        echo "Vehículo ingresado con éxito.\n";
    } else {
        echo "No hay espacios disponibles en el parqueadero.\n";
    }
}

function registrarSalida($parqueadero) {
    echo "\nRegistro de Salida\n";
    echo "Placa del vehículo: ";
    $placa = trim(fgets(STDIN));

    $info = $parqueadero->salidaVehiculo($placa);
    if ($info) {
        echo "Salida registrada. Valor a pagar: $" . $info['valorPagar'] . " USD\n";
    } else {
        echo "Vehículo no encontrado.\n";
    }
}

function buscarVehiculo($parqueadero) {
    echo "\nBúsqueda de Vehículo\n";
    echo "Placa del vehículo: ";
    $placa = trim(fgets(STDIN));

    $info = $parqueadero->buscarVehiculo($placa);
    if ($info) {
        echo "Vehículo encontrado:\n";
        foreach ($info as $key => $value) {
            echo "$key: $value\n";
        }
    } else {
        echo "Vehículo no encontrado.\n";
    }
}

function verOcupacion($parqueadero) {
    echo "\nOcupación del Parqueadero\n";
    $ocupacion = $parqueadero->getOcupacion();
    if (empty($ocupacion)) {
        echo "El parqueadero está vacío.\n";
    } else {
        foreach ($ocupacion as $vehiculo) {
            echo "Piso: " . $vehiculo['piso'] . ", Espacio: " . $vehiculo['espacio'] . 
                 ", Placa: " . $vehiculo['placa'] . ", Tipo: " . $vehiculo['tipo'] . "\n";
        }
    }
}

// Menú principal
while (true) {
    mostrarMenu();
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case '1':
            ingresarVehiculo($parqueadero);
            break;
        case '2':
            registrarSalida($parqueadero);
            break;
        case '3':
            buscarVehiculo($parqueadero);
            break;
        case '4':
            verOcupacion($parqueadero);
            break;
        case '5':
            echo "Gracias por usar el sistema. ¡Hasta luego!\n";
            exit;
        default:
            echo "Opción no válida. Por favor, intente de nuevo.\n";
    }
}
?>