@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">EditClient</a>
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

           <form action="/forms/kyc/process/editclientwithoutmeta_metacreationprocess" method="POST">
            @csrf
            <input type="hidden" name="clientID" id="clientID" value="{{$clientid}}">
@if ($domains == "seo")
            <input type="hidden" name="serviceType" id="seo" value="seo">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Package Name</label>

                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name"  style="height: 50px;"  name="package" required>
                    @else
                    <input type="text" class="form-control" name="package" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Keyword Count</label>

                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name"  style="height: 50px;"  name="KeywordCount" required>
                    @else
                    <input type="text" class="form-control" name="KeywordCount" required>
                    @endif
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

                    @if ($theme == 1)
                    <input type="text" id="other" name="TargetMarket[]" class="form-control-dark wd-400" placeholder="  Enter Name"  style="height: 50px;" >
                    @else
                    <input type="text" id="other" name="TargetMarket[]" class="form-control">
                    @endif
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
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                    @if ($theme == 1)
                    <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;">
                    @else
                    <input type="date" class="form-control" name="nextamount" required >
                    @endif
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
                    <label for="" style="font-weight:bold;">Anymore commitments?</label><br>
                    @if ($theme == 1)
                    <textarea required name="anycommitment" class="form-control-dark wd-1000" id="" cols="30" rows="10"></textarea>
                    @else
                    <textarea required name="anycommitment" class="form-control" id="" cols="30" rows="10"></textarea>
                    @endif
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
@elseif ($domains == "book")
            <input type="hidden" name="serviceType" id="book" value="book">
        <div class="row">
            <div class="col-4 mt-3">
                <label for="" style="font-weight:bold;">Package Name</label>
                @if ($theme == 1)
                <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="package" required>
                @else
                <input type="text" class="form-control" name="package" required>
                @endif
              </div>
            <div class="col-4 mt-3">
                <label for="" style="font-weight:bold;">Product</label>
                <select class="form-control select2"  required name="product[]" multiple="multiple">
                    <option value="Editing & Proofreading">Editing & Proofreading</option>
                    <option value="Ghost Writing">Ghost Writing</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Only Proofreading">Only Proofreading</option>

                    @foreach($productionservices as $productionservice)
                    <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                    @endforeach

                </select>
              </div>
              <div class="col-4 mt-3">
                <label for="" style="font-weight:bold;">MenuScript Provided?</label>
                <select class="form-control select2"  required name="menuscript">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
              </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Genre of the book?</label>
                  @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="bookgenre" required>
                    @else
                    <input type="text" class="form-control" name="bookgenre" required>
                    @endif
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Cover design included?</label>
                    <select class="form-control select2"  required name="coverdesign">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                  </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Total number of pages</label>
                  @if ($theme == 1)
                  <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="totalnumberofpages" required>
                  @else
                  <input type="text" class="form-control" name="totalnumberofpages" required>
                  @endif
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Publishing platforms offered?</label>
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" style="height: 50px;" name="publishingplatform" required>
                    @else
                    <input type="text" class="form-control" name="publishingplatform" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">ISBN Offered or Bar Code?</label>
                    <select class="form-control select2"  required name="isbn_offered">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
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
                        <option value="Email Marketing">Back Data</option>
                        <option value="Email Marketing">Incoming Call</option>
                        <option value="Email Marketing">Reference</option>
                        <option value="Email Marketing">Social Media</option>

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
                    @if ($theme == 1)
                        <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                        @else
                        <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                        @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    @if ($theme == 1)
                        <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
                        @else
                        <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                        @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                    @if ($theme == 1)
                    <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;">
                    @else
                    <input type="date" class="form-control" name="nextamount" required >
                    @endif
                  </div>
                  <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Anymore commitment?</label><br>
                    @if ($theme == 1)
                        <textarea required name="anycommitment" class="form-control-dark wd-1000" id="" cols="30" rows="10"></textarea>
                        @else
                        <textarea required name="anycommitment" class="form-control" id="" cols="30" rows="10"></textarea>
                        @endif
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

@elseif ($domains == "Website")

            <input type="hidden" name="serviceType" id="website" value="website">
        <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Package</label>
            <select class="form-control select2"  required name="package[]" multiple="multiple">
                <option value="Website Design Only">Website Design Only</option>
                <option value="Website Development Only">Website Development Only</option>
                <option value="Website Design & Development">Website Design & Development</option>
                <option value="Website Revamp">Website Revamp</option>

            </select>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Other Services</label>
            <select class="form-control select2"  required name="otherservices[]" multiple="multiple">
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
            <label for="" style="font-weight:bold;">Charging Plan</label>
            <select class="form-control select2"  required name="ChargingPlan">
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
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Total Project Amount</label>
            @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                    @endif
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Client Paid</label>
            @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                    @endif
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Future Next Payment Date </label>
            @if ($theme == 1)
            <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;">
            @else
            <input type="date" class="form-control" name="nextamount" required >
            @endif
        </div>
            <div class="col-8 mt-3">
                <label for="" style="font-weight:bold;">Anymore commitment?</label><br>

                @if ($theme == 1)
                <input type="text" class="form-control-dark wd-850" name="anycommitment" required style="height: 50px;" placeholder="  Enter Email">
                @else
                <input type="text" class="form-control" name="anycommitment" required>
                @endif
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




@else

            <input type="hidden" name="serviceType" id="cld" value="cld">
        <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Package</label>
            <select class="form-control select2"  required name="package[]" multiple="multiple">
                <option value="Website Design Only">Website Design Only</option>
                <option value="Website Development Only">Website Development Only</option>
                <option value="Website Design & Development">Website Design & Development</option>
                <option value="Website Revamp">Website Revamp</option>

            </select>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Other Services</label>
            <select class="form-control select2"  required name="otherservices[]" multiple="multiple">
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
            <label for="" style="font-weight:bold;">Charging Plan</label>
            <select class="form-control select2"  required name="ChargingPlan">
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
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Total Project Amount</label>
            @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                    @endif
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Client Paid</label>
            @if ($theme == 1)
            <input type="text" class="form-control-dark wd-400" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
            @else
            <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
            @endif
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Future Next Payment Date </label>
            @if ($theme == 1)
            <input type="date" class="form-control-dark wd-400" name="nextamount" required style="height: 50px;">
            @else
            <input type="date" class="form-control" name="nextamount" required >
            @endif
        </div>
            <div class="col-8 mt-3">
                <label for="" style="font-weight:bold;">Anymore commitment?</label>
                @if ($theme == 1)
                <input type="text" class="form-control-dark wd-850" name="anycommitment" required style="height: 50px;" placeholder="  Enter Email">
                @else
                <input type="text" class="form-control" name="anycommitment" required>
                @endif
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
