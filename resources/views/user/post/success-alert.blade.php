<script>
    Swal.fire({
        imageUrl: '{{ asset('images/alert gif/happy.gif') }}',
        imageWidth: 300,
        imageHeight: 300,
        title: '{{ $message }}',
        showConfirmButton: true,
    }).then(() => {
        location.reload();
    });
</script>
