{!! Form::open(['url' => 'account/notepad']) !!}
    <div class="form-group">
        {!! Form::textarea('notepad', Auth::user()->settings->notepad, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

<script>
    $(document).ready(function() {
        @include('js._modal_wysiwyg')
    });
</script>