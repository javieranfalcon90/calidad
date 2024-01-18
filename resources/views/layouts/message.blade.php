@if ($message = Session::get('success'))
    Toastify({
        text: "{{ $message }}",
        duration: 5000,
        gravity:"top",
        position: "center",
        style: {
            background: "#4fbe87",
        },
        close: true,
    }).showToast();
@endif

@if ($message = Session::get('danger'))
    Toastify({
        text: "{{ $message }}",
        duration: 5000,
        gravity:"top",
        position: "center",
        style: {
            background: "#dc3545",
        },
        close: true,
    }).showToast();
@endif