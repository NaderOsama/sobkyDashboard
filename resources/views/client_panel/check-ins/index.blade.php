@extends('client_panel.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if(session('success'))
                        <div id="message" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
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
                </div>

            </div>
        </div>
        <div class="row">
            @forelse ($check_ins_sent as $checkin)
                <div class="col-lg-4">
                    <a href="{{ route('client.viewClientCheckinForm', ['client_check_in_id' => $checkin->client_check_in_id, 'check_in_id' => $checkin->check_in_id]) }}" class="col-xl-4 col-md-6 mb-4 text-decoration-none">
                        <div class="card border-left-primary shadow custom-card-height py-2 custom-card custom-card-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="col-auto mb-4">
                                            <i class="fas fa-scroll fa-3x text-gray-300"></i>
                                        </div>
                                        <div class="text-xs font-weight-bold text-primary text-uppercase custom-font-size custom-text">
                                            {{ $checkin->check_in_name }}
                                            {{ $checkin->client_check_in_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="alert alert-info text-center font-weight-bold" role="alert">
                        No check-ins found.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
