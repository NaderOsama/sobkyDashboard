
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-3 text-gray-800">All Alerts</h1>


                    <!-- My Alerts -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Alerts</h6>
                        </div>
                                <div class="card-body">
                                    @forelse ($submittedAnswers as $clientCheckIn)
                                        <a class="dropdown-item d-flex align-items-center {{ !$clientCheckIn->notification_viewed ? 'bg-warning' : '' }}"
                                        href="{{ route('clients.profile', $clientCheckIn->client->id) }}"
                                        onclick="removeBgWarning(this)">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $clientCheckIn->updated_at->format('F j, Y') }}</div>
                                                <span class="font-weight-bold">{{ $clientCheckIn->client->name }} has submitted {{ $clientCheckIn->checkIn->name }} answers.</span>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="dropdown-item text-center small text-gray-500">No new submissions</p>
                                    @endforelse
                                </div>
                    </div>

                </div>
                <!-- /.container-fluid -->




    {{-- End Dashboard Content --}}
@endsection



