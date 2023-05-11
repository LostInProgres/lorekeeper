@extends('layouts.app')

@section('title') Home @endsection

@section('content')
<div class="row">
    <div class="col text-center">
        <img src="https://media.discordapp.net/attachments/905923832173436958/1090990552243253258/bunny.png?width=312&height=435"/>
    </div>
    <div class="col text-center">
        <h1>Currently looking for</h1>
        @if(isset($fetchItem) && $fetchItem)
            @if($fetchItem->imageUrl)
            <div>
                <a href="{{ $fetchItem->url }}"><img src="{{ $fetchItem->imageUrl}}"/></a>
            </div>
            @endif
            <div class="mt-1">
                <a href="{{ $fetchItem->url }}" class="h5 mb-0"> {{ $fetchItem->name }}</a>
            </div>
        @else
            <p>There is no fetch item.</p>
        @endif

        <h1>Reward Offered</h1>
        @if(isset($fetchCurrency) && $fetchCurrency && $fetchRewardmax && $fetchReward)
        <div>{!! $fetchCurrency->display($fetchReward) !!} - {!! $fetchCurrency->display($fetchRewardmax) !!}</div>
        @else
            <p>There is no reward.</p>
        @endif
        @if(isset($fetchCurrency) && $fetchCurrency && $fetchRewardmax && $fetchReward)
            <div class="text-right">
                <a href="#" class="btn btn-primary" id="submitButton">Lend a hand!</a>
            </div>
            @else
            You can't turn in a quest with no reward!
            @endif

        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h5 mb-0">Confirm  Submission</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>This will submit the fetch quest, remove the item asked for, and add currency to your account. Are you sure?</p>
                    {!! Form::open(['url' => 'fetch/new']) !!}
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
@endsection

@section('scripts')
@parent 
    <script>
        $(document).ready(function() {
            var $submitButton = $('#submitButton');
            var $confirmationModal = $('#confirmationModal');
            var $formSubmit = $('#formSubmit');
            
            $submitButton.on('click', function(e) {
                e.preventDefault();
                $confirmationModal.modal('show');
            });

            $formSubmit.on('click', function(e) {
                e.preventDefault();
                $submissionForm.submit();
            });

            $('.is-br-class').change(function(e){
            console.log(this.checked)
            $('.br-form-group').css('display',this.checked ? 'block' : 'none')
                })
            $('.br-form-group').css('display',$('.is-br-class').prop('checked') ? 'block' : 'none')
        });
    </script>
@endsection