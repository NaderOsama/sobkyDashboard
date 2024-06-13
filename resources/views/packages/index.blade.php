
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">All Packages</h1>

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
                            </script>


                            <form action="{{ route('packages.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Package Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter package name" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter package description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="duration">Duration:</label>
                                    <select class="form-control" id="duration" name="duration" required>
                                        <option value="">Choose duration</option>
                                        <option value="3 Month">3 Month</option>
                                        <option value="6 Month">6 Month</option>
                                        <option value="12 Month">12 Month</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter price" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="holdLimitDays">Hold Limit (Days):</label>
                                    <input type="number" class="form-control" id="holdLimitDays" name="hold_limit_days" placeholder="Enter hold limit (optional)">
                                </div>

                                <button type="submit" class="btn btn-primary">Create Package</button>
                            </form>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Packages</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Package Name</th>
                                            <th>Description</th>
                                            <th>Duration</th>
                                            <th>Price</th>
                                            <th>Hold Limit (Days)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($packages as $package)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ implode(' ', array_slice(explode(' ', $package->description), 0, 10)) }} ..</td>
                                                <td>{{ $package->duration }}</td>
                                                <td>${{ $package->price }}</td>
                                                <td>{{ $package->hold_limit_days ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->




    {{-- End Dashboard Content --}}
@endsection



