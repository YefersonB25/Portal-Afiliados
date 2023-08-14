let actionCheck = function (action) {

    if (action == 'PUSHER') {
        document.getElementById("Pusher").className = "toggle on";
    } if (action == 'EMAIL') {
        document.getElementById("Pusher").className = "toggle on";
    } if (action == 'TODOS') {
        document.getElementById("Pusher").className = "toggle on";
        document.getElementById("Pusher").className = "toggle on";
    }
}

let ajax = function (route, checkPusher, checkEmail) {

    let typeNotification = updateTypeNotification(checkPusher, checkEmail)

    $.ajax({
        type: "GET",
        url: route,
        data: {
            "_token": "{{ csrf_token() }}",
            notification: typeNotification
        },
        error: function (error) {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo fallo con la respuesta!',
            })
            console.error(error);
        }
    });
}

let updateTypeNotification = function (checkPusher, checkEmail) {
    let typeNotification

    if (checkPusher != 'toggle' && checkEmail != 'toggle') {
        typeNotification = 'TODOS'
    }
    if (checkPusher != 'toggle' && checkEmail == 'toggle') {
        typeNotification = 'PUSHER'
    }
    if (checkEmail != 'toggle' && checkPusher == 'toggle') {
        typeNotification = 'EMAIL'
    }
    return typeNotification
}
