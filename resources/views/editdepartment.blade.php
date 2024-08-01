@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Department</a>
            <span class="breadcrumb-item active">Set Up Department</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Department</h4>
            <p class="mg-b-0">Edit Department</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            @foreach ($departdata as $departeditdata)

            <form action="/editdepartment/{{$departeditdata->id}}/process" method="POST">
                    @csrf
                    <input type="hidden" id="Employeesdd" name="Employeesdata" >
                    <div class="row">

                        <div class="col-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" required value="{{$departeditdata->name}}">
                        </div>
                        <div class="col-3">
                        <label for="">Department Manager</label>
                        <select class="form-control select2" name="manager">
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $employee->id == $departeditdata->manager ? 'selected' : '' }}>{{ $employee->name }}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="">Select Brand</label>
                        <select class="form-control select2" name="brand">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $departeditdata->brand ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                        @if ($departeditdata->brand == 0)
                        <option value="0" selected>Production</option>
                        @else
                        <option value="0">Production</option>
                        @endif

                        </select>
                    </div>

                    <div class="col-3">
                        <label for="">Select Access</label>
                        <select class="form-control select2" name="access">
                        @php
                            $access = $departeditdata->access;
                            $accessdata = "";
                            if ($access == 0) {
                                $accessdata = "Admin";
                            } elseif ($access == 1) {
                                $accessdata = "Project Manager Or Sales Persons";
                            } elseif ($access == 2) {
                                $accessdata = "QA";
                            } else {
                                $accessdata = "Reporting Screen Only";
                            }
                        @endphp
                        <option value="{{ $access }}" selected>{{ $accessdata }}</option>
                        <option value="0">Admin</option>
                        <option value="1">Project Manager Or Sales Persons</option>
                        <option value="2">QA</option>
                        <option value="3">Reporting Screen Only</option>
                    </select>
                </div>

                    {{-- <div class="col-12 mt-4">
                        <table id="datatable1">
                        <thead>
                            <th>Name</th>
                            <th>Postion</th>
                            <th>Selection</th>
                            <th>Email</th>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                                @if(in_array($employee->id, json_decode($departeditdata->users)))
                                <td><input type="checkbox" name="selectedEmployees[]" checked="true" value="{{$employee->id  }}" class="employee-checkbox"></td>
                                @else
                                <td><input type="checkbox" name="selectedEmployees[]" value="{{$employee->id  }}"  class="employee-checkbox"></td>
                                @endif
                            <td>{{ $employee->email }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <script>
                            // JavaScript code to handle checkbox events and update the array
                            document.addEventListener('DOMContentLoaded', function () {
                                // Array to store selected employee IDs

                                var selectedEmployees = [
                                    @foreach (json_decode($departeditdata->users) as $users)
                                            {{$users}},
                                    @endforeach()
                                ]

                                // Function to update the array when a checkbox is clicked
                                function updateArray(checkbox) {
                                    var employeeId = checkbox.value;

                                    // Check if the checkbox is checked
                                    if (checkbox.checked) {
                                        // Add the employee ID to the array if it's not already present
                                        if (!selectedEmployees.includes(employeeId)) {
                                            selectedEmployees.push(employeeId);
                                            document.getElementById("Employeesdd").value = selectedEmployees
                                        }
                                    } else {
                                        // Remove the employee ID from the array if it's present
                                        var index = selectedEmployees.indexOf(employeeId);
                                        if (index !== -1) {
                                            selectedEmployees.splice(index, 1);
                                            document.getElementById("Employeesdd").value = selectedEmployees
                                        }
                                    }

                                    // Log the updated array (you can replace this with your desired logic)
                                    console.log('Selected Employees:', selectedEmployees);



                                }

                                // Attach event listeners to checkboxes
                                var checkboxes = document.querySelectorAll('.employee-checkbox');
                                checkboxes.forEach(function (checkbox) {
                                    checkbox.addEventListener('change', function () {
                                        updateArray(checkbox);
                                    });
                                });
                            });
                        </script>
                    </div> --}}

                    <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;" >Select Users:</label>
                        @php
                            $usersIndepartment = json_decode($departeditdata->users);
                        @endphp
                        <select class="form-control select2" name="users[]" id="userInput"  multiple="multiple">
                        @foreach ($employees as $client)
                            @php
                                $matched = false;
                            @endphp
                                @foreach ($usersIndepartment as $item)
                                    @if ($client->id == $item)
                                        @php
                                            $matched = true;
                                        @endphp
                                        @break;
                                    @endif
                                @endforeach

                            @if ($matched)
                                <option value="{{ $client->id }}" selected>{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endif

                            <option value="{{ $client->id }}">{{ $client->name }}
                                --
                                @foreach($client->deparment($client->id)  as $dm)
                                <strong>{{ $dm->name }}</strong>
                                @endforeach
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="button"   class="btn btn-info mt-2">Employees</button>
                    </div>
                    <div class="col-12 mt-3">
                        <div id="output" >
                            <ul>
                                @foreach($departeditdata->findEmp($departeditdata->users) as $emp)
                                <li>{{$emp->name}}</li>
                                @endforeach
                                {{-- <input type="hidden" name="usersinarray[]" value="{{$departeditdata->users}}"> --}}
                            </ul>

                        </div>
                    </div>


                    </div>
                    <div class="row mt-3">

                        <div class="col-4">
                            <br>
                            <input type="submit" value="Update" name="" class="btn btn-success mt-2">
                        </div>
                        <div class="col-4">
                                @if (Session::has('Success'))

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('Success') }}</strong>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="alert" aria-label="Close">X</button>
                                </div>

                                @endif
                                @if (Session::has('Error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('Error') }}</strong>
                                    <button type="button" class="btn-danger" data-bs-dismiss="alert" aria-label="Close">X</button>
                                </div>
                                @endif
                        </div>
                    </div>
            </form>
           @endforeach










          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->
        <footer class="br-footer">
          <div class="footer-left">
            <div class="mg-b-2">Copyright &copy; 2017. Crystal Pro. All Rights Reserved.</div>
            <div>Attentively and carefully made by ThemePixels.</div>
          </div>
          <div class="footer-right d-flex align-items-center">
            <span class="tx-uppercase mg-r-10">Share:</span>
            <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-facebook tx-20"></i></a>
            <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Bracket%20Plus,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-twitter tx-20"></i></a>
          </div>
        </footer>
      </div><!-- br-mainpanel -->
      <!-- ########## END: MAIN PANEL ########## -->
@endsection



