
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-3 text-gray-800">All Clients</h1>

                    <!-- Card for selecting options -->
                    <div class="card shadow mb-4">
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

                                function showForm(formId) {
                                    var forms = document.querySelectorAll('.toggle-form');
                                    var buttons = document.querySelectorAll('.toggle-button');

                                    forms.forEach(function(form, index) {
                                        if (form.id === formId) {
                                            form.style.display = form.style.display === 'block' ? 'none' : 'block';
                                            buttons[index].classList.toggle('btn-secondary');
                                            buttons[index].classList.toggle('btn-primary');
                                        } else {
                                            form.style.display = 'none';
                                            buttons[index].classList.remove('btn-primary');
                                            buttons[index].classList.add('btn-secondary');
                                        }
                                    });
                                }
                            </script>

                            <div class="row justify-content-around mb-2">
                                <button type="button" class="btn btn-secondary toggle-button" onclick="showForm('personal-info-form')">Create New Client</button>
                                <button type="button" class="btn btn-secondary toggle-button" onclick="showForm('subscription-form')">Create Subscriptions</button>
                            </div>


                            <div id="personal-info-form" class="toggle-form card" style="display: none;">
                                <div class="card-header">
                                    New Client
                                </div>
                                <div class="card-body">
                                    <!-- Personal Information Form -->
                                    <form action="{{ route('clients.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Name</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Client Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mobile">Mobile</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Phone Number" required>
                                                </div>
                                                <script>
                                                    var input = document.querySelector("#mobile");
                                                    window.intlTelInput(input, {
                                                        separateDialCode: true,
                                                        excludeCountries: ["in", "il"],
                                                        preferredCountries: ["eg", "su", "us", "fr"]
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="second_mobile">Second Mobile</label>
                                                    <input type="text" class="form-control" id="second_mobile" name="second_mobile" placeholder="Enter Phone Number (optional)">
                                                </div>
                                                <script>
                                                    var input = document.querySelector("#second_mobile");
                                                    window.intlTelInput(input, {
                                                        separateDialCode: true,
                                                        excludeCountries: ["in", "il"],
                                                        preferredCountries: ["eg", "su", "us", "fr"]
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="birth_date">Birth Date</label>
                                                    <input type="date" class="form-control" id="birth_date" name="birth_date">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="diet_restrictions">Diet Restrictions</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="diet_restrictions" name="diet_restrictions" required>
                                                        <option value="">Please Select</option>
                                                        <option value="Muslim">Muslim</option>
                                                        <option value="Christian">Christian</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Client Email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="job_code">Job</label>
                                                    <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter Client Job">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="group_id">Client:</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="group_id" name="group_id" required>
                                                        <option value="">Select Group</option>
                                                        @forelse ($groups as $group)
                                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                        @empty
                                                            <option value="" disabled>No Groups found</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client_type">Client Type</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="client_type" name="client_type" required>
                                                        <option value="">Select Client Type</option>
                                                        <option value="Online">Online</option>
                                                        <option value="Offline">Offline</option>
                                                        <option value="Online + Offline">Online + Offline</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="referred_by">Referred By:</label>
                                                    <select class="form-control" id="referred_by" name="referred_by">
                                                        <option value="Website">Website</option>
                                                        <option value="Facebook Ads">Facebook Ads</option>
                                                        <option value="Instagram Ads">Instagram Ads</option>
                                                        <option value="Facebook">Facebook</option>
                                                        <option value="Instagram">Instagram</option>
                                                        <option value="Friend">Friend</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="code">Code</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" required>
                                                </div>
                                            </div>
                                        </div>
                                        @if( Auth::user()->role == 'admin' )
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_id">Coach:</label><span class="text-danger">&nbsp;*</span>
                                                        <select class="form-control" id="user_id" name="user_id" required>
                                                            <option value="">Select Coach</option>
                                                            @forelse ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @empty
                                                                <option value="" disabled>No Coach found</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="notes">Notes</label>
                                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create New Client</button>
                                    </form>
                                </div>

                            </div>

                            <div id="subscription-form" class="toggle-form card" style="display: none;">
                                <div class="card-header">
                                    New Subscription
                                </div>
                                <div class="card-body">
                                    <!-- Subscription Form -->
                                    <form action="{{ route('subscriptions.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client_id">Client:</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="client_id" name="client_id" required>
                                                        <option value="">Select Client</option>
                                                        @forelse ($clientsNotSubscribed as $clientNotSubscribed)
                                                            <option value="{{ $clientNotSubscribed->id }}">{{ $clientNotSubscribed->name }}</option>
                                                        @empty
                                                            <option value="" disabled>No clients found with status 'not subscribed'</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="package_id">Package:</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="package_id" name="package_id" required>
                                                        <option value="">Select Package</option>
                                                        @foreach ($packages as $package)
                                                            <option value="{{ $package->id }}">{{ $package->name }} - {{ $package->duration }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="start_at">Start Date</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="datetime-local" class="form-control" id="start_at" name="start_at" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="check_in_id">Select Check-in:</label>
                                                    <select class="form-control" id="check_in_id" name="check_in_id">
                                                        <option value="">Select Initial Send Check In</option>
                                                        @foreach($check_ins as $check_in)
                                                            <option value="{{ $check_in->id }}">{{ $check_in->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_method">Payment Method</label><span class="text-danger">&nbsp;*</span>
                                                    <select class="form-control" id="payment_method" name="payment_method" onchange="toggleFields()" required>
                                                        <option value="">Select Payment Method</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Wallet Cash">Wallet Cash</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                        <option value="Kashier">Kashier</option>
                                                        <option value="Online">Online</option>
                                                        <option value="Fawry">Fawry</option>
                                                        <option value="InstaPay">InstaPay</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transaction_number">Transaction Number</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="transaction_number" name="transaction_number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transaction_date">Transaction Date</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="date" class="form-control" id="transaction_date" name="transaction_date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="PhoneField" style="display: none;">
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="from_phone">From Phone</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="from_phone" name="from_phone">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="to_phone">To Phone</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="to_phone" name="to_phone">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row" id="transactionTypeField" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="transaction_type">Transaction Type</label><span class="text-danger">&nbsp;*</span>
                                                    <input type="text" class="form-control" id="transaction_type" name="transaction_type">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="notes">Notes</label><span class="text-danger">&nbsp;*</span>
                                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Subscriptions</button>
                                    </form>
                                    <script>
                                        function toggleFields() {
                                            var paymentMethod = document.getElementById('payment_method').value;
                                            var PhoneField = document.getElementById('PhoneField');
                                            var transactionTypeField = document.getElementById('transactionTypeField');

                                            if (paymentMethod === 'Wallet Cash') {
                                                PhoneField.style.display = 'flex';
                                            }else if (paymentMethod === 'Bank Transfer') {
                                                transactionTypeField.style.display = 'flex';
                                                PhoneField.style.display = 'none';
                                            } else {
                                                PhoneField.style.display = 'none';
                                                transactionTypeField.style.display = 'none';
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>


<!-- My Clients -->
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
                        <th>Transaction Number</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        @foreach ($client->subscriptions as $subscription)
                            <tr>
                                <td>{{ $client->code }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ optional($client->group)->name }}</td>
                                <td>{{ $client->mobile }}</td>
                                <td>{{ optional($subscription->package)->name }}</td>
                                <td>{{ $subscription->start_at->format('Y-m-d') }}</td>
                                <td>{{ $subscription->transaction_number ?: 'None' }}</td>
                                <td>{{ $subscription->created_by }}</td>
                                <td>{{ $client->status }}</td>
                                <td>
                                    <a href="{{ route('clients.profile', $client->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="10">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


                </div>
                <!-- /.container-fluid -->




    {{-- End Dashboard Content --}}
@endsection



