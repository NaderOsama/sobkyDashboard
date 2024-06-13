@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Accounts</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Coach & Admin</h6>
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

                            <div class="text-center">
                            </div>
                            <form class="user" method="POST" action="{{ route('accounts.register') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="name"
                                            name="name" value="{{ old('name') }}" required placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email"
                                        name="email" value="{{ old('email') }}" required placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="phone"
                                        name="phone" value="{{ old('phone') }}" required placeholder="Phone">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" name="password" required placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="password_confirmation" name="password_confirmation" required placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="coach" {{ old('role') == 'coach' ? 'selected' : '' }}>Coach</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Creact Account
                                </button>

                            </form>
                            <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
