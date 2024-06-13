<!-- resources/views/checkinForms/create.blade.php -->
@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Check-in Form</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Check-in Form</h6>
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

                        </script>

                        <form action="{{ route('forms.storeFormQuestion') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Form Name</label><span class="text-danger">&nbsp;*</span>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ session('form_data.name', '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="checkin_type_id">Check-in Type</label><span class="text-danger">&nbsp;*</span>
                                        <select class="form-control" id="checkin_type_id" name="checkin_type_id" required>
                                            <option value="">Select Check-in Type</option>
                                            @foreach ($checkintypes as $checkin_type)
                                                <option value="{{ $checkin_type->id }}" {{ session('form_data.checkin_type_id') == $checkin_type->id ? 'selected' : '' }}>{{ $checkin_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="questions">Questions</label>
                                        <select class="form-control" id="questions" name="questions[]" multiple="multiple" required>
                                            @foreach ($questions as $question)
                                                <option value="{{ $question->id }}" {{ in_array($question->id, session('form_data.questions', [])) ? 'selected' : '' }}>{{ $question->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Create Check-in Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 col-md-8 mb-4" id="Check-in Form">

                <!-- Check-in Form Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Check-in Form</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Scince</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checkinforms as $checkinform)
                                    <tr>
                                        <td>{{ $checkinform->id }}</td>
                                        <td>{{ $checkinform->name }}</td>
                                        <td>{{ $checkinform->checkinType->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($checkinform->created_at)->diffForHumans() }} <br> {{ $checkinform->created_at }}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
