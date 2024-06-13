@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Check-in Form Details</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $checkinForm->name }}</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Check-in Type:</strong> {{ $checkinForm->checkinType->name }}</p>
                        <p><strong>Created At:</strong> {{ $checkinForm->created_at->toDayDateTimeString() }}</p>
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

                        <form action="{{ route('forms.submitAnswers', $checkinForm->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                @foreach ($checkinForm->questions as $question)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="question_{{ $question->id }}">{{ $question->title }}</label><span class="text-danger">&nbsp;*</span>
                                            @if ($question->answer_type == 'text')
                                                <input type="text" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" placeholder="{{ $question->description }}">
                                            @elseif ($question->answer_type == 'textarea')
                                                <textarea class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" placeholder="{{ $question->description }}"></textarea>
                                            @elseif ($question->answer_type == 'select')
                                                <select class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]">
                                                    <!-- Add options dynamically here -->
                                                </select>
                                            @elseif ($question->answer_type == 'checkbox')
                                                <input type="checkbox" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]">
                                            @elseif ($question->answer_type == 'radio')
                                                <input type="radio" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]">
                                            @elseif ($question->answer_type == 'number')
                                                <input type="number" class="form-control" id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" placeholder="{{ $question->description }}">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Answers</button>
                        </form>

                        <h5 class="mt-4">Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Video</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checkinForm->questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->title }}</td>
                                            <td>
                                                @if($question->image)
                                                    <img src="{{ asset('images/questions/' . $question->image) }}" alt="{{ $question->title }}" width="50">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($question->video)
                                                    <a href="{{ asset('videos/questions/' . $question->video) }}" target="_blank">View Video</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('forms.formQuestion') }}" class="btn btn-primary mt-3">Back to Forms</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
