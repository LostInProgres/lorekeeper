<script>
$( document ).ready(function() {
    $('#use_7').change(function() {
            if ($(this).is(':checked')) {
                $('.use_7').removeClass('hide');
            } else {
                $('.use_7').addClass('hide');
            }
        });
});
</script>
