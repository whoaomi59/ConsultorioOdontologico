<?php
// Incluir el archivo de configuración desde la raíz
require_once __DIR__ . '/../config/database.php'; // Ajusta según la ubicación de tu archivo de conexión o config.php

if (!isset($db)) {
    global $db;
}

$email         = 'admin@clinica.com';
$nuevaPassword = '123456';
// Generar un hash fresco y 100% válido con BCRYPT
$hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);

try {
    $stmt      = $db->prepare("UPDATE usuarios SET password = ?, estado = 1 WHERE email = ?");
    $resultado = $stmt->execute([$hash, $email]);

    if ($resultado && $stmt->rowCount() > 0) {
        echo "<h2 style='color:green;'>¡Contraseña actualizada correctamente!</h2>";
        echo "<p>
            <b>Usuario:</b>
            {$email}
            </p>";
            echo "<p>
                <b>Nueva Contraseña:</b>
                {$nuevaPassword}
                </p>";
                echo "<p>
                    <b>Nuevo Hash generado:</b>
                    {$hash}
                    </p>";
                } else {
                    echo "<h2 style='color:orange;'>No se modificó ningún registro.</h2>";
                    echo "<p>Verifica si el correo <b>{$email}</b>
                        existe en la base de datos.
                        </p>";
                    }
                } catch (Exception $e) {
                    echo "<h2 style='color:red;'>Error al actualizar:</h2> " . $e->getMessage();
                }
                ?>