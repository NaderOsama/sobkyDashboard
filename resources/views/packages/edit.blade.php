
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
                            <form action="{{ route('packages.update', $package->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Package Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $package->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $package->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Duration:</label>
                                    <select class="form-control" id="duration" name="duration" required>
                                        <option value="{{ $package->duration }}">{{ $package->duration }}</option>
                                        <option value="3 Month">3 Month</option>
                                        <option value="6 Month">6 Month</option>
                                        <option value="12 Month">12 Month</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $package->price }}" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="holdLimitDays">Hold Limit (Days):</label>
                                    <input type="number" class="form-control" id="holdLimitDays" name="hold_limit_days" value="{{ $package->hold_limit_days }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Package</button>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

  

    {{-- End Dashboard Content --}}
@endsection



