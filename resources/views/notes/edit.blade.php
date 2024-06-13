
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Edit Packages</h1>

                    <!-- Card for selecting options -->
                    <div class="card shadow mb-4">
                        <div class="card-body">

                            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                    <textarea class="form-control mb-2" id="note" rows="3" placeholder="Enter your notes..." name="note">{{ $note->note }}</textarea>
                                    <button class="btn btn-primary" type="submit">Save</button>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->



    {{-- End Dashboard Content --}}
@endsection



