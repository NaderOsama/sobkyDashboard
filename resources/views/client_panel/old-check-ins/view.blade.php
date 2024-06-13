@extends('client_panel.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12 col-md-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $checkInDetails[0]->check_in_name }}</h6>
                    <a href="{{ route('client.oldCheckIns') }}" class="btn btn-primary">Back to Old Check-ins</a>
                </div>
                <div class="card-body">
                    <form id="multiStepForm">
                        @csrf
                        <input type="hidden" name="check_in_id" value="{{ $checkInDetails[0]->check_in_id }}">

                        @php
                            $currentForm = null;
                        @endphp

                        @foreach ($checkInDetails as $index => $detail)
                            @if ($currentForm !== $detail->checkin_form_id)
                                @if ($currentForm !== null)
                                    </div>
                                    <div class="form-navigation d-flex justify-content-between">
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-secondary previous-step">Previous</button>
                                        @endif
                                        @if ($index < count($checkInDetails) - 1)
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php
                                    $currentForm = $detail->checkin_form_id;
                                @endphp
                                <div class="form-step" id="form-step-{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                    <h4 class="text-center font-weight-bold text-primary mb-4">{{ $detail->checkin_form_name }}</h4>
                                    <div class="row">
                            @endif
                            <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                <div class="form-group text-right">
                                    <label for="question_{{ $detail->question_id }}">{{ $detail->question_title }}</label><span class="text-danger"> *</span>
                                    @switch($detail->question_answer_type)
                                        @case('text')
                                            <input type="text" class="form-control text-right required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" placeholder="{{ $detail->question_description }}" value="{{ $detail->form_answer_answer }}" readonly>
                                            @break
                                        @case('textarea')
                                            <textarea class="form-control text-right required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" placeholder="{{ $detail->question_description }}" readonly>{{ $detail->form_answer_answer }}</textarea>
                                            @break
                                        @case('select')
                                            <select class="form-control text-right required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" readonly>
                                                <!-- Add options dynamically here -->
                                            </select>
                                            @break
                                        @case('checkbox')
                                            <input type="checkbox" class="form-check-input ml-1 required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" {{ $detail->form_answer_answer ? 'checked' : '' }} readonly>
                                            @break
                                        @case('radio')
                                            <input type="radio" class="form-check-input ml-1 required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" {{ $detail->form_answer_answer ? 'checked' : '' }} readonly>
                                            @break
                                        @case('number')
                                            <input type="number" class="form-control text-right required" id="question_{{ $detail->question_id }}" name="answers[{{ $detail->checkin_form_id }}][{{ $detail->question_id }}]" placeholder="{{ $detail->question_description }}" value="{{ $detail->form_answer_answer }}" readonly>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        @endforeach
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
