@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
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
            <h4>Refund</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
                <form action="/client/project/payment/Dispute/process/lost" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="clientID" value="{{$dispute[0]->ClientID}}">
                    <input type="hidden" name="brandID" value="{{$dispute[0]->BrandID}}">
                    <input type="hidden" name="projectID" value="{{$dispute[0]->ProjectID}}">
                    <input type="hidden" name="mainpayment" value="{{$dispute[0]->PaymentID}}">
                    <input type="hidden" name="disputeID" value="{{$dispute[0]->id}}">
                    <input type="hidden" name="disputeStatus" value="Lost">
                    <input type="hidden" name="refundID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">

                    <div class="row">
                        <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                            <label for="" style="font-size:150%;">{{$dispute[0]->disputeclientName->name }}</label>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;" >Project Name:</label>
                            <select class="form-control select2" required name="project" disabled>
                            @foreach ($projects as $client)
                                <option value="{{ $client->id }}"{{ $client->id == $dispute[0]->ProjectID ? 'selected' : ''}}>{{ $client->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;">Reference Payment:</label>
                        <select class="form-control select2" required name="paymentreference"  id="paymentreference" disabled>
                            @foreach ($referencepayment as $referencepayments)
                            <option value="{{ $referencepayments->id }}"{{ $referencepayments->id == $dispute[0]->PaymentID ? 'selected' : ''}}>
                                @if (isset($referencepayments->paymentprojectName->name) && $referencepayments->paymentprojectName->name != null)
                                {{ $referencepayments->paymentprojectName->name }}
                                @else
                                    undefined
                                @endif

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
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Nature:</label>
                            <select class="form-control select2" required name="paymentNature1"  id="paymentNaturetype" disabled>
                                  <option value="Dispute Lost" selected>Dispute Lost</option>
                            </select>
                            <input type="hidden" name="paymentNature" value="Dispute Lost">
                          </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Platform:</label>
                            <select class="form-control select2"  required name="platform" disabled>
                                <option value="{{$dispute[0]->disputepayment->Platform}}">{{$dispute[0]->disputepayment->Platform}}</option>
                            </select>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Card Brand:</label>
                            <select  class="form-control select2" required name="cardBrand1"  disabled>
                                <option value="{{$dispute[0]->disputepayment->Card_Brand}}">{{$dispute[0]->disputepayment->Card_Brand}}</option>
                            </select>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Gateway</label>
                            <select  class="form-control select2" required name="paymentgateway1" id="paymentgateway" disabled>
                                <option value="{{$dispute[0]->disputepayment->Payment_Gateway}}">{{$dispute[0]->disputepayment->Payment_Gateway}}</option>
                                <option value="Stripe">Stripe</option>
                                <option value="Bank Wire">Bank Wire</option>
                            </select>
                        </div>
                        @if ($dispute[0]->disputepayment->Payment_Gateway == 'Bank Wire')
                        <div class="col-4 mt-3" id="bankUpload" >
                            <label for="" style="font-weight:bold;">Bank Wire(Upload):</label>
                            <input type="file" name="bankWireUpload" id="bankWireUpload" class="form-control">
                        </div>
                        @endif
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Transaction ID:</label>

                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;" name="transactionID1" value="{{$dispute[0]->disputepayment->TransactionID}}" disabled>
                            @else
                            <input type="text" class="form-control" required name="transactionID1" value="{{$dispute[0]->disputepayment->TransactionID}}" disabled>
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
                            <label for="" style="font-weight:bold;" >Sale Person:</label>
                            <select class="form-control select2" required name="saleperson1" disabled>
                            @foreach ($employee as $client)
                                    <option value="{{ $client->id }}"{{ $client->id == $dispute[0]->disputepayment->SalesPerson ? 'selected' : ''}}>{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endforeach
                            </select>
                            <input type="hidden" name="saleperson" value="{{$dispute[0]->disputepayment->SalesPerson}}">
                        </div>
                        {{-- <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;" >Account Manager:</label>
                            <select class="form-control select2" required name="accountmanager1" disabled>
                            @foreach ($employee as $client)
                                    <option value="{{ $client->id }}"{{ $client->id == $dispute[0]->disputepayment->ProjectManager ? 'selected' : ''}}>{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endforeach
                            </select>
                        </div> --}}
                        <input type="hidden" name="accountmanager" value="{{$dispute[0]->disputepayment->ProjectManager}}">
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Total Amount:</label>

                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" required style="height: 50px;" value="{{$dispute[0]->disputepayment->TotalAmount}}" disabled>
                            @else
                            <input type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="totalamount" value="{{$dispute[0]->disputepayment->TotalAmount}}" disabled>
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Client Paid (Refunded)</label>

                            @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" required style="height: 50px;"  value="{{$dispute[0]->disputepayment->Paid}}" disabled>
                            @else
                            <input id="amountPaid" type="text" class="form-control" required onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" value="{{$dispute[0]->disputepayment->Paid}}" disabled>
                            @endif
                        </div>
                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Payment Type</label>
                            <select class="form-control select2" name="paymentType" id="paymentType" required onchange="displayfields()" disabled>
                                <option value="{{$dispute[0]->disputepayment->PaymentType}}" selected>{{$dispute[0]->disputepayment->PaymentType}}</option>
                            </select>
                        </div>

                        @if ($dispute[0]->disputepayment->PaymentType == "Split Payment")
                            <div class="col-12 mt-3" id="numberofsplits" >
                                <label for="" style="font-weight:bold;">Number of Split:</label>
                                <select class="form-control" id="selectionField" onchange="toggleFields()" name="numOfSplit">
                                    <option value="{{$dispute[0]->disputepayment->numberOfSplits}}" selected>{{$dispute[0]->disputepayment->numberOfSplits}}</option>
                                </select>
                            </div>
                            @php
                                $sharedpms = json_decode($dispute[0]->disputepayment->SplitProjectManager);
                                $sharedamt = json_decode($dispute[0]->disputepayment->ShareAmount);
                            @endphp
                        <div class="col-12 mt-3" >
                            <div class="row">
                                <div class="col-6">
                                    @foreach ($sharedpms as $item)
                                        <div class="col-12 mt-3">
                                            <label for="" style="font-weight:bold;">Project Manager (If Split):</label><br>
                                            <select class="form-control select2" name="shareProjectManager[]" disabled>
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
                                    @foreach ($sharedamt as $item)
                                        <div class="col-12 mt-3">
                                            <div class="row">
                                            <div class="col-6">
                                            <label for="" style="font-weight:bold;">Share Amount:</label>
                                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]" value="{{$item}}" disabled>
                                            </div>
                                            <div class="col-6">
                                            <label for="" style="font-weight:bold;">Refund Amount:</label>
                                            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="refundamount[]"  >
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif


                        <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Description:</label><br>
                            @if ($theme == 1)
                    <textarea required name="description" class="form-control-dark wd-1000" id="" cols="30" rows="10"></textarea>
                    @else
                    <textarea required name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                    @endif
                        </div>


                        <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Chargeback Type:</label>
                            <select class="form-control select2" required name="chargebacktype"  id="chargebacktype" >
                                  <option value="Select">Select</option>
                                  <option value="Refunded" selected>Refunded</option>
                                  <option value="Dispute">Dispute</option>
                                  <option value="Partial ChargeBack">Partial ChargeBack</option>
                            </select>
                          </div>

                          <div class="col-4 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Amount:</label>

                              @if ($theme == 1)
                              <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="chagebackAmt" required style="height: 50px;" value="{{$dispute[0]->disputepayment->Paid}}">
                              @else
                              <input type="text" class="form-control"  name="chagebackAmt" value="{{$dispute[0]->disputepayment->Paid}}">
                              @endif
                          </div>

                          <div class="col-4 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Date:</label>

                              @if ($theme == 1)
                    <input type="date"  required name="chagebackDate" class="form-control-dark wd-400" style="height: 50px;">
                    @else
                    <input type="date" class="form-control"  name="chagebackDate" value="">
                    @endif
                          </div>

                          <div class="col-12 mt-3">
                              <label for="" style="font-weight:bold;">Chargeback Description:</label><br>
                              @if ($theme == 1)
                            <textarea required name="Description_of_issue" class="form-control-dark wd-1000" id="" cols="30" rows="10"></textarea>
                            @else
                            <textarea required name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
                            @endif
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
