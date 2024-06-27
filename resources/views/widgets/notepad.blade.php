<div class="card mb-3 inventory-category" id="notepad">
    <div class="card-header h3">
        <a data-toggle="collapse" href="#openNotepad">Open Notepad <i class="fas fa-pen-to-square"></i></a>
    </div>
    <div class="card-body collapse mt-1" id="openNotepad">
        <div class="card-body">
            <div class="parsed-text imagenoteseditingparse">
                {!! Auth::user()->settings->parsed_notepad !!}
            </div>
            <div class="mt-3">
                <a href="#" class="btn btn-outline-info btn-sm edit-notes"><i class="fas fa-cog"></i> Edit</a>
            </div>
        </div>
    </div>
</div>


<style>
    #notepad {
        padding: 0.25em 0.75em;
        position: fixed;
        bottom: 1em;
        right: 0.75em;
        display: block;
        transition: all 0.5s ease;
    }
</style>

<script>
    $(document).ready(function() {
        $('.edit-notes').on('click', function(e) {
            e.preventDefault();
            $("div.imagenoteseditingparse").load("{{ url('account/notepad') }}/", function() {
                tinymce.init({
                    selector: '.imagenoteseditingparse .wysiwyg',
                    height: 500,
                    menubar: false,
                    convert_urls: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen spoiler',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                    content_css: [
                        '{{ asset('css/app.css') }}',
                        '{{ asset('css/lorekeeper.css') }}'
                    ],
                    spoiler_caption: 'Toggle Spoiler',
                    target_list: false
                });
            });
            $(".edit-notes").remove();
        });
    });
</script>
