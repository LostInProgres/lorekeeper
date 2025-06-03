<div>
    <p class="text-danger">This page will not save your progress, so finish promptly, and don't refresh!</p>
</div>

<div class="text-center game">
    <a href="#" class="btn btn-primary play-sudo"><i class="fas fa-gamepad"></i> Play!</a>
    <hr>
</div>
<script>
    $(document).ready(function() {
        $('.play-sudo').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "{{ url('arcade/' . $arcade->id . '/play/ajax') }}",
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
