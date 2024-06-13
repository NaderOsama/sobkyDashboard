@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}
    <style>
        /* Custom CSS for profile page */
        .profile-section {
            display: none;
            margin-bottom: 20px;
            background-color: #fff;
            border: none;
            border-radius: 8px;
            padding: 20px;
        }

        .active {
            display: block;
        }


        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }



        .status-box {
            background-color: #f8f9fc;
            padding: 10px;
            border: 1px solid #d1d3e2;
            border-radius: 5px;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
        }

        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .action-buttons .btn {
            margin: 5px;
        }

        .personal-info-label {
            font-weight: bold;
        }

        .personal-info-value {
            margin-bottom: 10px;
        }
    </style>



    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-2">
                <div class="list-group">
                    <a href="#personal-info" class="list-group-item list-group-item-action">Personal Info</a>
                    <a href="#observations" class="list-group-item list-group-item-action">Observations</a>
                    <a href="#check-ins" class="list-group-item list-group-item-action">Check-ins</a>
                    <a href="#measurements" class="list-group-item list-group-item-action">Measurements</a>
                    <a href="#inbody" class="list-group-item list-group-item-action">InBody</a>
                    <a href="#injuries" class="list-group-item list-group-item-action">Injuries</a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9">

                <!-- Each section content will be loaded here dynamically -->
                <div id="personal-info" class="profile-section active">
                    <!-- Card for selecting options -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Overview</h6>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
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
                            <div id="alertContainer" class="alert alert-success alert-dismissible fade show" role="alert"
                                style="display:none;">
                                <i class="bi bi-check-circle-fill"></i>
                                <span id="alertText" class="ml-2"></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <script>
                            // Wait for the document to load
                            document.addEventListener('DOMContentLoaded', function() {
                                // Get the message div
                                var messageDiv = document.getElementById('message');
                                // Check if the message div exists
                                if (messageDiv) {
                                    // Set timeout to close the message div after 5 seconds (5000 milliseconds)
                                    setTimeout(function() {
                                        // Hide the message div
                                        messageDiv.style.display = 'none';
                                    }, 5000); // Adjust the time in milliseconds as needed
                                }
                            });
                        </script>
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <!-- Edit Icon -->
                                <div class="edit-icon" onclick="openFileInput()">
                                    <!-- Font Awesome Edit Icon -->
                                    <i class="fas fa-edit"></i>
                                    <!-- Add tooltip for clarity -->
                                    <span class="tooltiptext">Edit
                                        Image</span>
                                </div>
                                <!-- Profile Image -->
                                @if ($clientsandsubscriptionsandpackages->profile_image === null)
                                    @if ($clientsandsubscriptionsandpackages->gender === 'Male')
                                        <img id="profile-image" src="{{ asset('img/undraw_profile_2.svg') }}" alt="Profile Image" class="profile-image">
                                    @else
                                        <img id="profile-image" src="{{ asset('img/undraw_profile_3.svg') }}" alt="Profile Image" class="profile-image">
                                    @endif

                                @else
                                    <img src="{{ asset('profile_images/' . $clientsandsubscriptionsandpackages->profile_image) }}"
                                        alt="Profile Image" class="profile-image">
                                @endif
                                <!-- Hidden file input field -->
                                <form id="image-form"
                                    action="{{ route('clients.updateImage', $clientsandsubscriptionsandpackages->id) }}"
                                    method="POST" enctype="multipart/form-data" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" id="file-input" name="profile_image" accept="image/*"
                                        onchange="submitForm()">
                                </form>
                                <script>
                                    function openFileInput() {
                                        document.getElementById('file-input').click();
                                    }

                                    function submitForm() {
                                        document.getElementById('image-form').submit();
                                    }
                                </script>
                            </div>

                            <div class="col-md-8 profile-details text-center">
                                <h3 class="mt-3">{{ $clientsandsubscriptionsandpackages->name }}</h3>
                                <p><i class="fas fa-map-marker-alt m-1"></i> <span
                                        class="m-1">{{ optional($clientsandsubscriptionsandpackages->group)->name }}</span>
                                </p>
                                <div class="status-box">
                                    <strong>Status:</strong> {{ $clientsandsubscriptionsandpackages->status }}
                                </div>

                                <div class="action-buttons">
                                    <button class="btn btn-primary" id="copyLink">Copy Link</button>
                                    <input type="hidden" id="linkText" value="Link: http://127.0.0.1:8000/client/login/">
                                    <button class="btn btn-info" id="copyCredentials">Copy Credentials</button>
                                    <input type="hidden" id="credentialsText"
                                        value="Credentials: Phone Number: {{ $clientsandsubscriptionsandpackages->mobile }} Code: {{ $clientsandsubscriptionsandpackages->code }}">

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var alertContainer = document.getElementById('alertContainer');
                                            alertContainer.style.display = 'none';

                                            document.getElementById('copyLink').addEventListener('click', function() {
                                                var copyText = document.getElementById('linkText').value;
                                                var tempTextarea = document.createElement('textarea');
                                                tempTextarea.value = copyText;
                                                document.body.appendChild(tempTextarea);
                                                tempTextarea.select();
                                                tempTextarea.setSelectionRange(0, 99999);
                                                document.execCommand('copy');
                                                document.body.removeChild(tempTextarea);
                                                var alertText = document.getElementById('alertText');
                                                alertText.textContent = 'Message copied successfully';
                                                alertContainer.style.display = 'flex';
                                                setTimeout(function() {
                                                    alertContainer.style.display = 'none';
                                                }, 5000);
                                            });

                                            document.getElementById('copyCredentials').addEventListener('click', function() {
                                                var credentialsText = document.getElementById('credentialsText').value;
                                                var tempTextareaCredentials = document.createElement('textarea');
                                                tempTextareaCredentials.value = credentialsText;
                                                document.body.appendChild(tempTextareaCredentials);
                                                tempTextareaCredentials.select();
                                                tempTextareaCredentials.setSelectionRange(0, 99999);
                                                document.execCommand('copy');
                                                document.body.removeChild(tempTextareaCredentials);
                                                var alertText = document.getElementById('alertText');
                                                alertText.textContent = 'Message copied successfully';
                                                alertContainer.style.display = 'flex';
                                                setTimeout(function() {
                                                    alertContainer.style.display = 'none';
                                                }, 5000);
                                            });
                                        });
                                    </script>

                                    <link rel="stylesheet"
                                        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

                                    <button class="btn btn-secondary">Add Reminder</button>
                                    <button class="btn btn-success">Check In</button>
                                    <button class="btn btn-warning">Client Calls</button>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- Personal Info Section -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Personal Info</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="personal-info-label">Mobile:</div>
                                    <div class="personal-info-value">{{ $clientsandsubscriptionsandpackages->mobile }}
                                    </div>
                                    <div class="personal-info-label">Second Mobile:</div>
                                    <div class="personal-info-value">
                                        {{ $clientsandsubscriptionsandpackages->second_mobile }}</div>
                                    <div class="personal-info-label">Email:</div>
                                    <div class="personal-info-value">{{ $clientsandsubscriptionsandpackages->email }}</div>
                                    <div class="personal-info-label">Gender:</div>
                                    <div class="personal-info-value">{{ $clientsandsubscriptionsandpackages->gender }}
                                    </div>
                                    <div class="personal-info-label">Diet Restrictions:</div>
                                    <div class="personal-info-value">
                                        {{ $clientsandsubscriptionsandpackages->diet_restrictions }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="personal-info-label">Client Type:</div>
                                    <div class="personal-info-value">
                                        {{ $clientsandsubscriptionsandpackages->client_type }}</div>
                                    <div class="personal-info-label">Birth Date:</div>
                                    <div class="personal-info-value">{{ $clientsandsubscriptionsandpackages->birth_date }}
                                    </div>
                                    <div class="personal-info-label">Notes:</div>
                                    <div class="personal-info-value">{{ $clientsandsubscriptionsandpackages->notes }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="observations" class="profile-section">
                    <!-- Observations content goes here -->
                    <h2>Observations</h2>
                    <p>User's observations go here.</p>
                </div>
                <div id="check-ins" class="profile-section">
                    <!-- Send Check-ins Section -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Send Check-in Request</h6>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('clients.sendCheckIn', ['client' => $clientsandsubscriptionsandpackages->id]) }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="check_in_id">Select Check-in:</label>
                                    <select class="form-control" id="check_in_id" name="check_in_id" required>
                                        <option value="">Select Check-in</option>
                                        @foreach ($check_ins as $check_in)
                                            <option value="{{ $check_in->id }}">{{ $check_in->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Check-in</button>
                            </form>

                        </div>
                    </div>
                    <!-- All Check ins Sent -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Check Ins Sent</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Check-in Name</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($check_ins_sent as $check_in_sent)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $check_in_sent->name }}</td>
                                                <td>{{ $check_in_sent->created_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- All Check Ins Answers -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Check Ins Answers</h6>
                        </div>
                        <div class="card-body">
                            @foreach ($groupedAnswers as $clientCheckInId => $answers)
                                @php
                                    $checkInName = $answers->first()->check_in_name;
                                @endphp
                                <div class="mb-4">
                                    <h5 class="mb-3 text-info">{{ $checkInName }}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    @foreach ($answers as $answer)
                                                        <th scope="col">{{ $answer->question_title }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($answers as $answer)
                                                        <td>{{ $answer->answer }}</td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="measurements" class="profile-section">
                    <!-- Measurements content goes here -->
                    <h2>Measurements</h2>
                    <p>User's measurements go here.</p>
                </div>
                <div id="inbody" class="profile-section">
                    <!-- InBody content goes here -->
                    <h2>InBody</h2>
                    <p>User's InBody data goes here.</p>
                </div>
                <div id="injuries" class="profile-section">
                    <!-- Injuries content goes here -->
                    <h2>Injuries</h2>
                    <p>User's injuries go here.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->


    <script>
        // Add click event listener to sidebar links
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', event => {
                // Prevent default link behavior
                event.preventDefault();

                // Get target section ID from href attribute
                const targetId = event.target.getAttribute('href').slice(1);

                // Hide all profile sections
                document.querySelectorAll('.profile-section').forEach(section => {
                    section.classList.remove('active');
                });

                // Show the target profile section
                document.getElementById(targetId).classList.add('active');
            });
        });
    </script>

    {{-- End Dashboard Content --}}
@endsection
