<script>
    $(document).ready(function() {
        $('#increment').change(function() {
            if ($(this).is(':checked')) {
                $('.increment').removeClass('hide');
            } else {
                $('.increment').addClass('hide');
            }
        });
        $('#use_pool').change(function() {
            if ($(this).is(':checked')) {
                $('.use_pool').removeClass('hide');
            } else {
                $('.use_pool').addClass('hide');
            }
        });
    });
</script>
