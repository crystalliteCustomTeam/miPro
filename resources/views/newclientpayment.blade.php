@extends('layouts.app')

@section('maincontent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">New Client</a>
            <span class="breadcrumb-item active">Client Payment</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client Payment</h4>
            <p class="mg-b-0">New Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

           <form action="/newclient/payment/process" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label>
                    <input type="text"  name="name" class="form-control" required>
                </div>
                <div class="col-6 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>
                    <input type="text"  name="phone" required class="form-control">
                </div>
                <div class="row field_wrapper col-12">
                    <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Email:</label><br>
                        <div class="btn-group">
                            <input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                        </div>
                    </div>
                </div>
                  <script>
                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $('.add_button'); //Add button selector
                        var wrapper = $('.field_wrapper'); //Input field wrapper
                        var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                        var x = 1; //Initial field counter is 1

                        // Once add button is clicked
                        $(addButton).click(function(){
                            //Check maximum number of input fields
                            if(x < maxField){
                                x++; //Increase field counter
                                $(wrapper).append(fieldHTML); //Add field html
                            }else{
                                alert('A maximum of '+maxField+' fields are allowed to be added. ');
                            }
                        });

                        // Once remove button is clicked
                        $(wrapper).on('click', '.remove_button', function(e){
                            e.preventDefault();
                            $(this).parent('div').remove(); //Remove field html
                            x--; //Decrease field counter
                        });
                    });
                </script>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                    <input type="text"  name="website" required class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Brand:</label>
                    <select class="form-control" id="select2forme" required name="brand">

                    @foreach ($brands as $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                    </select>
                  </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Payment Nature:</label>
                  <select class="form-control select2" required name="paymentNature"  id="paymentNaturetype" onchange="paymentnature()">
                        <option value="Select">Select</option>
                        <option value="New Lead">New Lead</option>
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
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Card Brand:</label>
                    <select  class="form-control " required name="cardBrand" id="clientcard">

                        <option value="AMEX">AMEX</option>
                        <option value="DISCOVER">DISCOVER</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="VISA">VISA</option>
                        <option value="WIRE">WIRE</option>
                        <option value="PayPall">PayPall</option>
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
                                <option value="{{ $client->id }}">{{ $client->name }}
                                --
                                @foreach($client->deparment($client->id)  as $dm)
                                <strong>{{ $dm->name }},</strong>
                                @endforeach
                                </option>
                            @endforeach
                        </select>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Total Amount:</label>
                    <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="totalamount">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input id="amountPaid" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Transaction Fee</label>
                    <input id="transactionfee" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee">
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
