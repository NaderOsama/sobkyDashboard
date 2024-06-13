
@extends('client_panel.layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <div class="row">
                        <a href="{{ route('client.checkIns') }}" class="col-xl-4 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-primary shadow custom-card-height py-2 custom-card custom-card-1">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="col-auto mb-4">
                                                <i class="fas fa-scroll fa-3x text-gray-300"></i>
                                            </div>
                                            <div class="text-xs font-weight-bold text-primary text-uppercase custom-font-size custom-text">
                                                Check-Ins
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('client.oldCheckIns') }}" class="col-xl-4 col-md-6 mb-4 text-decoration-none">
                            <div class="card border-left-success shadow custom-card-height py-2 custom-card custom-card-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="col-auto mb-4">
                                                <i class="fas fa-file-signature fa-3x text-gray-300"></i>
                                            </div>
                                            <div class="text-xs font-weight-bold text-success text-uppercase custom-font-size custom-text">
                                                Old Check-Ins
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>







                </div>
                <!-- /.container-fluid -->




    {{-- End Dashboard Content --}}
@endsection



