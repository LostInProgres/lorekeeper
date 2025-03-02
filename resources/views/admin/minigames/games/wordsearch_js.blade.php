<script>
    $(document).ready(function() {
        $('.word-selectize').selectize();
        $('.word-list').selectize({
            plugins: ["restore_on_backspace", "remove_button"],
            delimiter: ",",
            persist: false,
            create: true,
            preload: true,
        });

        @if (isset($data['words']))
            $('#copy').on('click', async (e) => {
                await window.navigator.clipboard.writeText("{{ $data['words'] }}");
            });
        @endif

        $('#award_per_word').change(function() {
            if ($(this).is(':checked')) {
                $('.award_per_word').removeClass('hide');
            } else {
                $('.award_per_word').addClass('hide');
            }
        });

        $('#clear-words').on('click', function(e) {
            $('.word-list')[0].selectize.clear();
        });
    });
</script>
