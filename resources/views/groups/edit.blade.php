
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Edit Groups</h1>

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

                            <form action="{{ route('groups.update', $group->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Group Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter group name" value="{{ $group->name }}" required>
                                </div>


                                <button type="submit" class="btn btn-primary">Update Group</button>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->




    {{-- End Dashboard Content --}}
@endsection



