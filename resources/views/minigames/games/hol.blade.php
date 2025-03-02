<div class="text-center game">
    <a href="#" class="btn btn-primary play-hol"><i class="fas fa-gamepad"></i> Play!</a>
    <hr>
</div>
<script>
    $(document).ready(function() {
        $('.play-hol').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "{{ url('minigames/' . $minigame->id . '/play/ajax') }}",
            }).done(function(res) {
                $(".game").fadeOut(500, function() {
                    $(".game").html(res);
                    $(".game").fadeIn(500);
                });
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });
        });
    });
</script>
