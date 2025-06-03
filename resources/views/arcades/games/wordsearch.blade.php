<div>
    <p>The objective of this puzzle is to find and mark all the words hidden inside the box. The words may be placed horizontally, vertically, or diagonally, and can be backwards too. </p>
    <p>Click and drag starting at the word's first letter, and ending at the last, to select a correct word. If the page is failing to recognize your input, try to slow down your movement and drag in a more straight line.</p>
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
