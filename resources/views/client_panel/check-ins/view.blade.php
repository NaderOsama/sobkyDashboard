@extends('client_panel.layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <style>
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $checkIn->name }}</h6>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div id="message" class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var messageDiv = document.getElementById('message');
                                if (messageDiv) {
                                    setTimeout(function () {
                                        messageDiv.style.display = 'none';
                                    }, 5000);
                                }
                            });
                        </script>



                        <form action="{{ route('client.submitClientAnswers', ['client_check_in_id' => $client_check_in_id]) }}" method="POST" id="multiStepForm">
                            @csrf
                            <input type="hidden" name="client_check_in_id" value="{{ $client_check_in_id }}">

                            @foreach ($checkIn->checkIn->checkinForms as $index => $checkinForm)
                                <div class="form-step" id="form-step-{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                    <h4 class="text-center font-weight-bold text-primary mb-4">{{ $checkinForm->name }}</h4>
                                    <div class="row">
                                        @foreach ($checkinForm->questions as $question)
                                            <div class="col-md-6">
                                                <div class="form-group text-right">
                                                    <label for="question_{{ $question->id }}">{{ $question->title }} <span class="text-danger">*</span></label>
                                                    @if ($question->answer_type == 'text')
                                                        <input type="text" class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]" placeholder="{{ $question->description }}">
                                                    @elseif ($question->answer_type == 'textarea')
                                                        <textarea class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]" placeholder="{{ $question->description }}"></textarea>
                                                    @elseif ($question->answer_type == 'select')
                                                        <select class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]">
                                                            @foreach ($question->options as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($question->answer_type == 'checkbox')
                                                        <input type="checkbox" class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]">
                                                    @elseif ($question->answer_type == 'radio')
                                                        <input type="radio" class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]">
                                                    @elseif ($question->answer_type == 'number')
                                                        <input type="number" class="form-control text-right required" id="question_{{ $question->id }}" name="answers[{{ $checkinForm->id }}][{{ $question->id }}]" placeholder="{{ $question->description }}">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-navigation text-right">
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-secondary previous-step">Previous</button>
                                        @endif
                                        @if ($index < $checkIn->checkIn->checkinForms->count() - 1)
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Submit Answers</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </form>
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Video</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkIn->checkIn->checkinForms as $checkinForm)
                        @foreach ($checkinForm->questions as $question)
                            @if ($question->image || $question->video)
                                <tr>
                                    <td>{{ $question->title }}</td>
                                    <td>
                                        @if ($question->image)
                                            <img src="{{ asset('images/questions/' . $question->image) }}" alt="{{ $question->title }}" width="250">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($question->video)
                                            <a href="{{ asset('videos/questions/' . $question->video) }}" target="_blank">View Video</a>
                                            <br>
                                            <video width="320" height="240" controls>
                                                <source src="{{ asset('videos/questions/' . $question->video) }}" type="video/{{ pathinfo($question->video, PATHINFO_EXTENSION) }}">
                                            </video>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
                        <a href="{{ route('client.checkIns') }}" class="btn btn-primary mt-3">Back to Check-ins</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentStep = 0;
            var formSteps = document.querySelectorAll('.form-step');

            function showStep(step) {
                formSteps.forEach(function (formStep, index) {
                    formStep.style.display = index === step ? 'block' : 'none';
                });
            }

            function validateStep(step) {
                var isValid = true;
                var stepInputs = formSteps[step].querySelectorAll('.required');

                stepInputs.forEach(function (input) {
                    if (!input.value) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                return isValid;
            }

            document.querySelectorAll('.next-step').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            document.querySelectorAll('.previous-step').forEach(function (button) {
                button.addEventListener('click', function () {
                    currentStep--;
                    showStep(currentStep);
                });
            });

            showStep(currentStep);
        });
    </script>
@endsection
