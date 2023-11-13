<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión con Google</title>
</head>

<body>

    <!-- Agrega un botón para iniciar sesión con Google -->
    <button onclick="signInWithGoogle()">Iniciar sesión con Google</button>

    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId());
            console.log('Nombre: ' + profile.getName());
            console.log('Email: ' + profile.getEmail());
            // Aquí puedes realizar acciones adicionales, como redirigir al usuario a tu página de inicio
        }

        function signInWithGoogle() {
            // Carga el script de Google Sign-In de forma dinámica
            var script = document.createElement('script');
            script.src = 'https://apis.google.com/js/platform.js';
            script.onload = function () {
                // Inicializa el sistema de autenticación de Google
                gapi.load('auth2', function () {
                    gapi.auth2.init({
                        client_id: '595754833770-sstqipnc0h9mbmfbtmu91sppln4mjp0f.apps.googleusercontent.com',
                    }).then(function () {
                        // Ahora, el sistema de autenticación de Google está inicializado
                        gapi.auth2.getAuthInstance().signIn().then(onSignIn);
                    });
                });
            };
            document.head.appendChild(script);
        }
    </script>

</body>

</html>
