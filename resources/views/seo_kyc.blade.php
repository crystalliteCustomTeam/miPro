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

           <form action="/forms/kyc/process/client" method="POST">
            @csrf
            <input type="hidden" name="serviceType" id="seo" value="seo">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label><br>

                    @if ($theme == 1)
                    <input type="text" required name="name" class="form-control-dark wd-400" placeholder="  Enter Name" required style="height: 50px;">
                    @else
                    <input type="text" required name="name" class="form-control">
                    @endif
                </div>
                <div class="col-4 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>

                    @if ($theme == 1)
                    <input type="text" required name="phone" class="form-control-dark wd-400" placeholder="  Enter number" required style="height: 50px;">
                    @else
                    <input type="text" required name="phone" class="form-control">
                    @endif
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Brand:</label>
                    <select class="form-control" id="select2forme" required name="brand">

                    @foreach ($Brands as $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="row field_wrapper col-12">
                    <div class="col-4 mt-3">
                        <label for=""style="font-weight:bold;">Email:</label><br>
                        <div class="btn-group">

                            @if ($theme == 1)
                            <input type="email" name="email[]" class="form-control-dark wd-350" placeholder="  Enter Email" required style="height: 50px;"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
                            @else
                            <input type="email" name="email[]" class="form-control"><a href="javascript:void(0);" class="add_button btn btn-primary"  title="Add field">add</a>
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
                            var fieldHTML1 = '<div class="btn-group col-4 mt-5"><input type="email" name="email[]"  placeholder="  Enter another email" class="form-control-dark wd-350" style="height: 50px;"><a href="javascript:void(0);" class="remove_button btn btn-danger">remove</a></div>'; //New input field html
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
                  @if ($theme == 1)
                  <input type="text" required name="website"  class="form-control-dark wd-400" placeholder="  Enter Website" required style="height: 50px;">
                  @else
                  <input type="text" required name="website"  class="form-control">
                  @endif

                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Package Name</label>
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter package" style="height: 50px;" name="package" required>
                    @else
                    <input type="text" class="form-control" name="package" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Keyword Count</label>

                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter count" name="KeywordCount" required style="height: 50px;">
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
                    <input type="text" id="other" name="TargetMarket[]" class="form-control-dark wd-400" placeholder="  Enter" required style="height: 50px;">
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
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Amount" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    @if ($theme == 1)
                    <input type="text" class="form-control-dark wd-400" placeholder="  Enter Amount" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required style="height: 50px;">
                    @else
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                    @endif
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Future Next Payment Date </label><br>
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
                    <textarea required name="anycommitment" class="form-control-dark wd-1000" id="" cols="30" rows="10" placeholder="  Any comment"></textarea>
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


{{-- <form id="form" action="" method="POST">
    <fieldset class="inputs-set" id="email-list" class="input-field">
      <input class="input-field" type="email" name="email_field[]" required />
    </fieldset>
    <button class="btn-submit" type="submit">SUBMIT</button>
  </form>
  <button class="btn-add-input" onclick="addEmailField()" type="">
    Add email
  </button>

  <script>
    const myForm = document.getElementById("email-list");

    function addEmailField() {
      // create an input field to insert
      const newEmailField = document.createElement("input");
      // set input field data type to text
      newEmailField.type = "email";
      // set input field name
      newEmailField.name = "email_field";
      // set required
      newEmailField.setAttribute("required", "");

      newEmailField.classList.add("input-field");

      // insert element
      myForm.appendChild(newEmailField);
    }
  </script> --}}
