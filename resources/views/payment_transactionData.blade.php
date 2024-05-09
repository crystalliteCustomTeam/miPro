@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Client Payment</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client Payment</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
                <form action="/client/payment" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="row">
                        <div class="col-6 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Card Brand:</label>
                            <label for="" style="font-size:150%;">{{$details->payment_method_details->card->brand}}</label>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Transaction ID:</label>
                            <label for="" style="font-size:150%;">{{$details->id}}</label>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Payment Date:</label>
                            <label for="" style="font-size:150%;">{{ date('Y-m-d',$details->created) }}</label>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Client Paid:</label>
                            <label for="" style="font-size:150%;">${{$details->amount_captured/100}}</label>
                        </div>
                        {{-- <div class="col-12 mt-3">
                            <input type="text" class="form-control mb-3 " id="transactionid" placeholder="Transaction ID">
                            <button class="btn btn-primary" id="fetchstripe">Fetch From Stripe</button>
                        </div> --}}

                        <div class="col-5 mt-2">
                            <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                            <select class="form-control select2" required name="clientID"  id="client-dropdown">
                                @foreach ($clients as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}}
                                        --
                                        {{$item->projectbrand->name}}
                                    </option>
                                @endforeach
                        </select>
                        </div>
                        <div class="col-5 mt-2">
                            <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                            <select  class="form-control" name="project" id="project-dropdown">
                            <option value="">Select Project</option>
                        </select>
                        </div>
                        <div class="col-1 mt-5">
                            <button class="btn btn-primary" id="searchprojectdata">Search</button>
                        </div>

                        <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Payment Nature:</label>
                        <select class="form-control select2" required name="paymentNature"  id="paymentNaturetype" onchange="paymentnature()">
                                <option value="Select">Select</option>
                                <option value="New Lead">New Lead</option>
                                <option value="New Sale">New Sale</option>
                                <option value="Renewal Payment">Renewal Payment</option>
                                <option value="Recurring Payment">Recurring Payment</option>
                                <option value="Small Payment">Small Payment</option>
                                <option value="Upsell">Upsell</option>
                                <option value="Remaining">Remaining</option>
                                <option value="One Time Payment">One Time Payment</option>
                                <option value="ChargeBack Won">ChargeBack Won</option>
                        </select>
                        </div>
                        <div class="col-4 mt-3" id="chargingpackage" style="display: none">
                            <label for="" style="font-weight:bold;">Charging Plan</label>
                            <select class="form-control"  name="ChargingPlan">
                                <option value="One Time Payment">One Time Payment</option>
                                <option value="Monthly">Monthly</option>
                                <option value="2 Months">2 Months</option>
                                <option value="3 Months">3 Months</option>
                                <option value="4 Months">4 Months</option>
                                <option value="5 Months">5 Months</option>
                                <option value="6 Months">6 Months</option>
                                <option value="7 Months">7 Months</option>
                                <option value="8 Months">8 Months</option>
                                <option value="9 Months">9 Months</option>
                                <option value="10 Months">10 Months</option>
                                <option value="11 Months">11 Months</option>
                                <option value="12 Months">12 Months</option>
                                <option value="12 Months">2 Years</option>
                                <option value="12 Months">3 Years</option>
                            </select>
                        </div>
                        <div class="col-4 mt-3" id="paymentMode" style="display: none">
                            <label for="" style="font-weight:bold;">Payment Mode</label>
                            <select class="form-control"  name="paymentModes">
                                <option value="One Time Payment">One Time Payment</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Recurring">Recurring</option>
                            </select>
                        </div>
                        <script>
                            function paymentnature(){
                            var paymentNature = document.getElementById("paymentNaturetype").value;
                            var chargingpackage = document.getElementById("chargingpackage");
                            var paymentMode = document.getElementById("paymentMode");

                            if (paymentNature === "New Lead" || paymentNature === "New Sale" || paymentNature === "Upsell"){
                                chargingpackage.style.display = 'block';
                                paymentMode.style.display = 'block';
                            }else{
                                chargingpackage.style.display = 'none';
                                paymentMode.style.display = 'none';
                            }
                            }
                        </script>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Platform:</label>
                            <select class="form-control select2"  required name="platform">
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="Cold Calling">Cold Calling</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Referral">Referral</option>
                                <option value="SMM">SMM</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="PayPall">PayPall</option>
                            </select>
                        </div>
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Card Brand:</label>
                            <select  class="form-control " required name="cardBrand" >
                                <option value="{{$details->payment_method_details->card->brand}}" selected>{{$details->payment_method_details->card->brand}}</option>
                                <option value="AMEX">AMEX</option>
                                <option value="DISCOVER">DISCOVER</option>
                                <option value="MasterCard">MasterCard</option>
                                <option value="VISA">VISA</option>
                                <option value="WIRE">WIRE</option>
                                <option value="PayPall">PayPall</option>
                            </select>
                        </div> --}}
                        <input type="hidden" name="cardBrand" value="{{$details->payment_method_details->card->brand}}">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Gateway</label>
                            <select  class="form-control select2" required name="paymentgateway" id="paymentgateway" onchange="bankfield()">
                                <option value="Stripe">Stripe</option>

                            </select>
                        </div>
                        <div class="col-4 mt-3" id="bankUpload" style="display: none">
                            <label for="" style="font-weight:bold;">Bank Wire(Upload):</label>
                            <input type="file" name="bankWireUpload" id="bankWireUpload" class="form-control">
                        </div>
                        <script>
                            function bankfield(){
                            var paymentgateway = document.getElementById("paymentgateway").value;
                            var bankWireUpload = document.getElementById("bankUpload");

                            if (paymentgateway === "Bank Wire"){
                                bankWireUpload.style.display = 'block';
                            }else{
                                bankWireUpload.style.display = 'none';
                            }
                            }
                        </script>
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Transaction ID:</label>
                            <input type="text" class="form-control" required name="transactionID" value="{{$details->id}}">
                        </div> --}}
                        <input type="hidden" class="form-control" required name="transactionID" value="{{$details->id}}">
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Date:</label>
                            <input type="date" class="form-control" required name="paymentdate" value="{{ date('Y-m-d',$details->created) }}">

                        </div> --}}
                        <input type="hidden" class="form-control" required name="paymentdate" value="{{ date('Y-m-d',$details->created) }}">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Next Payment Date:</label>
                            <input type="date" class="form-control"  name="nextpaymentdate">
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;" >Sale Person:</label>
                            <select class="form-control select2" required name="saleperson" id="salesperson">
                            @foreach ($employee as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;" >Account Manager:</label>
                            <select class="form-control select2" required name="accountmanager" id="projectmanager">
                            @foreach ($employee as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Total Amount:</label>
                            <input type="text" class="form-control" required value="" onkeypress="return /[0-9]/i.test(event.key)" name="totalamount">
                        </div>
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Client Paid</label>
                            <input  type="text" class="form-control" required value="{{$details->amount_captured/100}}" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid">
                        </div> --}}
                        <input  type="hidden" class="form-control" required value="{{$details->amount_captured/100}}" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Type</label>
                            <select class="form-control select2" name="paymentType" id="paymentType" required onchange="displayfields()">
                                <option value="Select">Select</option>
                                <option value="Split Payment">Split Payment</option>
                                <option value="Full Payment">Full Payment</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3" id="numberofsplits" style="display: none;">
                            <label for="" style="font-weight:bold;">Number of Split:</label>
                            <select class="form-control" id="selectionField" onchange="toggleFields()" name="numOfSplit">
                                <option value="0">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        @for ($i = 1; $i <= 4; $i++)
                            <div id="fieldsSet{{$i}}" class="col-6 mt-3" style="display: none;">
                                    <label for="" style="font-weight:bold;">{{$i}}: Project Manager (If Split):</label><br>
                                    <select class="form-control select2" name="shareProjectManager[]">
                                        <option value="0">Select</option>
                                        @foreach ($employee as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}
                                                --
                                                @foreach($client->deparment($client->id)  as $dm)
                                                <strong>{{ $dm->name }}</strong>
                                                @endforeach
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="" style="font-weight:bold;">Share Amount:</label>
                                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]">
                            </div>
                        @endfor

                        <script>
                            function displayfields() {
                                var paymentType = document.getElementById("paymentType").value;
                                var selection = document.getElementById("selectionField").value;
                                var numberofsplits = document.getElementById("numberofsplits");

                                if (paymentType === "Split Payment") {
                                    numberofsplits.style.display = 'block';
                                } else {
                                    numberofsplits.style.display = 'none';
                                    for (var i = 1; i <= 4; i++) {
                                    var fieldsSet = document.getElementById("fieldsSet" + i);
                                    fieldsSet.style.display = i <= selection ? "none" : "none";
                                }
                                }
                            }

                            function toggleFields() {
                                var selection = document.getElementById("selectionField").value;
                                for (var i = 1; i <= 4; i++) {
                                    var fieldsSet = document.getElementById("fieldsSet" + i);
                                    fieldsSet.style.display = i <= selection ? "block" : "none";
                                }
                                setwhenweset();
                            }
                        </script>


                        <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Description:</label>
                            <textarea required name="description" class="form-control" id="" cols="30" rows="10">{{$details->description}}</textarea>
                        </div>


                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <br>
                            <input type="submit" value="Create"  name="" class="btn btn-success mt-2">

                        </div>
                        <div class="col-9">
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




          </div>
        </div>




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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {

                $('#client-dropdown').on('change', function () {
                    var idCountry = this.value;
                    $("#project-dropdown").html('');
                    $.ajax({
                        url:"/api/fetch-projects",
                        type: "get",
                        data: {
                            country_id: idCountry,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.projects == ""){
                                $('#project-dropdown').html('<option value="">-- No Project Exist--</option>');
                            }else{
                                $.each(result.projects, function (key, value) {
                                $("#project-dropdown").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                                });
                                $('#city-dropdown').html('<option value="">-- Select Project --</option>');

                            }
                        }
                    });
                });


                $("#searchprojectdata").click(function(event){
                    event.preventDefault();
                    let projectID = $("#project-dropdown");
                    $.ajax({
                            url:"/api/fetch-projectdata",
                            type:"get",
                            data:{
                                "state_id":projectID.val()
                            },
                            beforeSend:(()=>{
                                projectID.attr('disabled','disabled');
                                $("#searchprojectdata").text("Searching...");
                                $("#searchprojectdata").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                    let Projectmanager =  Response.pmname;
                                    let ProjectmanagerID =  Response.pmid;
                                    let salesperson = Response.clientname;
                                    let salespersonID = Response.clientid;
                                    var newOption = new Option(Projectmanager, ProjectmanagerID);

                                    // Append the new option to the select element
                                    $('#projectmanager').append(newOption);
                                    // Set the newly added option as selected
                                    $(newOption).prop('selected', true);

                                    var newOption1 = new Option(salesperson, salespersonID);
                                    $('#salesperson').append(newOption1);
                                    $(newOption1).prop('selected', true);

                            projectID.removeAttr('disabled');
                            $("#searchprojectdata").text("Search");
                            $("#searchprojectdata").removeAttr('disabled');


                            }),
                            error:(()=>{
                                alert("Error Found Please Referesh Window And Try Again !")

                                projectID.removeAttr('disabled');
                                $("#searchprojectdata").text("Search");
                                $("#searchprojectdata").removeAttr('disabled');
                            })

                    });
                });


            });
        </script>



@endsection
