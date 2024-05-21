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
            @foreach ($editPayments as $editPayment)
            <form action="/client/project/payment/edit/{{$editPayment->id}}/process" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="brandID" value="{{$editPayment->BrandID}}">
                <input type="hidden" name="clientID" value="{{$editPayment->ClientID}}">
                <input type="hidden" name="project" value="{{$editPayment->ProjectID}}">


                <div class="row">


                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                        <label for="" style="font-size:150%;">{{$editPayment->paymentclientName->name }}</label>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                        <label for="" style="font-size:150%;">{{$editPayment->paymentprojectName->name }}</label>
                      </div>
                     <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                        @if (isset($editPayment->pmEmployeesName->name) and $editPayment->pmEmployeesName->name !== null)
                        <label for="" style="font-size:150%;">{{$editPayment->pmEmployeesName->name }}</label>
                        @else
                        <label for="" style="font-size:150%;"><p style="color: red">User Deleted</p></label>
                        @endif
                    </div>
                    <div class="col-4 mt-3">
                      <label for="" style="font-weight:bold;">Payment Nature:</label>
                      <select class="form-control select2" required name="paymentNature"  id="paymentNaturetype">
                            <option value="{{$editPayment->paymentNature}}" selected>{{$editPayment->paymentNature}}</option>
                            <option value="New Lead">New Lead</option>
                            <option value="New Sale">New Sale</option>
                            <option value="Renewal Payment">Renewal Payment</option>
                            <option value="Recurring Payment">Recurring Payment</option>
                            <option value="Small Payment">Small Payment</option>
                            <option value="Upsell">Upsell</option>
                            {{-- <option value="Remaining">Remaining</option> --}}
                            <option value="One Time Payment">One Time Payment</option>
                            <option value="ChargeBack Won">ChargeBack Won</option>
                      </select>
                    </div>
                    <div class="col-4 mt-3" id="chargingpackage" >
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        <select class="form-control"  name="ChargingPlan">
                            <option value="{{$editPayment->ChargingPlan}}" selected>{{$editPayment->ChargingPlan}}</option>
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
                    <div class="col-4 mt-3" id="paymentMode" >
                        <label for="" style="font-weight:bold;">Payment Mode</label>
                        <select class="form-control"  name="paymentModes">
                            <option value="{{$editPayment->ChargingMode}}" selected>{{$editPayment->ChargingMode}}</option>
                            <option value="One Time Payment">One Time Payment</option>
                            <option value="Renewal">Renewal</option>
                            <option value="Recurring">Recurring</option>
                        </select>
                    </div>

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Platform:</label>
                        <select class="form-control select2"  required name="platform">
                              <option value="{{$editPayment->Platform}}" selected>{{$editPayment->Platform}}</option>
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
                        <select  class="form-control select2" required name="cardBrand">
                            <option value="{{$editPayment->Card_Brand}}" selected>{{$editPayment->Card_Brand}}</option>
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
                        <select  class="form-control select2" required name="paymentgateway" id="paymentgateway">
                            <option value="{{$editPayment->Payment_Gateway}}" selected>{{$editPayment->Payment_Gateway}}</option>
                            <option value="Stripe">Stripe</option>
                            <option value="Bank Wire">Bank Wire</option>
                        </select>
                    </div>
                    <div class="col-4 mt-3" id="bankUpload" >
                        <label for="" style="font-weight:bold;">Bank Wire(Upload):</label>
                        <input type="file" name="bankWireUpload" id="bankWireUpload" class="form-control">
                    </div>

                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Transaction ID:</label>
                        <input type="text" class="form-control" required name="transactionID" value="{{$editPayment->TransactionID}}">
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Payment Date:</label>
                        <input type="date" class="form-control" required name="paymentdate" value="{{$editPayment->paymentDate}}">
                      </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Next Payment Date:</label>
                        <input type="date" class="form-control"  name="nextpaymentdate" value="{{$editPayment->futureDate}}">
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;" >Sale Person:</label>
                        <select class="form-control select2" required name="saleperson">
                          @foreach ($saleemployee as $client)
                                @if (isset($editPayment->ProjectManager) and $editPayment->ProjectManager !== null)
                                <option value="{{ $client->id }}"{{ $client->id == $editPayment->SalesPerson ? 'selected' : '' }}>{{ $client->name }}
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
                        <select class="form-control select2" required name="accountmanager1" disabled>
                          @foreach ($pmemployee as $client)
                                @if (isset($editPayment->ProjectManager) and $editPayment->ProjectManager !== null)
                                <option value="{{ $client->id }}"{{ $client->id == $editPayment->ProjectManager ? 'selected' : '' }}>{{ $client->name }}
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
                    <input type="hidden" name="accountmanager" value="{{$editPayment->ProjectManager}}">
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Total Amount:</label>
                        <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" value="{{$editPayment->TotalAmount}}">
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Client Paid</label>
                        <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid"value="{{$editPayment->Paid}}">
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Transaction Fee</label>
                        <input id="transactionfee" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="transactionfee" value="{{$editPayment->transactionfee}}">
                    </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Payment Type</label>
                        <select class="form-control select2" name="paymentType" id="paymentType" required >
                            <option value="{{$editPayment->PaymentType}}">{{$editPayment->PaymentType}}</option>
                            <option value="Split Payment">Split Payment</option>
                            <option value="Full Payment">Full Payment</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3" id="numberofsplits" >
                        <label for="" style="font-weight:bold;">Number of Split:</label>
                        <select class="form-control" id="selectionField"  name="numOfSplit">
                            <option value="{{$editPayment->numberOfSplits}}">{{$editPayment->numberOfSplits}}</option>
                            <option value="--">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    @php
                        $sharedpms = json_decode($editPayment->SplitProjectManager);
                        $sharedamt = json_decode($editPayment->ShareAmount);
                    @endphp
                    <div class="col-12 mt-3" >
                        <div class="row">
                            <div class="col-6">
                                @foreach ($sharedpms as $item)
                                <div class="col-12 mt-3">
                                    <label for="" style="font-weight:bold;">Project Manager (If Split):</label><br>
                                    <select class="form-control select2" name="shareProjectManager[]">
                                        <option value="0">Select</option>
                                        @foreach ($employee as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $item ? 'selected' : '' }}>
                                            {{ $client->name }} --
                                            @foreach($client->deparment($client->id) as $dm)
                                            <strong>{{ $dm->name }}</strong>
                                            @endforeach
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-6">
                                @if ($sharedamt[0] != null)
                                @foreach ($sharedamt as $item)
                                <div class="col-12 mt-3">
                                    <label for="" style="font-weight:bold;">Share Amount:</label>
                                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]" value="{{$item}}">
                                </div>
                                @endforeach
                                @else

                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;">Description:</label>
                        <textarea required name="description" class="form-control" id="" cols="30" rows="10">{{$editPayment->Description}}</textarea>
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
