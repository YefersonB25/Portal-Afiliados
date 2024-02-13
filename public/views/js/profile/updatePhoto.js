let updatePhoto = function (url) {
    $('#photo-profile-button').click(function () {
        var formData = new FormData($('#photo-profile-form')[0]);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Procesar la respuesta de éxito aquí (puede ser un mensaje de éxito)
                console.log(response);
                // Actualizar la imagen de perfil mostrada en la página
                var profileImage = '{{ asset(', storage; ') }}' + '/' + response.profile_image_url;

                $('#profile-image').attr('src', profileImage);

            },
            error: function (xhr) {
                // Procesar el error aquí (puede ser un mensaje de error de validación)
                console.log(xhr.responseText);
            }
        });
    });
};
