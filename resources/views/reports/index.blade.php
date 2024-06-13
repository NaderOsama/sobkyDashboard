
@extends('layouts.app')
@section('content')
    {{-- Start Dashboard Content --}}




                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Team Member Report</h1>

                    <!-- Card for selecting options -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="selectOption">Choose a coach to generate report</label>
                                    <select class="form-control" id="selectOption">
                                        <option value="">-- Choose a coach --</option>
                                        <option value="option1">Nader Osama</option>
                                        <option value="option2">Osama Sobky</option>
                                        <option value="option3">Sherif Mohamed</option>
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="startDate">From date:</label>
                                        <input type="date" class="form-control" id="fromDate" name="fromDate">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="endDate">To date:</label>
                                        <input type="date" class="form-control" id="toDate" name="toDate">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </form>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Team Member</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Achievements</th>
                                            <th>Date</th>
                                            <th>Client profile</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Achievements</th>
                                            <th>Date</th>
                                            <th>Client profile</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>Increased sales by 20%</td>
                                            <td>2024-04-22</td>
                                            <td>
                                                <div class="media align-items-center">
                                                    <img class="img-profile rounded-circle mr-2" src="img/undraw_profile.svg" alt="John Doe" width="50" height="50">
                                                    <div class="media-body">
                                                        <a href="#">John Doe</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>Launched new marketing campaign</td>
                                            <td>2024-04-22</td>
                                            <td>
                                                <div class="media align-items-center">
                                                    <img class="img-profile rounded-circle mr-2" src="img/undraw_profile.svg" alt="Jane Smith" width="50" height="50">
                                                    <div class="media-body">
                                                        <a href="#">Jane Smith</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Michael Johnson</td>
                                            <td>Implemented cost-saving measures</td>
                                            <td>2024-04-22</td>
                                            <td>
                                                <div class="media align-items-center">
                                                    <img class="img-profile rounded-circle mr-2" src="img/undraw_profile.svg" alt="Michael Johnson" width="50" height="50">
                                                    <div class="media-body">
                                                        <a href="#">Michael Johnson</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->



    {{-- End Dashboard Content --}}
@endsection



