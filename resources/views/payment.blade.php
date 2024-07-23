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
            <input type="hidden" name="project" value=" {{$projectmanager[0]->id }} ">
            <input type="hidden" name="clientID" value=" {{$projectmanager[0]->ClientName->id}} ">
            @if (isset($projectmanager[0]->EmployeeName->id) and $projectmanager[0]->EmployeeName->id !== null)
            <input type="hidden" name="pmID" value=" {{$projectmanager[0]->EmployeeName->id}} ">
            @else
            {{-- <input type="hidden" name="pmID" value=" {{$projectmanager[0]->EmployeeName->id}} "> --}}
            @endif
            <input type="hidden" name="brandID" value=" {{$projectmanager[0]->ClientName->projectbrand->id}} ">

            <div class="row">
                {{-- <div class="col-12 mt-3">
                    <input type="text" class="form-control mb-3 " id="transactionid" placeholder="Transaction ID">
                    <button class="btn btn-primary" id="fetchstripe">Fetch From Stripe</button>
                </div> --}}

                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->ClientName->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                    @if (isset($projectmanager[0]->EmployeeName->name) and $projectmanager[0]->EmployeeName->name !== null)
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->EmployeeName->name }}</label>
                    @else
                    <label for="" style="font-size:150%;"><p style="color: red">User Deleted</p></label>
                    @endif
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;" >Brand:</label>
                        <select class="form-control select2" required name="brand">
                            @foreach ($brand as $brands)
                                <option value="{{ $brands->id }}">{{ $brands->name }}
                            </option>
                            @endforeach
                        </select>
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
                        <option value="FSRemaining">FSRemaining</option>
                        <option value="One Time Payment">One Time Payment</option>
                        {{-- <option value="ChargeBack Won">Dispute Won</option> --}}
                  </select>
                </div>
                <div class="col-8 mt-3" id="remainingpaymentfor" style="display: none">
                    <label for="" style="font-weight:bold;">Remaining For:</label>
                    <input type="hidden" name="remainingpaymentcount" value="{{$remainingpaymentcount}}">
                    <input type="hidden" name="remainingID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">
                    <select class="form-control"  name="remainingamountfor">
                        @if ($remainingpaymentcount == 0)
                            <option value="">No Remaining Amount</option>
                        @else
                            @foreach ($remainingpayments as $remainingpayment)
                                <option value="{{ $remainingpayment->id }}">{{ $remainingpayment->paymentNature }}
                                    --
                                    Total:{{ $remainingpayment->TotalAmount }}
                                    --
                                    Remaining:<strong>{{ $remainingpayment->RemainingAmount }}</strong>
                                    --
                                    {{ $remainingpayment->Description }}
                                </option>
                            @endforeach
                        @endif
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
                        <option value="2 Years">2 Years</option>
                        <option value="3 Years">3 Years</option>
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
                    var remainingamtfor = document.getElementById("remainingpaymentfor");

                    if (paymentNature === "New Lead" || paymentNature === "New Sale" || paymentNature === "Upsell"){
                        chargingpackage.style.display = 'block';
                        paymentMode.style.display = 'block';
                        remainingamtfor.style.display = 'none';
                    }else if(paymentNature === "Remaining" || paymentNature === "FSRemaining" ){
                        chargingpackage.style.display = 'none';
                        paymentMode.style.display = 'none';
                        remainingamtfor.style.display = 'block';
                    }else{
                        chargingpackage.style.display = 'none';
                        paymentMode.style.display = 'none';
                        remainingamtfor.style.display = 'none';
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
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Card Brand:</label>
                    <select  class="form-control " required name="cardBrand" id="clientcard">

                        <option value="AMEX">AMEX</option>
                        <option value="DISCOVER">DISCOVER</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="VISA">VISA</option>
                        <option value="WIRE">WIRE</option>
                        <option value="PayPall">PayPall</option>
                        <option value="Klarna">Klarna</option>
                    </select>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Payment Gateway</label>
                    <select  class="form-control select2" required name="paymentgateway" id="paymentgateway" onchange="bankfield()">
                        <option value="Stripe">Stripe</option>
                        <option value="Bank Wire">Bank Wire</option>
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
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Transaction ID:</label>
                    <input type="text" class="form-control" required name="transactionID">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Payment Date:</label>
                    <input type="date" class="form-control" required name="paymentdate">
                  </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Next Payment Date:</label>
                    <input type="date" class="form-control"  name="nextpaymentdate">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;" >Sale Person:</label>
                        <select class="form-control select2" required name="saleperson">
                            @foreach ($employee as $client)
                                @if (isset($findclientofproject[0]->frontSeler) and $findclientofproject[0]->frontSeler !== null)
                                <option value="{{ $client->id }}"{{ $client->id == $findclientofproject[0]->frontSeler ? 'selected' : '' }}>{{ $client->name }}
                                --
                                {{ $client->email }}
                                --
                                @else
                                <option value="{{ $client->id }}">{{ $client->name }}
                                --
                                @endif
                                @foreach($client->deparment($client->id)  as $dm)
                                <strong>{{ $dm->name }},</strong>
                                @endforeach
                            </option>
                            @endforeach
                        </select>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;" >Account Manager:</label>
                    <select class="form-control select2" required name="accountmanager">
                      @foreach ($pmemployee as $client)
                            @if (isset($projectmanager[0]->EmployeeName->id) and $projectmanager[0]->EmployeeName->id !== null)
                            <option value="{{ $client->id }}"{{ $client->id == $projectmanager[0]->EmployeeName->id ? 'selected' : '' }}>{{ $client->name }}
                            --
                            @else
                            <option value="{{ $client->id }}">{{ $client->name }}
                            --
                            @endif
                            @foreach($client->deparment($client->id)  as $dm)
                            <strong>{{ $dm->name }}</strong>
                            @endforeach
                        </option>
                      @endforeach
                    </select>
                </div>
                {{-- <input type="hidden" name="accountmanager" value="{{$projectmanager[0]->EmployeeName->id}}"> --}}
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Total Amount:</label>
                    <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="totalamount">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input id="amountPaid" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid">
                </div>
                {{-- <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Transaction Fee</label>
                    <input id="transactionfee" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee">
                </div> --}}
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
                    <textarea required name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>


            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Create"  name="" class="btn btn-success mt-2">
                    {{-- <input type="submit" value="Create Information" class=" mt-3 btn btn-success" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();"> --}}
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



@endsection
