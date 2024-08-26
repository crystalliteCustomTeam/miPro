@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Set Up Client</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Client</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

@if ($clientMetaCount > 0)

           <form action="/forms/kyc/process/editclient/{{$clients[0]->id}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Client Name:</label>
                        @if ($theme == 1)
                        <input type="text" required name="name" class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;" value="{{$clients[0]->name}}" >
                        @else
                        <input type="text" required name="name" class="form-control" value="{{$clients[0]->name}}" >
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Phone Number:</label>
                        @if ($theme == 1)
                    <input type="text" required name="phone" class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;" value="{{$clients[0]->phone}}">
                    @else
                    <input type="text" required name="phone" class="form-control" value="{{$clients[0]->phone}}">
                    @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Brand:</label>
                        <select class="form-control" id="select2forme"  name="brand">

                        @foreach ($Brands as $brand)
                                <option value="{{ $brand->id }}"{{ $brand->id == $clients[0]->brand ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                        </select>
                        </div>
                    {{-- <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Email:</label>
                        <input type="email"  name="email"  class="form-control" value="{{$clients[0]->email}}">
                    </div> --}}
                    @php
                        $clientmetas_otheremails = json_decode($clientmetas[0]->otheremail);
                    @endphp
                    @if ($clientmetas[0]->otheremail == null)
                        <div class="row field_wrapper col-12">
                            <div class="col-4 mt-3">
                                <label for=""style="font-weight:bold;">Email:</label><br>
                                <div class="btn-group">
                                    @if ($theme == 1)
                                    <input type="email" name="email[]" class="form-control-dark wd-350" placeholder="  Enter Email" required style="height: 50px;" value="{{$clients[0]->email}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                    @else
                                    <input type="email" name="email[]" class="form-control" value="{{$clients[0]->email}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($theme == 1)
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var x = 1; //Initial field counter is 1

                            // Once add button is clicked
                            $(addButton).click(function(){
                                //Check maximum number of input fields
                                if(x < maxField){
                                    x++; //Increase field counter
                                    $(wrapper).append(fieldHTML1); //Add field html
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
                     @else
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
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
                     @endif
                    @else
                        <div class="row field_wrapper col-12">
                        @foreach ($clientmetas_otheremails as $item)
                            @if ($item == $clientmetas_otheremails[0])
                                <div class="col-4 mt-3">
                                    <label for=""style="font-weight:bold;">Email:</label><br>
                                    <div class="btn-group">

                                        @if ($theme == 1)
                                        <input type="email" name="email[]" class="form-control-dark wd-350" placeholder="  Enter Email" required style="height: 50px;" value="{{$item}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                        @else
                                        <input type="email" name="email[]" class="form-control" value="{{$item}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="btn-group col-4 mt-5">

                                @if ($theme == 1)
                                <input type="email" name="email[]"class="form-control-dark wd-350" placeholder="  Enter Email" required style="height: 50px;"  value="{{$item}}"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a>
                                @else
                                <input type="email" name="email[]" class="form-control" value="{{$item}}"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a>
                                @endif
                            </div>
                           @endif
                        @endforeach
                        </div>
                    @endif
                    @if ($theme == 1)
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var x = 1; //Initial field counter is 1

                            // Once add button is clicked
                            $(addButton).click(function(){
                                //Check maximum number of input fields
                                if(x < maxField){
                                    x++; //Increase field counter
                                    $(wrapper).append(fieldHTML1); //Add field html
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
                    @else
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
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
                    @endif

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Sales Person:</label>
                        <select class="form-control select2"  name="saleperson">
                        @foreach($ProjectManagers as $pm)
                            <option value="{{ $pm->id }}"{{ $pm->id == $clients[0]->frontSeler ? 'selected' : '' }}>
                                {{ $pm->name }}
                                --
                                @foreach($pm->deparment($pm->id)  as $dm)
                                <strong>{{ $dm->name }}</strong>
                                @endforeach
                            </option>
                        @endforeach
                        </select>

                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                        @if ($theme == 1)
                        <input type="text" required name="website"  class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;" value="{{$clients[0]->website}}">
                        @else
                        <input type="text" required name="website"  class="form-control" value="{{$clients[0]->website}}">
                        @endif

                        </div>

                        {{-- ------------------------------METAS----------------------------------------------------- --}}
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Package Name</label>
                            @if (isset($clientmetas[0]->packageName))
                                @if ($theme == 1)
                                <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="package" required value="{{$clientmetas[0]->packageName}}">
                                @else
                                <input type="text" class="form-control" name="package" required value="{{$clientmetas[0]->packageName}}">
                                @endif
                            @else
                            @if ($theme == 1)
                                <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="package" required>
                                @else
                                <input type="text" class="form-control" name="package" required>
                                @endif
                            @endif

                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        @if (isset($clientmetas[0]->paymentRecuring))
                            <select class="form-control select2"  name="ChargingPlan">
                                <option value="{{$clientmetas[0]->paymentRecuring}}" selected>{{$clientmetas[0]->paymentRecuring}}</option>
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
                            </select>
                        @else
                            <select class="form-control select2"  name="ChargingPlan">
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
                            </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Total Project Amount</label>
                        @if (isset($clientmetas[0]->amountPaid))
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;" value="{{$clientmetas[0]->amountPaid}}">
                            @else
                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required value="{{$clientmetas[0]->amountPaid}}">
                            @endif
                        @else
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                            @else
                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                            @endif
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        @if (isset($clientmetas[0]->amountPaid))
                            @php
                                $client_paid = $clientmetas[0]->amountPaid - $clientmetas[0]->remainingAmount
                            @endphp
                            <label for="" style="font-weight:bold;">Client Paid</label>
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" value="{{$client_paid}}" name="paidamount" required style="height: 50px;">
                            @else
                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" value="{{$client_paid}}" required>
                            @endif
                        @else

                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
                            @else
                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                            @endif
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                        @if (isset($clientmetas[0]->nextPayment))
                            @if ($theme == 1)
                            <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;" value="{{$clientmetas[0]->nextPayment}}">
                            @else
                            <input type="date" class="form-control" name="nextamount" required value="{{$clientmetas[0]->nextPayment}}">
                            @endif
                        @else
                            @if ($theme == 1)
                            <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;">
                            @else
                            <input type="date" class="form-control" name="nextamount" required >
                            @endif
                        @endif
                    </div>



            @if ($clientmetas[0]->service == 'seo')
                    @php
                    $seo_details = json_decode($clientmetas[0]->orderDetails)
                    @endphp


                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Keyword Count</label>
                        @if (isset($clientmetas[0]->nextPayment))

                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="KeywordCount" value="{{$seo_details->KEYWORD_COUNT}}">
                            @else
                            <input type="text" class="form-control" name="KeywordCount" value="{{$seo_details->KEYWORD_COUNT}}">
                            @endif
                        @else
                        @if ($theme == 1)
                        <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" name="KeywordCount" style="height: 50px;">
                        @else
                        <input type="text" class="form-control" name="KeywordCount">
                        @endif
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Target Market</label>
                        @if (isset($seo_details->TARGET_MARKET))
                            <select class="form-control select2"   name="TargetMarket[]" multiple="multiple">
                                @foreach ($seo_details->TARGET_MARKET as $targetMarket)
                                <option value="{{$targetMarket}}" selected>{{$targetMarket}}</option>
                                @endforeach
                                <option value="Global">Global</option>
                                <option value="Nationwide">Nationwide</option>
                                <option value="Local">Local</option>
                            </select>
                        @else
                            <select class="form-control select2"   name="TargetMarket[]" multiple="multiple">
                                <option value="Global">Global</option>
                                <option value="Nationwide">Nationwide</option>
                                <option value="Local">Local</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        @if (isset($seo_details->OTHER_SERVICE))
                            <select class="form-control select2"   name="OtherServices[]" multiple="multiple">
                                @foreach ($seo_details->OTHER_SERVICE as $item)
                                <option value="{{$item}}" selected>{{$item}}</option>
                                @endforeach
                                <option value="SMM">SMM</option>
                                <option value="GMB">GMB</option>
                                <option value="Adword Campaign">Adword Campaign</option>
                                <option value="Facebook Campaign">Facebook Campaign</option>
                                <option value="Website">Website</option>
                                <option value="NFT">NFT</option>
                                <option value="NFT Marketing only">NFT Marketing only</option>
                                <option value="--">Not Applicable</option>

                                @foreach($productionservices as $productionservice)
                                <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                                @endforeach
                            </select>
                        @else
                        <select class="form-control select2"   name="OtherServices[]" multiple="multiple">
                            <option value="SMM">SMM</option>
                            <option value="GMB">GMB</option>
                            <option value="Adword Campaign">Adword Campaign</option>
                            <option value="Facebook Campaign">Facebook Campaign</option>
                            <option value="Website">Website</option>
                            <option value="NFT">NFT</option>
                            <option value="NFT Marketing only">NFT Marketing only</option>
                            <option value="--">Not Applicable</option>

                            @foreach($productionservices as $productionservice)
                            <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        @if (isset($seo_details->LEAD_PLATFORM))
                            <select class="form-control select2"  name="leadplatform">
                                <option value="{{$seo_details->LEAD_PLATFORM}}" selected>{{$seo_details->LEAD_PLATFORM}}</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @else
                            <select class="form-control select2"  name="leadplatform">
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Payment Nature</label>
                        @if (isset($seo_details->Payment_Nature))
                            <select class="form-control select2"  name="paymentnature">
                                <option value="{{$seo_details->Payment_Nature}}" selected>{{$seo_details->Payment_Nature}}</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Recurring">Recurring</option>
                                <option value="One Time">One Time</option>
                            </select>
                        @else
                            <select class="form-control select2"  name="paymentnature">
                                <option value="Renewal">Renewal</option>
                                <option value="Recurring">Recurring</option>
                                <option value="One Time">One Time</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;">Anymore commitments?</label><br>
                        @if (isset($seo_details->ANY_COMMITMENT))

                            @if ($theme == 1)
                            <textarea name="anycommitment" class="form-control-dark wd-1000" id="" cols="30" rows="10">{{$seo_details->ANY_COMMITMENT}}</textarea>
                            @else
                            <textarea name="anycommitment" class="form-control" id="" cols="30" rows="10">{{$seo_details->ANY_COMMITMENT}}</textarea>
                            @endif
                        @else
                            @if ($theme == 1)
                            <textarea  name="anycommitment" class="form-control-dark wd-1000" id="" cols="30" rows="10"></textarea>
                            @else
                            <textarea name="anycommitment" class="form-control" id="" cols="30" rows="10"></textarea>
                            @endif
                        @endif
                    </div>

            @elseif ($clientmetas[0]->service == 'book')
                    @php
                    $book_details = json_decode($clientmetas[0]->orderDetails)
                    @endphp


                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Product</label>
                        @if (isset($book_details->PRODUCT))
                        <select class="form-control select2"  name="product[]" multiple="multiple">
                            @foreach ($book_details->PRODUCT as $item)
                            <option value="{{$item}}" selected>{{$item}}</option>
                            @endforeach
                            <option value="Editing & Proofreading">Editing & Proofreading</option>
                            <option value="Ghost Writing">Ghost Writing</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Only Proofreading">Only Proofreading</option>

                            @foreach($productionservices as $productionservice)
                            <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                            @endforeach
                        </select>
                        @else
                        <select class="form-control select2"  name="product[]" multiple="multiple">
                            <option value="Editing & Proofreading">Editing & Proofreading</option>
                            <option value="Ghost Writing">Ghost Writing</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Only Proofreading">Only Proofreading</option>

                            @foreach($productionservices as $productionservice)
                            <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">MenuScript Provided?</label>
                        @if (isset($book_details->MENU_SCRIPT))
                            <select class="form-control select2"  name="menuscript">
                                <option value="{{$book_details->MENU_SCRIPT}}" selected>{{$book_details->MENU_SCRIPT}}</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        @else
                            <select class="form-control select2"  name="menuscript">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        @endif
                    </div>
                        <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Genre of the book?</label>
                        @if (isset($book_details->BOOK_GENRE))
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="bookgenre" value="{{$book_details->BOOK_GENRE}}">
                            @else
                            <input type="text" class="form-control" name="bookgenre" value="{{$book_details->BOOK_GENRE}}">
                            @endif
                        @else
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="bookgenre">
                            @else
                            <input type="text" class="form-control" name="bookgenre">
                            @endif
                        @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Cover design included?</label>
                            @if (isset($book_details->COVER_DESIGN))
                                <select class="form-control select2"  name="coverdesign">
                                    <option value="{{$book_details->COVER_DESIGN}}" selected>{{$book_details->COVER_DESIGN}}</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            @else
                                <select class="form-control select2"  name="coverdesign">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Total number of pages</label>
                        @if (isset($book_details->TOTAL_NUMBER_OF_PAGES))
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="totalnumberofpages" value="{{$book_details->TOTAL_NUMBER_OF_PAGES}}">
                            @else
                            <input type="text" class="form-control" name="totalnumberofpages" value="{{$book_details->TOTAL_NUMBER_OF_PAGES}}">
                            @endif
                        @else
                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="totalnumberofpages">
                            @else
                            <input type="text" class="form-control" name="totalnumberofpages">
                            @endif
                        @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Publishing platforms offered?</label>
                            @if (isset($book_details->PUBLISHING_PLATFORM))
                                @if ($theme == 1)
                                <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="publishingplatform" value="{{$book_details->PUBLISHING_PLATFORM}}">
                                @else
                                <input type="text" class="form-control" name="publishingplatform" value="{{$book_details->PUBLISHING_PLATFORM}}">
                                @endif
                            @else
                                @if ($theme == 1)
                                <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="publishingplatform">
                                @else
                                <input type="text" class="form-control" name="publishingplatform">
                                @endif
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">ISBN Offered or Bar Code?</label>
                            @if (isset($book_details->ISBN_OFFERED))
                                <select class="form-control select2"  name="isbn_offered">
                                    <option value="{{$book_details->ISBN_OFFERED}}" selected>{{$book_details->ISBN_OFFERED}}</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            @else
                                <select class="form-control select2"  name="isbn_offered">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            @endif

                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Lead Platform</label>
                            @if (isset($book_details->LEAD_PLATFORM))
                                <select class="form-control select2"  name="leadplatform">
                                    <option value="{{$book_details->LEAD_PLATFORM}}" selected>{{$book_details->LEAD_PLATFORM}}</option>
                                    <option value="Google Ads">Google Ads</option>
                                    <option value="Bark Lead">Bark Lead</option>
                                    <option value="UpWork Lead">UpWork Lead</option>
                                    <option value="Freelancer">Freelances</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Thumbtack">Thumbtack</option>
                                    <option value="Email Marketing">Email Marketing</option>
                                    <option value="Email Marketing">Back Data</option>
                                    <option value="Email Marketing">Incoming Call</option>
                                    <option value="Email Marketing">Reference</option>
                                    <option value="Email Marketing">Social Media</option>
                                </select>
                            @else
                                <select class="form-control select2"  name="leadplatform">
                                    <option value="Google Ads">Google Ads</option>
                                    <option value="Bark Lead">Bark Lead</option>
                                    <option value="UpWork Lead">UpWork Lead</option>
                                    <option value="Freelancer">Freelances</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Thumbtack">Thumbtack</option>
                                    <option value="Email Marketing">Email Marketing</option>
                                    <option value="Email Marketing">Back Data</option>
                                    <option value="Email Marketing">Incoming Call</option>
                                    <option value="Email Marketing">Reference</option>
                                    <option value="Email Marketing">Social Media</option>
                                </select>
                            @endif
                        </div>

            @elseif ($clientmetas[0]->service == 'website')
                    @php
                    $website_details = json_decode($clientmetas[0]->orderDetails)
                    @endphp

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        @if (isset($website_details->OTHER_SERVICES))
                            <select class="form-control select2"  name="otherservices[]" multiple="multiple">
                                @foreach ($website_details->OTHER_SERVICES as $item)
                                <option value="{{$item}}" selected>{{$item}}</option>
                                @endforeach
                                <option value="Logo">Logo</option>
                                <option value="Hosting">Hosting</option>
                                <option value="Content">Content</option>
                                <option value="SEO Marketing">SEO Marketing</option>
                                <option value="SMM Marketing">SMM Marketing</option>
                                <option value="--">Not Applicable</option>

                                @foreach($productionservices as $productionservice)
                                <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                                @endforeach

                            </select>
                        @else
                            <select class="form-control select2"  name="otherservices[]" multiple="multiple">
                                <option value="Logo">Logo</option>
                                <option value="Hosting">Hosting</option>
                                <option value="Content">Content</option>
                                <option value="SEO Marketing">SEO Marketing</option>
                                <option value="SMM Marketing">SMM Marketing</option>
                                <option value="--">Not Applicable</option>
                                @foreach($productionservices as $productionservice)
                                <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                                @endforeach

                            </select>
                        @endif

                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        @if (isset($website_details->LEAD_PLATFORM))
                            <select class="form-control select2"  name="leadplatform">
                                <option value="{{$website_details->LEAD_PLATFORM}}" selected>{{$website_details->LEAD_PLATFORM}}</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @else
                            <select class="form-control select2"  name="leadplatform">
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @endif

                    </div>
                    <div class="col-8 mt-3">
                    <label for="" style="font-weight:bold;">Anymore commitment?</label><br>
                    @if (isset($website_details->ANY_COMMITMENT))
                        @if ($theme == 1)
                        <input type="text" class="form-control" name="anycommitment" class="form-control-dark wd-850" placeholder="  Enter Name"  style="height: 50px;" value="{{$website_details->ANY_COMMITMENT}}">
                        @else
                        <input type="text" class="form-control" name="anycommitment" value="{{$website_details->ANY_COMMITMENT}}">
                        @endif
                    @else
                        @if ($theme == 1)
                        <input type="text" class="form-control" name="anycommitment" class="form-control-dark wd-850" placeholder="  Enter Name"  style="height: 50px;">
                        @else
                        <input type="text" class="form-control" name="anycommitment">
                        @endif
                    @endif
                    </div>

            @else
                    @php
                    $cld_details = json_decode($clientmetas[0]->orderDetails)
                    @endphp

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        @if (isset($cld_details->OTHER_SERVICES))
                            <select class="form-control select2"  name="otherservices[]" multiple="multiple">
                                @foreach ($cld_details->OTHER_SERVICES as $item)
                                <option value="{{$item}}" selected>{{$item}}</option>
                                @endforeach
                                <option value="Logo">Logo</option>
                                <option value="Hosting">Hosting</option>
                                <option value="Content">Content</option>
                                <option value="SEO Marketing">SEO Marketing</option>
                                <option value="SMM Marketing">SMM Marketing</option>
                                <option value="--">Not Applicable</option>

                                @foreach($productionservices as $productionservice)
                                <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control select2"  name="otherservices[]" multiple="multiple">
                                <option value="Logo">Logo</option>
                                <option value="Hosting">Hosting</option>
                                <option value="Content">Content</option>
                                <option value="SEO Marketing">SEO Marketing</option>
                                <option value="SMM Marketing">SMM Marketing</option>
                                <option value="--">Not Applicable</option>

                                @foreach($productionservices as $productionservice)
                                <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        @if (isset($cld_details->LEAD_PLATFORM))
                            <select class="form-control select2"  name="leadplatform">
                                <option value="{{$cld_details->LEAD_PLATFORM}}" selected>{{$cld_details->LEAD_PLATFORM}}</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @else
                            <select class="form-control select2"  name="leadplatform">
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>
                            </select>
                        @endif

                    </div>
                    <div class="col-8 mt-3">
                    <label for="" style="font-weight:bold;">Anymore commitment?</label>
                    @if (isset($cld_details->LEAD_PLATFORM))
                        @if ($theme == 1)
                        <input type="text" class="form-control" name="anycommitment" class="form-control-dark wd-850" placeholder="  Enter Name"  style="height: 50px;" value="{{$cld_details->ANY_COMMITMENT}}">
                        @else
                        <input type="text" class="form-control" name="anycommitment" value="{{$cld_details->ANY_COMMITMENT}}">
                        @endif
                    @else
                        @if ($theme == 1)
                        <input type="text" class="form-control" name="anycommitment" class="form-control-dark wd-850" placeholder="  Enter Name"  style="height: 50px;">
                        @else
                        <input type="text" class="form-control" name="anycommitment">
                        @endif
                    @endif
                    </div>

            @endif


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


@else

            <form action="/forms/kyc/process/editclientwithoutmeta/{{$clients[0]->id}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Client Name:</label><br>

                        @if ($theme == 1)
                        <input type="text"  name="name" class="form-control-dark wd-400" value="{{$clients[0]->name}}" placeholder="  Enter Name" required style="height: 50px;">
                        @else
                        <input type="text"  name="name" class="form-control" value="{{$clients[0]->name}}" >
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Phone Number:</label>

                        @if ($theme == 1)
                        <input type="text"  name="phone"  class="form-control-dark wd-400" value="{{$clients[0]->phone}}" placeholder="  Enter Name" required style="height: 50px;">
                        @else
                        <input type="text"  name="phone"  class="form-control" value="{{$clients[0]->phone}}">
                        @endif
                    </div>
                    {{-- <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Email:</label>
                        <input type="email"  name="email"  class="form-control" value="{{$clients[0]->email}}">
                    </div> --}}
                    <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Brand:</label>
                    <select class="form-control" id="select2forme"  name="brand">

                    @foreach ($Brands as $brand)
                            <option value="{{ $brand->id }}"{{ $brand->id == $clients[0]->brand ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                    </select>
                    </div>
                    <div class="row field_wrapper col-12">
                        <div class="col-4 mt-3">
                            <label for=""style="font-weight:bold;">Email:</label><br>
                            <div class="btn-group">

                                @if ($theme == 1)
                                <input type="email" name="email[]"  class="form-control-dark wd-350" placeholder="  Enter Email" required style="height: 50px;" value="{{$clients[0]->email}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                @else
                                <input type="email" name="email[]" class="form-control" value="{{$clients[0]->email}}"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                                @endif
                            </div>
                        </div>
                    </div>

                   @if ($theme == 1)
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var x = 1; //Initial field counter is 1

                            // Once add button is clicked
                            $(addButton).click(function(){
                                //Check maximum number of input fields
                                if(x < maxField){
                                    x++; //Increase field counter
                                    $(wrapper).append(fieldHTML1); //Add field html
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
                     @else
                    <script>
                        $(document).ready(function(){
                            var maxField = 10; //Input fields increment limitation
                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter Name" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
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
                     @endif
                    <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Sales Person:</label>
                    <select class="form-control select2"  name="saleperson">
                    @foreach($ProjectManagers as $pm)
                        <option value="{{ $pm->id }}"{{ $pm->id == $clients[0]->frontSeler ? 'selected' : '' }}>
                            {{ $pm->name }}
                            --
                            @foreach($pm->deparment($pm->id)  as $dm)
                            <strong>{{ $dm->name }}</strong>
                            @endforeach
                        </option>
                    @endforeach
                    </select>

                    </div>
                    <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>

                    @if ($theme == 1)
                    <input type="text"  name="website" class="form-control-dark wd-400" value="{{$clients[0]->website}}" placeholder="  Enter Name" required style="height: 50px;">
                    @else
                    <input type="text"  name="website"  class="form-control" value="{{$clients[0]->website}}">
                    @endif
                    </div>

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Select Domain:</label>
                            <select class="form-control select2"  name="domain">
                                <option value="seo">seo</option>
                                <option value="book">book</option>
                                <option value="Website">Website</option>
                                <option value="cld">cld</option>
                            </select>
                    </div>

                </div>



            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Create"  name="" class="btn btn-success mt-2">

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


@endif





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

