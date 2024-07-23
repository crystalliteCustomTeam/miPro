@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Client Edit Refund:</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Refund</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
                @foreach ($client_payment as $item)
                    <form action="/client/project/payment/EditRefund/process/{{$item->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="clientID" value="{{$item->ClientID}}">
                        <input type="hidden" name="brandID" value="{{$item->BrandID}}">
                        <input type="hidden" name="projectID" value="{{$item->ProjectID}}">

                        <div class="row">
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                                <label for="" style="font-size:150%;">{{$item->paymentclientName->name }}</label>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                                <label for="" style="font-size:150%;">{{$item->paymentprojectName->name }}</label>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                                @if (isset($item->pmEmployeesName->name) and $item->pmEmployeesName->name !== null)
                                <label for="" style="font-size:150%;">{{$item->pmEmployeesName->name }}</label>
                                @else
                                <label for="" style="font-size:150%;"><p style="color: red">User Deleted</p></label>
                                @endif
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Chargeback Type:</label>
                                <select class="form-control" required name="chargebacktype"  id="chargebacktype" >
                                    <option value="{{$refundpayment[0]->refundtype}}" selected>{{$refundpayment[0]->refundtype}}</option>
                                    <option value="Refunded">Refunded</option>
                                    <option value="Partial ChargeBack">Partial Refunded</option>
                                </select>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Platform:</label>
                                <select class="form-control select2"  required name="platform" id="platform">
                                    <option value="{{$item->Platform}}" selected>{{$item->Platform}}</option>
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
                                <select  class="form-control select2" required name="cardBrand" id="cardbrand">
                                        <option value="{{$item->Card_Brand}}" selected>{{$item->Card_Brand}}</option>
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
                                <select  class="form-control" required name="paymentgateway" id="paymentgateway" onchange="bankfield()">
                                    <option value="{{$item->Payment_Gateway}}" selected>{{$item->Payment_Gateway}}</option>
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
                                <input type="text" class="form-control" required name="transactionID" value="{{$item->TransactionID}}">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Payment Date:</label>
                                <input type="date" class="form-control" required name="paymentdate" value="{{$item->paymentDate}}">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;" >Account Manager:</label>
                                <select class="form-control select2" required name="saleperson" id="saleperson">
                                @foreach ($employee as $client)
                                        @if (isset($item->ProjectManager) and $item->ProjectManager !== null)
                                        <option value="{{ $client->id }}"{{ $client->id == $item->ProjectManager ? 'selected' : '' }}>{{ $client->name }}
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
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Total Amount:</label>
                                <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" id="totalpackage" value="{{$item->TotalAmount}}">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Client Paid (Refunded)</label>
                                <input id="amountPaid" type="text" class="form-control" required onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" value="{{$item->Paid}}">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Refund Fee</label>
                                <input id="transactionfee" type="text" class="form-control" required value="0" onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee" value="{{$item->transactionfee}}">
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;">Payment Type</label>
                                <select class="form-control select2" name="paymentType" id="paymentType" required onchange="displayfields()">
                                    <option value="Select">Select</option>
                                    <option value="{{$item->PaymentType}}" selected>{{$item->PaymentType}}</option>
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
                                <textarea required name="description" class="form-control" id="desc" cols="30" rows="10">{{$item->Description}}</textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <br><br>
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
                @endforeach
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
