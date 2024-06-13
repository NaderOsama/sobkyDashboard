
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-gray-800">All Clients</h1>


        <!-- My Clients -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Clients</h6>
            </div>
            <div class="card-body">
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Group</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
         <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td>{{ $client->code }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ optional($client->group)->name }}</td>
                    <td>{{ $client->mobile }}</td>
                    <td>{{ $client->status }}</td>
                    <td>
                        <a href="{{ route('clients.profile', $client->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No clients found.</td>
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



