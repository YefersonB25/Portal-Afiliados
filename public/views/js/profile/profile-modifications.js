let changePassword = function (url) {
    $('#change-password-button').click(function () {
        $.ajax({
            type: 'POST',
            url: url,
            data: $('#change-password-form').serialize(),
            success: function (response) {
                // Procesar la respuesta aquí (puede ser un mensaje de éxito o error)

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: response[1]
                })

                const errorsContainer = document.getElementById('errors-container');
                errorsContainer.innerHTML = ''; // Limpiar contenido previo
                const ul = document.createElement('ul');
                    const li = document.createElement('li');
                    li.textContent = response.error;
                    ul.appendChild(li);
                errorsContainer.appendChild(ul);

            },
            error: function (xhr) {

                // Procesar el error aquí (puede ser un mensaje de error de validación)
                const errors = xhr.responseJSON.errors;
                const errorCollection = [];

                for (const field in errors) {
                    const errorMessages = errors[field].join(', ');
                    errorCollection.push(`${field}: ${errorMessages}`);
                }
                displayErrors(errorCollection);
            }
        });

        function displayErrors(errors) {
            const errorsContainer = document.getElementById('errors-container');
            errorsContainer.style.display = "block";
            errorsContainer.innerHTML = ''; // Limpiar contenido previo
            const ul = document.createElement('ul');
            errors.forEach(function(error) {
                const li = document.createElement('li');
                li.textContent = error;
                ul.appendChild(li);
            });
            errorsContainer.appendChild(ul);
        }
    });

}

let updatePhoto = function (url) {
    $('#photo-profile-button').click(function() {
        var formData = new FormData($('#photo-profile-form')[0]);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Procesar la respuesta de éxito aquí (puede ser un mensaje de éxito)
                console.log(response);
                // Actualizar la imagen de perfil mostrada en la página
                $('#profile-image').attr('src', response.profile_image_url);
            },
            error: function(xhr) {
                // Procesar el error aquí (puede ser un mensaje de error de validación)
                console.log(xhr.responseText);
            }
        });
    });
}

