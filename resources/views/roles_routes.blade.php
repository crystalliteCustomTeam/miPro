    {{-- <ul>
        @foreach($routes as $route)

        @if ($route->methods()[0] == "GET")
            <li>{{ $route->methods()[0] }}</li>
            <li>{{ $route->uri() }}</li>
        @endif

        @endforeach
    </ul> --}}



    @extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

    @section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Authorizations</a>
            <span class="breadcrumb-item active">Set Up Authorizations</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Authorizations</h4>
            <p class="mg-b-0">Authorizations</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="/assign/permissions/process" method="POST">
            @csrf
            <input type="hidden" name="Employeesdd" id="Employeesdd">
            {{-- <input type="hidden" id="Employeesdd" name="Employeesdata" > --}}
            <div class="row">

                <div class="col-3">
                    <label for="">Select Access</label>
                    <select class="form-control select2" name="access">
                        <option value="0">Admin</option>
                        <option value="1">Project Manager Or Sales Persons</option>
                        <option value="2">QA</option>
                        <option value="3">Reporting Screen Only</option>

                    </select>
                </div>
              <div class="col-12 mt-4">
                <table id="datatable1">
                  <thead>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Action</th>
                    {{-- <th>Check</th> --}}
                  </thead>
                  <tbody>
                    @foreach($allroutes as $route)
                    @if ($route->Method == "GET")
                        <tr>
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->Route }}</td>
                        {{-- <td>{{ $route->getActionName() }}</td> --}}
                        <td><input type="checkbox" name="selectedEmployees[]"  value="{{ $route->Route }}" class="employee-checkbox"></td>
                        </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
                <script>
                    // JavaScript code to handle checkbox events and update the array
                    document.addEventListener('DOMContentLoaded', function () {
                        // Array to store selected employee IDs
                        var selectedEmployees = [];

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
            </div>




            <div class="col-12 mt-3">
                <div id="output" ></div>
            </div>






















            </div>
            <div class="row mt-3">

                <div class="col-4">
                    <br>
                    <input type="submit" value="Create" name="" class="btn btn-success mt-2">
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
