
Pusher.logToConsole = false;
var pusher = new Pusher('8be28df216f44b35f164', {
    cluster: 'us2',
});


let canalpucher = function () {
    var channel = pusher.subscribe('my-channel');

    channel.bind("MyEvent", (data) => {
        // add new price into the APPL widget
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: data
        })
    });

}

