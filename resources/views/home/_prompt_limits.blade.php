@php
    use App\Models\Submission\Submission;
    use App\Models\Prompt\Prompt;

    if(!isset($prompt)) {
        $prompt = Prompt::find($submission->prompt_id);
    }

    if(isset($staffView)) {
        $pronoun = 'This user';
    } else {
        $pronoun = 'You';
    }

    if(isset($staffView)) {
        $pronounHas = 'This user has';
    } else {
        $pronounHas = 'You have';
    }

    $limit = $prompt->limit;
    $submission = Submission::whereNotNull('prompt_id')->where('id', $prompt->id)->where('status', '!=', 'Draft')->first();
    
    if (isset($submission->user_id)) {
        $count['pending'] = Submission::submitted($prompt->id, $submission->user_id)->whereNotIn('status', ['approved', 'rejected'])->count();

        $count['all'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->count();
        $count['Hour'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->where('created_at', '>=', now()->startOfHour())->count();
        $count['Day'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->where('created_at', '>=', now()->startOfDay())->count();
        $count['Week'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->where('created_at', '>=', now()->startOfWeek())->count();
        $count['Month'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->where('created_at', '>=', now()->startOfMonth())->count();
        $count['Year'] = Submission::submitted($prompt->id, $submission->user_id)->where('status', '=', 'Approved')->where('created_at', '>=', now()->startOfYear())->count();
    }
@endphp

<div class="card">
    <div class="card-body">
        <h4>Submission Limits {!! add_help('This is the number of times the user has submitted this prompt before, pending or approved.') !!}</h4>
            <p>{{ $pronounHas }} completed this prompt <strong>{{ $count['all'] }}</strong> time{{ $count['all'] == 1 ? '' : 's' }} overall.<br>
            {{ $pronounHas }} <strong>{{ $count['pending'] }}</strong> of this prompt either in drafts or pending.</p>
            @if($prompt->limit) 
                <p>{{ $pronounHas }} already completed this prompt {{ $prompt->limit_period ? $count[$prompt->limit_period] : $count['all'] }} out of {{ $limit }} times
                {{ $prompt->limit_period ? 'for this '.strtolower($prompt->limit_period) : '' }}.
                <div class="row">
                    <div class="row text-center col-12">
                        <div class="col"><strong>All Time</strong></div>
                        <div class="col"><strong>Past Hour</strong></div>
                        <div class="col"><strong>Past Day</strong></div>
                        <div class="col"><strong>Past Week</strong></div>
                        <div class="col"><strong>Past Month</strong></div>
                        <div class="col"><strong>Past Year</strong></div>
                    </div>
                    <div class="row text-center col-12">
                        <div class="col">{{ $count['all'] }}</div>
                        <div class="col">{{ $count['Hour'] }}</div>
                        <div class="col">{{ $count['Day'] }}</div>
                        <div class="col">{{ $count['Week'] }}</div>
                        <div class="col">{{ $count['Month'] }}</div>
                        <div class="col">{{ $count['Year'] }}</div>
                    </div>
                </div>
                <div class="{{ $prompt->limit ? 'text-danger' : '' }}">
                    <p>{{ $prompt->limit ? $pronoun. ' can submit this prompt '.$prompt->limit.' time(s)' : 'You can submit this prompt an unlimited number of times' }}
                    {{ $prompt->limit_period ? ' per '.strtolower($prompt->limit_period) : '' }}
                    {{ $prompt->limit_character ? ' per character' : ''}}.</p>
                </div>
            @endif
    </div>
</div>