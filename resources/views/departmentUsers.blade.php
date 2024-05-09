@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Company</a>
            <span class="breadcrumb-item active">Manage Companies</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Department User Selection:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <form action="/setupdepartment/setusers/{{$department[0]->id}}" method="POST">
            @csrf
                <input type="hidden" name="Employeesdd" id="Employeesdd">
                <div class="row">
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Department Name:</label><br>
                        <label for="" style="font-size:150%;">{{$department[0]->name }}</label>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Brand Name:</label><br>
                        @if($department[0]->brand == 0)
                            <label for="" style="font-size:150%;">Production</label>
                        @else
                            <label for="" style="font-size:150%;">{{$department[0]->departbrand->name }}</label>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Manager Name:</label><br>
                        <label for="" style="font-size:150%;">{{$department[0]->UserName->name }}</label>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;" >Select Users:</label>
                        <select class="form-control select2" name="users[]" id="userInput">
                        @foreach ($employees as $client)
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
                        <button type="button" onclick="storeInput()"  class="btn btn-info mt-2">Store Input</button>
                    </div>

                    <script>
                        // Array to store selected employee IDs
                        var selectedEmployees = [];

                        function storeInput() {
                            var employeeId = document.getElementById("userInput").value;

                            if (!selectedEmployees.includes(employeeId)) {
                                selectedEmployees.push(employeeId);
                            } else {
                                var index = selectedEmployees.indexOf(employeeId);
                                if (index !== -1) {
                                    selectedEmployees.splice(index, 1);
                                }
                            }

                            document.getElementById("Employeesdd").value = selectedEmployees.join(', ');
                            console.log('Selected Employees:', selectedEmployees);
                            displayArray();
                        }

                        function displayArray() {
                            var outputDiv = document.getElementById("output");
                            outputDiv.innerHTML = '';
                            var responsesCount = 0; // Variable to keep track of received responses

                            selectedEmployees.forEach(function(value, index) {
                                $.ajax({
                                    url: "/api/fetch-username",
                                    type: "get",
                                    data: {
                                        "state_id": value
                                    },
                                    success: (Response) => {
                                        let empname =  Response.pmname;
                                        var p = document.createElement('p');
                                        p.textContent = 'User ' + (index + 1) + ': ' + empname;
                                        outputDiv.appendChild(p);
                                        responsesCount++; // Increment the count of received responses

                                        // Check if all responses have been received
                                        if (responsesCount === selectedEmployees.length) {
                                            // If all responses are received, sort paragraphs by index
                                            var paragraphs = Array.from(outputDiv.querySelectorAll('p'));
                                            paragraphs.sort((a, b) => {
                                                return parseInt(a.textContent.split(':')[0].split(' ')[1]) - parseInt(b.textContent.split(':')[0].split(' ')[1]);
                                            });
                                            // Append sorted paragraphs to output div
                                            paragraphs.forEach(paragraph => outputDiv.appendChild(paragraph));
                                        }
                                    }
                                });
                            });
                        };


                    </script>




                    <div class="col-12 mt-3">
                        <div id="output" ></div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" value="Create" name="" class="btn btn-success mt-2">
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
