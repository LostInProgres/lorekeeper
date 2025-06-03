<script>
    $("#selectable").selectable({
        selected: function(event, ui) {
            $(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");
            var result = $(".option").empty();
            result.val($(ui.selected).attr("value"));
        }
    });
</script>
