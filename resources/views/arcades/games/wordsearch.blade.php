<div>
    <p>
        @if ($award_per_word)
            You will receive rewards <strong>per word found</strong>, even if you do not complete the full word search.
        @else
            You will receive rewards only upon <strong>full completion</strong> of the word search.
        @endif
        @if ($wordMinimum)
            You must find at least <strong>{{ $wordMinimum }} {{ $wordMinimum > 1 ? 'words' : 'word' }}</strong> to receive rewards.
        @endif
    </p>

    <p class="text-danger">This page will not save your progress, so finish promptly, and don't refresh!</p>
</div>

<div class="text-center game">
    <a href="#" class="btn btn-primary play-wsearch"><i class="fas fa-gamepad"></i> Play!</a>
    <hr>
</div>
<script>
    $(document).ready(function() {
        $('.play-wsearch').on('click', function(e) {
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
