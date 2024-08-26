@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Client Refund:</span>
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
                <form action="/client/project/payment/Refund/process" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="clientID" value=" {{$project[0]->clientID}} ">
                    <input type="hidden" name="brandID" value=" {{$project[0]->ClientName->brand}} ">
                    <input type="hidden" name="projectID" value=" {{$project[0]->id}} ">
                    <input type="hidden" name="refundID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">

                    <div class="row">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                            <label for="" style="font-size:150%;">{{$project[0]->ClientName->name }}</label>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                            <label for="" style="font-size:150%;">{{$project[0]->name }}</label>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                            @if (isset($project[0]->EmployeeName->name) and $project[0]->EmployeeName->name !== null)
                            <label for="" style="font-size:150%;">{{$project[0]->EmployeeName->name }}</label>
                            @else
                            <label for="" style="font-size:150%;"><p style="color: red">User Deleted</p></label>
                            @endif
                        </div>
                        <div class="col-11 mt-3">
                        <label for="" style="font-weight:bold;">Reference Payment:</label>
                        <select class="form-control select2" required name="paymentreference"  id="payment-dropdown" >
                            @foreach ($client_payment as $referencepayments)
                            <option value="{{ $referencepayments->id }}">{{ $referencepayments->paymentprojectName->name }}
                                --
                                {{ $referencepayments->paymentNature }}
                                --
                                Total:{{ $referencepayments->TotalAmount }}
                                --
                                Paid:{{ $referencepayments->Paid }}
                                --
                                {{ $referencepayments->Description }}
                            </option>
                            @endforeach
                        </select>
                        {{-- <button class="btn btn-primary" id="fetchstripe">Get</button> --}}
                        </div>
                        <div class="col-1 mt-5">
                            <button class="btn btn-primary" id="searchpaymentdata">Get</button>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Chargeback Type:</label>
                            <select class="form-control select2" required name="chargebacktype"  id="chargebacktype" >
                                  <option value="Select">Select</option>
                                  <option value="Refunded">Refunded</option>
                                  <option value="Partial ChargeBack">Partial Refunded</option>
                            </select>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Platform:</label>
                            <select class="form-control select2"  required name="platform" id="platform">
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
                            @if ($theme == 1)
                            <input type="file" name="bankWireUpload" class="form-control-dark wd-400" required style="height: 50px;">
                            @else
                            <input type="file" name="bankWireUpload" id="bankWireUpload" class="form-control">
                            @endif
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
                            @if ($theme == 1)
                            <input type="text"  class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;" name="transactionID">
                            @else
                            <input type="text" class="form-control" required name="transactionID">
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Date:</label>
                            @if ($theme == 1)
                            <input type="date"  required name="paymentdate" class="form-control-dark wd-400" style="height: 50px;">
                            @else
                            <input type="date" class="form-control" required name="paymentdate">
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;" >Account Manager:</label>
                            <select class="form-control select2" required name="saleperson" id="saleperson">
                            @foreach ($saleemployee as $client)
                                    @if (isset($findclientofproject[0]->frontSeler) and $findclientofproject[0]->frontSeler !== null)
                                    <option value="{{ $client->id }}"{{ $client->id == $findclientofproject[0]->frontSeler ? 'selected' : '' }}>{{ $client->name }}
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
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;" >Account Manager:</label>
                            <select class="form-control select2" required name="accountmanager1" id="projectmanager">
                            @foreach ($pmemployee as $client)
                                    @if (isset($projectmanager[0]->EmployeeName->id) and $projectmanager[0]->EmployeeName->id !== null)
                                    <option value="{{ $client->id }}"{{ $client->id == $projectmanager[0]->projectManager ? 'selected' : '' }}>{{ $client->name }}
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
                        </div> --}}
                        <input type="hidden" name="accountmanager" value="{{ $project[0]->EmployeeName->id }}">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Total Amount:</label>
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" id="totalpackage" required style="height: 50px;">
                            @else
                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" id="totalpackage" required>
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Client Paid (Refunded)</label>
                            @if ($theme == 1)
                            <input  id="amountPaid" type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" required style="height: 50px;">
                            @else
                            <input  id="amountPaid"type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" required>
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Refund Fee</label>

                            @if ($theme == 1)
                            <input id="transactionfee" type="text" class="form-control-dark wd-400"  placeholder="  Enter Name" required value="0" onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee" style="height: 50px;">
                            @else
                            <input id="transactionfee" type="text" class="form-control" required value="0" onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee">
                            @endif
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
                            <label for="" style="font-weight:bold;">Number of Split:</label><br>
                            <select class="form-control select2 wd-400" id="selectionField" onchange="toggleFields()" name="numOfSplit">
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
                                    @if ($theme == 1)
                                    <input type="text" class="form-control-dark wd-600"  placeholder="  Enter Name" style="height: 50px;" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]">
                                    @else
                                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]">
                                    @endif
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
                            <label for="" style="font-weight:bold;">Description:</label><br>
                            @if ($theme == 1)
                            <textarea required name="description" class="form-control-dark wd-1000" id="desc" cols="30" rows="10"></textarea>
                            @else
                            <textarea required name="description" class="form-control" id="desc" cols="30" rows="10"></textarea>
                            @endif
                        </div>
{{--
                          <div class="col-4 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Amount:</label>
                              <input type="text" class="form-control"  name="chagebackAmt" >
                          </div> --}}

                          {{-- <div class="col-4 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Date:</label>
                              <input type="date" class="form-control"  name="chagebackDate" >
                          </div> --}}

                          {{-- <div class="col-12 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Description:</label>
                              <textarea  name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
                          </div> --}}
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



        <script>
            $(document).ready(function () {

                $("#searchpaymentdata").click(function(event){
                    event.preventDefault();
                    let paymentID = $("#payment-dropdown");
                    $.ajax({
                            url:"/api/fetch-paymentdata",
                            type:"get",
                            data:{
                                "payment_id":paymentID.val()
                            },
                            beforeSend:(()=>{
                                paymentID.attr('disabled','disabled');
                                $("#searchpaymentdata").text("wait...");
                                $("#searchpaymentdata").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                    let platform =  Response.platform;
                                    var newOption = new Option(platform, platform);
                                    // Append the new option to the select element
                                    $('#platform').append(newOption);
                                    // Set the newly added option as selected
                                    $(newOption).prop('selected', true);

                                    let cardbrand =  Response.cardbrand;
                                    var newOption1 = new Option(cardbrand, cardbrand);
                                    $('#cardbrand').append(newOption1);
                                    $(newOption1).prop('selected', true);

                                    let paymentgateway = Response.paymentgateway;
                                    var newOption2 = new Option(paymentgateway, paymentgateway);
                                    $('#paymentgateway').append(newOption2);
                                    $(newOption2).prop('selected', true);

                                    let saleperson = Response.saleperson;
                                    let salepersonID = Response.salepersonID;
                                    var newOption3 = new Option(saleperson, salepersonID);
                                    $('#saleperson').append(newOption3);
                                    $(newOption3).prop('selected', true);

                                    let projectmanager =  Response.projectmanager;
                                    let projectmanagerID =  Response.projectmanagerID;
                                    var newOption4 = new Option(projectmanager, projectmanagerID);
                                    $('#projectmanager').append(newOption4);
                                    $(newOption4).prop('selected', true);

                                    let totalamt =  Response.totalamt;
                                    $("#totalpackage").val(totalamt);

                                    let clientpaid = Response.clientpaid;
                                    $("#amountPaid").val(clientpaid);

                                    let paymenttype = Response.paymenttype;
                                    var newOption7 = new Option(paymenttype, paymenttype);
                                    $('#paytype').append(newOption7);
                                    $(newOption7).prop('selected', true);

                                    // let splitmanagers =  Response.splitmanagers;
                                    // let splitamounts =  Response.splitamounts;

                                    let description = Response.description;
                                    $("#desc").val(description);


                            paymentID.removeAttr('disabled');
                            $("#searchpaymentdata").text("Search");
                            $("#searchpaymentdata").removeAttr('disabled');


                            }),
                            error:(()=>{
                                alert("Error Found Please Referesh Window And Try Again !")

                                paymentID.removeAttr('disabled');
                                $("#searchpaymentdata").text("Search");
                                $("#searchpaymentdata").removeAttr('disabled');
                            })

                    });
                });


            });
        </script>



@endsection
