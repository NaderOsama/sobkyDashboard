@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Check-in</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Check-in</h6>
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

                        <form action="{{ route('forms.storeCheckIn') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label><span class="text-danger">&nbsp;*</span>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="request_every_days">Request Every (Days)</label><span class="text-danger">&nbsp;*</span>
                                        <input type="number" class="form-control" id="request_every_days" name="request_every_days" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="checkin_form_ids">Check-in Forms</label><span class="text-danger">&nbsp;*</span>
                                        <select class="form-control" id="checkin_form_ids" name="checkin_form_ids[]" multiple="multiple" required>
                                            @foreach ($checkinForms as $checkinForm)
                                                <option value="{{ $checkinForm->id }}">{{ $checkinForm->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Check-In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4" id="Check-in Form">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Check-ins</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Request Every (Days)</th>
                                        <th>Since</th>
                                        <th>Forms</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checkins as $checkin)
                                        <tr>
                                            <td>{{ $checkin->id }}</td>
                                            <td>{{ $checkin->name }}</td>
                                            <td>{{ $checkin->request_every_days }}</td>
                                            <td>{{ \Carbon\Carbon::parse($checkin->created_at)->diffForHumans() }} <br> {{ $checkin->created_at }}</td>
                                            <td>
                                                @foreach ($checkin->checkinForms as $form)
                                                    <span class="badge badge-secondary">{{ $form->name }}</span>
                                                @endforeach
                                            </td>

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
@endsection
