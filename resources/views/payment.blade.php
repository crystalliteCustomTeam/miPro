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
            <input type="hidden" name="pmID" value=" {{$projectmanager[0]->EmployeeName->id}} ">
            <input type="hidden" name="brandID" value=" {{$projectmanager[0]->ClientName->projectbrand->id}} ">

            <div class="row">


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
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->EmployeeName->name }}</label>
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
                  </select>
                </div>
                <div class="col-4 mt-3" id="chargingpackage" style="display: none">
                    <label for="" style="font-weight:bold;">Charging Plan</label>
                    <select class="form-control "  name="ChargingPlan">
                        <option value="One Time Payment">One Time Payment</option>
                        <option value="Monthly">Monthly</option>
                        <option value="2 Months">2 Months</option>
                        <option value="3 Months">3 Months</option>
                        <option value="4 Months">4 Months</option>
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
                    <select class="form-control "  name="paymentModes">
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
                    </select>
                  </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Card Brand:</label>
                    <select  class="form-control select2" required name="cardBrand">
                        <option value="AMEX">AMEX</option>
                        <option value="DISCOVER">DISCOVER</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="VISA">VISA</option>
                        <option value="WIRE">WIRE</option>
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
                    <input type="date" class="form-control" required name="nextpaymentdate">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;" >Sale Person:</label>
                    <select class="form-control select2" required name="saleperson">
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
                    <select class="form-control select2" required name="accountmanager">
                      @foreach ($employee as $client)
                          <option value="{{ $client->id }}"{{ $client->id == $projectmanager[0]->EmployeeName->id ? 'selected' : '' }}>{{ $client->name }}
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
                    <input type="text" class="form-control" required value="@if($AmountCheck) {{ $projectmanager[0]->ClientName->clientMetas->amountPaid }} @endif" onkeypress="return /[0-9]/i.test(event.key)" name="totalamount">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input type="text" class="form-control" required value="@if($AmountCheck) {{ $projectmanager[0]->ClientName->clientMetas->amountPaid }} @endif" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid">
                  </div>
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
                            <select class="form-control" name="shareProjectManager[]">
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

        <div class="br-pagebody">
          <div class="br-section-wrapper">
             <h2>All Payments By {{$projectmanager[0]->ClientName->name }}</h2>

             <table class="table" id="datatable1">
                <tr>
                  <td style="font-weight:bold;">Notice ID</td>
                  <td style="font-weight:bold;">Payment By</td>
                  <td style="font-weight:bold;">Charged Amount</td>
                  <td style="font-weight:bold;">Remaning Amount</td>
                  <td style="font-weight:bold;">Total Payment</td>
                  <td style="font-weight:bold;">Shared Managers</td>
                  <td style="font-weight:bold;">Shared Amounts</td>
                </tr>
                <tbody>
                  @foreach ($allPayments as $payments)
                    <tr>
                      <td>{{ $payments->id }}</td>
                      <td>{{ $payments->EmployeesName->name }}</td>
                      <td>${{ $payments->Paid }}</td>
                      <td>${{ $payments->RemainingAmount }}</td>
                      <td>${{ $payments->TotalAmount}}</td>
                      @php
                          $amount = json_decode( $payments->ShareAmount);
                          $managers = json_decode( $payments->SplitProjectManager);
                      @endphp
                      <td>
                        <ul>
                            @foreach ($managers as $items)
                            @if($items != 0 && $items != "--")
                                <li>{{$items}}</li>
                            @else

                            @endif
                            @endforeach
                        </ul>
                       </td>
                       <td>
                        <ul>
                            @foreach ($amount as $item)
                            @if(isset($item) && $items != "--")
                                <li>${{$item}}</li>
                            @else

                            @endif
                            @endforeach
                        </ul>
                       </td>
                    </tr>
                  @endforeach
                </tbody>
             </table>
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
