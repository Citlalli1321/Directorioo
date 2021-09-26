<?php
    header('Content-Type: application/JSON');
    $metodo = $_SERVER['REQUEST_METHOD'];
    
    try {
        $DBH = new PDO("mysql:host=localhost;dbname=mitienditaa", "root", "");//Estamos en localhost y estamos en test, estamos trabajnado con xamp entonces no vamos a tener una contraseña solo vamos a tener usuario que es root
    } catch (PDOException $e) {
        echo $e->getMessage();//Aca se tiene la Exception si es que ocurre alguna
    }

    switch ($metodo) {
        case 'GET'://Selección
            if($_GET['accion'] == 'persona'){//Entramos al codigo 
                if (isset($_GET['id'])){
                    // Muestra el registro con id
                    $resultado = $DBH->prepare('SELECT * FROM persona WHERE idPersona = :id');
                    $resultado->bindParam(':id', $_GET['id']);
                    $resultado->execute();
                    $response = $resultado->fetchALL(PDO::FETCH_ASSOC);
                    echo json_encode($response, JSON_PRETTY_PRINT);
                } else {
                    // Muestra todos los registros
                    $resultado = $DBH->prepare('SELECT * FROM persona');
                    $resultado->execute();
                    $response = $resultado->fetchALL(PDO::FETCH_ASSOC);
                    echo json_encode($response, JSON_PRETTY_PRINT);
                }
            }
            break;
        case 'POST':
            if($_GET['accion'] == 'persona'){
                if (isset($_GET['id'])){
                    // Realiza la actualización
                    print_r($_POST);
                    $nombre = $_POST['nombre'];
                    $resultado = $DBH->prepare('UPDATE persona SET name = :p WHERE idPersona = :id');
                    $resultado->execute([
                        ':p' => $nombre,
                        ':id' => $_GET['id']
                    ]);
                    echo "Actualizado";
                } else {
                    // Realiza el registro
                    $nombre = $_POST['nombre'];
                    $resultado = $DBH->prepare('INSERT INTO persona(name)VALUES(:p)');
                    $resultado->bindParam(':p', $nombre);
                    $resultado->execute();
                    echo "Registrado";
                }
            }
            break;
        // case 'PUT':
        //     break;
        case 'DELETE':
            if($_GET['accion'] == 'persona'){
                if (isset($_GET['id'])){
                    // Realiza la eliminación
                    $resultado = $DBH->prepare('DELETE FROM persona WHERE idPersona = :id');
                    $resultado->bindParam(':id', $_GET['id']);
                    $resultado->execute();
                    echo "Eliminado";
                }
            }
            break;
        default:
            echo 'Método no soportado';
            break;
    }
?>