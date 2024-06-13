@extends('client_panel.layouts.app')

@section('content')
    {{-- Start Dashboard Content --}}
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">
            @forelse ($check_ins_sent as $checkin)
                <div class="col-lg-4">
                    <a href="{{ route('client.viewOldClientCheckinForm', ['check_in_id' => $checkin->check_in_id, 'client_check_in_id' => $checkin->client_check_in_id]) }}" class="col-xl-4 col-md-6 mb-4 text-decoration-none">
                        <div class="card border-left-success shadow custom-card-height py-2 custom-card custom-card-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="col-auto mb-4">
                                            <i class="fas fa-scroll fa-3x text-gray-300"></i>
                                        </div>
                                        <div class="text-xs font-weight-bold text-success text-uppercase custom-font-size custom-text">
                                            {{ $checkin->check_in_name }}
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
                        No old check-ins found with answers.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- /.container-fluid -->
    {{-- End Dashboard Content --}}
@endsection
