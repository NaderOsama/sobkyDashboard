
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">All Groups</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4"> 
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Groups</h6>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groups as $group)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $group->name }}</td>
                                                <td>
                                                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display: inline;">
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



