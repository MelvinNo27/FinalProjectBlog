<script>
    $(document).ready(function() {
        $('#create-post').click(function() {
            $('#post-form').removeClass('d-none').animate({ right: '0' }, 300);
            $('#user-posts').hide();
        });
    });
</script>