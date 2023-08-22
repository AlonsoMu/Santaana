<?php
session_start();

// Verifica si la variable de sesión existe y si no, inicialízala con un valor predeterminado
if (!isset($_SESSION['mi_variable'])) {
  $_SESSION['mi_variable'] = 'valor_predeterminado';
}

// Obtiene el nuevo valor desde la solicitud POST
if (isset($_POST['nuevo_valor'])) {
  $_SESSION['mi_variable'] = $_POST['nuevo_valor'];
  echo "Valor actualizado correctamente";
} else {
  echo "Error al actualizar el valor";
}

var_dump($_SESSION['mi_variable']);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Actualizar Valor de Sesión</title>
</head>

<body>
  <p>Valor actual: <span id="valor-actual"><?php echo $_SESSION['mi_variable']; ?></span></p>
  <input type="text" id="nuevo-valor" placeholder="Nuevo valor">
  <button onclick="actualizarValor()">Actualizar Valor</button>

  <script>
    function actualizarValor() {
      const nuevoValor = document.getElementById('nuevo-valor').value;

      // Cambia 'actualizar_valor.php' por la ruta a tu archivo PHP que actualiza la sesión
      fetch('actualizar_valor.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'nuevo_valor=' + encodeURIComponent(nuevoValor),
        })
        .then(response => response.text())
        .then(data => {
          console.log(data); // Aquí puedes hacer algo con la respuesta del servidor si lo deseas

          // Actualizar el valor mostrado en el cliente sin recargar la página
          document.getElementById('valor-actual').textContent = nuevoValor;
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>
</body>

</html>