@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sobky Fitness</h1>
            <a href="{{ route('report') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Team Member Report
            </a>
        </div>


        <!-- Content Row -->
        <div class="row">
            <!-- All Clients Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    All Clients</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clientCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ALL Coaches Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    ALL Coaches
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $coachesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Packages Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    All Packages
                                </div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $packagesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Clents Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Clents</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clientCheckInCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->


        <div class="row">
            <!-- Pie Chart -->
            <div class="col-xl-8 col-md-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Clients Overview</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <!-- Pie Chart -->
                            <div class="col-xl-4">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                            </div>
                            <!-- Table -->
                            <div class="col-xl-8">
                                <div class="mb-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Clients</th>
                                                        <th>Value</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="mr-2"><i class="fas fa-circle text-primary"></i></span>Subscribe</td>
                                                        <td>{{ $subscribeCount }}</td>
                                                        <td>{{ number_format($subscribePercentage, 2) }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="mr-2"><i class="fas fa-circle text-warning"></i></span>On hold</td>
                                                        <td>{{ $onHoldCount }}</td>
                                                        <td>{{ number_format($onHoldPercentage, 2) }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="mr-2"><i class="fas fa-circle text-danger"></i></span>Expired</td>
                                                        <td>{{ $expiredCount }}</td>
                                                        <td>{{ number_format($expiredPercentage, 2) }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="mr-2"><i class="fas fa-circle text-dark"></i></span>No subscription</td>
                                                        <td>{{ $noSubscriptionCount }}</td>
                                                        <td>{{ number_format($noSubscriptionPercentage, 2) }}%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-5">

                <!-- 🎂 Upcoming Birthdays -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">🎂 Upcoming Birthdays</h6>
                        </div>
                        <div class="card-body">
                            @if($upcomingBirthdays->isEmpty())
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;" src="img/UpcomingBirthdays.svg" alt="...">
                                    <p class="text-center font-weight-bold text-dark">There are no upcoming birthday dates</p>
                                </div>
                            @else
                                <ul class="list-group">
                                    @foreach($upcomingBirthdays as $birthday)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $birthday->name }} - {{ \Carbon\Carbon::parse($birthday->birth_date)->format('F j') }}
                                            <span class="badge badge-primary badge-pill">{{ \Carbon\Carbon::parse($birthday->birth_date)->diffForHumans() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    @if ( Auth::user()->role == 'admin' )
                        <!-- Notes -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                                    <a href="{{ route('notes.index') }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                </div>
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
                                    // Wait for the document to load
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Get the message div
                                        var messageDiv = document.getElementById('message');
                                        // Check if the message div exists
                                        if (messageDiv) {
                                            // Set timeout to close the message div after 5 seconds (5000 milliseconds)
                                            setTimeout(function () {
                                                // Hide the message div
                                                messageDiv.style.display = 'none';
                                            }, 5000); // Adjust the time in milliseconds as needed
                                        }
                                    });
                                </script>
                                <div class="form-group">
                                <form action="{{ route('notes.store') }}" method="POST">
                                        @csrf

                                        <textarea class="form-control mb-2" id="note" rows="3" placeholder="Enter your notes..." name="note"></textarea>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    @endif

            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-12 col-md-8 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pending Clients</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Check In</th>
                                        <th>Client</th>
                                        <th>Client Phone</th>
                                        <th>Package</th>
                                        <th>Group</th>
                                        <th>Remaining Days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($clientCheckIns->isEmpty())
                                        <tr>
                                            <td colspan="8">No pending clients found.</td>
                                        </tr>
                                    @else
                                        @foreach ($clientCheckIns as $index => $clientCheckIn)
                                            @php
                                                $firstFormAnswer = $clientCheckIn->formAnswers->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $clientCheckIn->checkIn->name }}</td>
                                                <td>
                                                    <div class="media align-items-center">
                                                        @if ( $clientCheckIn->client->profile_image === null )
                                                            <img class="img-profile rounded-circle mr-2" src="img/undraw_profile.svg" alt="{{ $clientCheckIn->client->name }}" width="50" height="50">
                                                        @else
                                                            <img class="img-profile rounded-circle mr-2" src="{{ asset('profile_images/' . $clientCheckIn->client->profile_image) }}" alt="{{ $clientCheckIn->client->name }}" width="50" height="50">
                                                        @endif
                                                        <div class="media-body">
                                                            <a href="{{ route('clients.profile', $clientCheckIn->client->id) }}">{{ $clientCheckIn->client->name }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $clientCheckIn->client->mobile }}</td>
                                                <td>{{ $clientCheckIn->client->subscriptions->first()->package->name ?? 'N/A' }}</td>
                                                <td>{{ $clientCheckIn->client->group->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($firstFormAnswer->remaining_days < 0)
                                                        <span class="badge badge-danger p-3 font-weight-bold">{{ $firstFormAnswer->remaining_days }}</span>
                                                    @elseif($firstFormAnswer->remaining_days == 0)
                                                        <span class="badge badge-warning p-3 font-weight-bold">{{ $firstFormAnswer->remaining_days }}</span>
                                                    @else
                                                        {{ $firstFormAnswer->remaining_days }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary rounded-circle p-2" href="#"><i class="fas fa-pen"></i></a>
                                                    <a class="btn btn-danger rounded-circle p-2" href="#"><i class="fas fa-trash-alt"></i></a>
                                                    <form action="{{ route('clients.sendCheckInAnswer', ['client' => $clientCheckIn->client->id]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="check_in_id" value="{{ $clientCheckIn->checkIn->id }}">
                                                        <input type="hidden" name="client_check_in_id" value="{{ $firstFormAnswer->client_check_in_id }}">
                                                        <button type="submit" class="btn btn-info p-2 m-1">Send Check In</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 col-md-8 mb-4" id="allClients">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Clients</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Group</th>
                                        <th>Phone</th>
                                        <th>Package Name</th>
                                        <th>Start At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($clientsandsubscriptionsandpackages->isEmpty())
                                        <tr>
                                            <td colspan="10">No clients found.</td>
                                        </tr>
                                    @else
                                        @foreach ($clientsandsubscriptionsandpackages as $client)
                                            @foreach ($client->subscriptions as $subscription)
                                                <tr>
                                                    <td>{{ $client->code }}</td>
                                                    <td>{{ $client->name }}</td>
                                                    <td>{{ optional($client->group)->name }}</td>
                                                    <td>{{ $client->mobile }}</td>
                                                    <td>{{ optional($subscription->package)->name }}</td>
                                                    <td>{{ $subscription->start_at->format('Y-m-d') }}</td>
                                                    <td>{{ $subscription->created_by }}</td>
                                                    <td>{{ $client->status }}</td>
                                                    <td>
                                                        <a href="{{ route('clients.profile', $client->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!-- /.container-fluid -->
    {{-- End Dashboard Content --}}
@endsection
   