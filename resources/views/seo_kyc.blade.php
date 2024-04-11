@extends('layouts.app')

@section('maincontent')
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

           <form action="/forms/kyc/process/client" method="POST">
            @csrf
            <input type="hidden" name="serviceType" id="seo" value="seo">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label>
                    <input type="text" required name="name" class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>
                    <input type="text" required name="phone" class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for=""style="font-weight:bold;">Email:</label>
                    <input type="email" required name="email" class="form-control">
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Brand:</label>
                  <select class="form-control" id="select2forme" required name="brand">

                  @foreach ($Brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Sales Person:</label>
                  <select class="form-control select2"   required name="saleperson">
                  @foreach($ProjectManagers as $pm)
                      <option value="{{ $pm->id }}">
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
                  <input type="text" required name="website"  class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Package Name</label>
                    <input type="text" class="form-control" name="package" required>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Keyword Count</label>
                    <input type="text" class="form-control" name="KeywordCount" required>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Target Market</label>
                    <select class="form-control select2"  required name="TargetMarket[]" multiple="multiple" id="options" onchange="toggleTextField()">
                        <option value="Global">Global</option>
                        <option value="Nationwide">Nationwide</option>
                        <option value="Local">Local</option>
                        <option value="others">Others</option>
                    </select>
                  </div>
                  <div class="col-4 mt-3" id="other-text" style="display: none">
                    <label for="" style="font-weight:bold;">Please specify:</label>
                    <input type="text" id="other" name="TargetMarket[]" class="form-control">
                  </div>
                  <script>
                    function toggleTextField() {
                      var selectBox = document.getElementById("options");
                      var otherTextField = document.getElementById("other-text");

                      if (selectBox.value === "others") {
                        otherTextField.style.display = "block";
                      } else {
                        otherTextField.style.display = "none";
                      }
                    }
                  </script>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Other Services</label>
                    <select class="form-control select2"  required name="OtherServices[]" multiple="multiple">
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
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Charging Plan</label>
                    <select class="form-control select2"  required name="ChargingPlan">
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

                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Total Project Amount</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                    <input type="date" class="form-control" name="nextamount" required>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Lead Platform</label>
                    <select class="form-control select2"  required name="leadplatform">
                        <option value="Google Ads">Google Ads</option>
                        <option value="Bark Lead">Bark Lead</option>
                        <option value="UpWork Lead">UpWork Lead</option>
                        <option value="Freelancer">Freelances</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Thumbtack">Thumbtack</option>
                        <option value="Email Marketing">Email Marketing</option>
                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Payment Nature</label>
                    <select class="form-control select2"  required name="paymentnature">
                        <option value="Renewal">Renewal</option>
                        <option value="Recurring">Recurring</option>
                        <option value="One Time">One Time</option>
                    </select>
                  </div>
                  <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Anymore commitments?</label>
                    <textarea required name="anycommitment" class="form-control" id="" cols="30" rows="10"></textarea>
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
