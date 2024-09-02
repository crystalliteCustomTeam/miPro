<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">
    <title>Crystal Pro Panel</title>
    <!--sweetalert2-->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">


    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.dark.css') }}">
  </head>

  <body>

@php
if($superUser == 0){
   $ID = $LoginUser->id;
   $Name = $LoginUser->goodName;
   $Email = $LoginUser->userEmail;
   $themes = 0;


}else{
    // echo("<pre>");
    // print_r($LoginUser[0]);
    // die();
  $ID = $LoginUser[0]->id;
  $Name = $LoginUser[0]->name;
  $Email = $LoginUser[0]->email;
  $themes =  (int)$theme;
}

@endphp


<!-- ########## START: HEAD PANEL ########## -->
<div class="br-section-wrapper">
    <div class="row">
        <div class="col-6 mt-3" >
            <h2 style="color: white">Client Name: {{$clients[0]->name}}</h2>
            <h5>Email: {{$clients[0]->email}}</h5>
            <h6>Brand: {{$clients[0]->projectbrand->name}}</h6>
        </div>
        <div class="col-6 mt-3" >
            @if ($projectcount > 0)
                <label for="" style="color: white">Projects:</label>
                <ul>
                    @foreach ($projects as $project)
                    <li style="color: white">
                        {{$project->name}}--PM:
                        @if (isset($project->EmployeeName->name) and $project->EmployeeName->name !== null)
                        {{$project->EmployeeName->name}}
                        @else
                        <label style="color: red">User Deleted</label>
                        @endif
                    </li>
                    @endforeach
                </ul>
            @else
                {{-- Project is not created --}}
            @endif
        </div>
        @if ($qaformcount > 0)
             @if (isset($qaformlasts[0]->status) and $qaformlasts[0]->status !== null)
                <div class="col-4 mt-3" >
                    <h5 style="color: white">Status: {{$qaformlasts[0]->status}}</h5>
                </div>
            @else
            @endif

            @if (isset($qaformlasts[0]->client_satisfaction) and $qaformlasts[0]->client_satisfaction !== null)
                <div class="col-4 mt-3" >
                    <h5 style="color: white">Remarks: {{$qaformlasts[0]->client_satisfaction}}</h5>
                </div>
            @else
            @endif

            @if (isset($qaformlasts[0]->status_of_refund) and $qaformlasts[0]->status_of_refund !== null)
                <div class="col-4 mt-3" >
                    <h5 style="color: white">Expected Refund: {{$qaformlasts[0]->status_of_refund}}</h5>
                </div>
            @else
            @endif

            @if (isset($qaformlasts[0]->Refund_Request_summery) and $qaformlasts[0]->Refund_Request_summery !== null)
                <div class="col-12 mt-3" >
                    <h4 style="color: white">Summery:</h4>
                    <p> {{$qaformlasts[0]->Refund_Request_summery}}</p>
                </div>
            @else
            @endif
        @endif

        <div class="col-12 mt-3">
            <h4 style="color: white">Payments:</h4>
        </div>
        <div class="col-12 mt-3" >
            @if ($clientpaymentscount > 0)
            <table id="" class="table-dark-wrapper table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Project</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Nature</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Gateway</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Date</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Future Date</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Sales Person</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Total Amount</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Paid</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Status</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($clientpayments as $clientpayment)
                    <tr role="row" class="odd">
                      <td tabindex="0" class="sorting_1">{{$clientpayment->paymentprojectName->name}}</td>
                      <td>{{$clientpayment->paymentNature}}</td>
                      <td>{{$clientpayment->Payment_Gateway}}</td>
                      <td>{{$clientpayment->paymentDate}}</td>
                      <td>{{$clientpayment->futureDate}}</td>
                      <td>{{$clientpayment->saleEmployeesName->name}}</td>
                      <td>${{$clientpayment->TotalAmount}}</td>
                      <td>${{$clientpayment->Paid}}</td>
                      <td>${{$clientpayment->refundStatus}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
               <p>No Payment Received</p>
            @endif
        </div>


        @if ($projectcount > 0)
        <div class="col-12 mt-3">
            <h4 style="color: white">Production:</h4>
        </div>
        @endif

        @if ($projectcount > 0)
            @foreach ($projects as $project)
            <div class="col-6 mt-3" >
                <h6>{{$project->name}}</h6>
                <table id="" class="table-dark-wrapper table-hover">
                    <thead>
                    <tr role="row">
                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Depart</th>
                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Assignee</th>
                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Services</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        @if (isset($project->ProjectProduction->DepartNameinProjectProduction->name) and $project->ProjectProduction->DepartNameinProjectProduction->name !== null)
                        <td tabindex="0" class="sorting_1">{{$project->ProjectProduction->DepartNameinProjectProduction->name}}</td>
                        @else
                            <td><p style="color: red">No Production Assigned</p></td>
                        @endif

                        @if (isset($project->ProjectProduction->EmployeeNameinProjectProduction->name) and $project->ProjectProduction->EmployeeNameinProjectProduction->name !== null)
                        <td>{{ $project->ProjectProduction->EmployeeNameinProjectProduction->name }}</td>
                        @else
                            <td><p style="color: red">User Deleted or No Production Assigned</p></td>
                        @endif
                        @if (isset($project->ProjectProduction->services) and $project->ProjectProduction->services !== null)
                        <td>{{$project->ProjectProduction->services}}</td>
                        @else
                            <td><p style="color: red">No Production Assigned</p></td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
            @endforeach

        @else
        @endif

        <div class="col-12 mt-3">
            <h4 style="color: white">QA Data:</h4>
        </div>
        <div class="col-12 mt-3" >
            @if ($qaformcount > 0)
            <table id="datatable1" class="table-dark-wrapper table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Project</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Department</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Status</th>
                    {{-- <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Last Communication</th> --}}
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Summery</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Issue</th>
                    {{-- <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Description</th> --}}
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Date</th>
                    <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">View</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($qaforms as $qaform)
                    <tr role="row" class="odd">
                      <td tabindex="0" class="sorting_1">{{$qaform->Project_Name->name}}</td>
                    @if (isset($qaform->GETDEPARTMENT->DepartNameinProjectProduction->name) and $qaform->GETDEPARTMENT->DepartNameinProjectProduction->name !== null)
                        <td>{{$qaform->GETDEPARTMENT->DepartNameinProjectProduction->name}}</td>
                    @else
                        <td><p style="color: red">Production Deleted</p></td>
                    @endif
                      <td>{{$qaform->status}}</td>
                      {{-- <td>{{$qaform->last_communication}}</td> --}}
                      <td>{{$qaform->Refund_Request_summery}}</td>

                            @foreach ($qaform->QA_META_DATA($qaform->qaformID) as $meta)
                            @php
                            $qa_issues = json_decode($meta->issues)
                            @endphp
                            <td>
                                @foreach ($qa_issues as $issue)
                                    <ul>
                                        <li>{{$issue}}</li>
                                    </ul>
                                @endforeach
                            </td>
                            {{-- <td>{{ $meta->Description_of_issue }}</td> --}}
                            @endforeach
                            <td>{{$qaform->created_at}}</td>
                            <td><a href="/client/project/qaform/view/{{$qaform->id}}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/3094/3094851.png" alt="" style="filter: invert(1);" > View </button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No QA Data</p>
            @endif
        </div>
    </div>










  </div><!-- br-section-wrapper -->

    {{-- <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../lib/moment/min/moment.min.js"></script>
    <script src="../lib/peity/jquery.peity.min.js"></script>

    <script src="../js/bracket.js"></script>
     --}}
     <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
     <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
     <script src="{{ asset('lib/moment/min/moment.min.js') }}"></script>
     <script src="{{ asset('lib/peity/jquery.peity.min.js') }}"></script>
     <script src="{{ asset('lib/rickshaw/vendor/d3.min.js') }}"></script>
     <script src="{{ asset('lib/rickshaw/vendor/d3.layout.min.js') }}"></script>
     <script src="{{ asset('lib/rickshaw/rickshaw.min.js') }}"></script>
     <script src="{{ asset('lib/jquery.flot/jquery.flot.js')}}"></script>
     <script src="{{ asset('lib/jquery.flot/jquery.flot.resize.js') }}"></script>
     <script src="{{ asset('lib/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
     <script src="{{ asset('lib/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
     <script src="{{ asset('lib/echarts/echarts.min.js')}}"></script>
     <script src="{{ asset('lib/select2/js/select2.full.min.js') }}"></script>
     <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
     <script src="{{ asset('lib/gmaps/gmaps.min.js')}}"></script>

     <script src="{{ asset('js/bracket.js') }}"></script>
     <script src="{{ asset('js/map.shiftworker.js') }}"></script>
     <script src="{{ asset('js/ResizeSensor.js') }}"></script>
     <script src="{{ asset('js/dashboard.js') }}"></script>
     <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
     <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
     <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
     <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

     <script>
       $(function(){
         'use strict';

         $('#datatable1').DataTable({
             drawCallback:function(){
                 $('.paginate_button ').on('click',()=>{
                     setwhenweset();
                 });
             }
         });
       });

       $(document).ready(function() {
         $('#select2forme,#frontsale,#projectmanager,.select2').select2();
       });

       function setwhenweset(){
         $(document).ready(function() {
         $('#select2forme,#frontsale,#projectmanager,.select2').select2();

       });
       }


     </script>

 <script>
     $(document).ready(function(){
        $("#fetchstripe").click(function(event){
            event.preventDefault();
            let transactionID = $("#transactionid");
            $.ajax({
                 url:"/api/fetchStripe/transaction",
                 type:"get",
                 data:{
                     "ID":transactionID.val()
                 },
                 beforeSend:(()=>{
                     transactionID.attr('disabled','disabled');
                     $("#fetchstripe").text("Data Fetching Please Wait");
                     $("#fetchstripe").attr('disabled','disabled');
                 }),
                 success:((Response)=>{
                     results = JSON.parse(Response);
                     if(results.status != 200){
                         alert(results.message);
                     }
                     else{
                         let ClientPaidAmount =  results.message.amount_captured;
                         let cardBrand = results.message.payment_method_details.card.brand;
                         $("#amountPaid").val(ClientPaidAmount / 100);

                         var newOption = new Option(cardBrand, cardBrand);

                         // Append the new option to the select element
                         $('#clientcard').append(newOption);

                         // Set the newly added option as selected
                         $(newOption).prop('selected', true);

                     }


                     transactionID.removeAttr('disabled');
                     $("#fetchstripe").text("Fetch Record");
                     $("#fetchstripe").removeAttr('disabled');
                 }),
                 error:(()=>{
                     alert("Error Found Please Referesh Window And Try Again !")
                 })

            });
        });
    });

    </script>








     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  </body>
</html>
