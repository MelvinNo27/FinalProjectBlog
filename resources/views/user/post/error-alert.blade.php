<script>
    Swal.fire({
        icon: 'error',
        text: '{{ $error }}',
        showConfirmButton: true,
    }).then(() => {
        location.reload();
    });
</script>
