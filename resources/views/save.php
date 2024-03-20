
<!--SEO-->

          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Search Engine Optimisation Information:</h4>
           <form action="#" method="POST">
            @csrf

            <div class="row">
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Website URL:</label>
                    <input type="url" name="website" class="form-control" required>
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Package:</label>
                    <input type="text" name="package" class="form-control" required>
                </div>

                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Keyword Count:</label>
                    <input type="text" name="keywordcount" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Lead Platform:</label>
                  <input type="text" name="leadplatform" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Target Market:</label><br>
                    <input type="checkbox" id="Global" name="Target_Market[]" value="global" required >
                    <label for="Global">Global</label><br>
                    <input type="checkbox" id="Nationwide" name="Target_Market[]" value="nationwide" required >
                    <label for="Nationwide">Nationwide</label><br>
                    <input type="checkbox" id="Local" name="Target_Market[]" value="local" required >
                    <label for="Local">Local</label><br>
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Other Services:</label><br>
                  <input type="checkbox" id="SMM" name="Other_Services[]" value="SMM"  >
                  <label for="SMM">SMM</label><br>
                  <input type="checkbox" id="GMB" name="Other_Services[]" value="GMB"  >
                  <label for="GMB">GMB</label><br>
                  <input type="checkbox" id="adword" name="Other_Services[]" value="adword"  >
                  <label for="adword">Adword Campaign</label><br>
                  <input type="checkbox" id="Facebook" name="Other_Services[]" value="Facebook"  >
                  <label for="Facebook">Facebook Campaign</label><br>
                  <input type="checkbox" id="Website" name="Other_Services[]" value="Website"  >
                  <label for="Website">Website</label><br>
                  <input type="checkbox" id="NFT" name="Other_Services[]" value="NFT"  >
                  <label for="NFT">NFT</label><br>
                  <input type="checkbox" id="NFTMarketing" name="Other_Services[]" value="NFTMarketing"  >
                  <label for="NFTMarketing">NFT Marketing</label><br>
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Charging Plan:</label><br>
                  <input type="radio" id="monthly" name="chargingplan" value="monthly">
                  <label for="monthly">Monthly</label><br>
                  <input type="radio" id="3_month" name="chargingplan" value="3 months">
                  <label for="3_month">3 Months</label><br>
                  <input type="radio" id="4_month" name="chargingplan" value="4 months">
                  <label for="4_month">4 Months</label><br>
                  <input type="radio" id="6_month" name="chargingplan" value="6 months">
                  <label for="6_month">6 Months</label><br>
                  <input type="radio" id="12_month" name="chargingplan" value="12 months">
                  <label for="12_month">12 Months</label><br>
                  <input type="radio" id="Hourly" name="chargingplan" value="Hourly">
                  <label for="Hourly">Hourly</label><br>
                  <input type="radio" id="2_month" name="chargingplan" value="2 months">
                  <label for="2_month">2 Months</label><br>
                  <input type="radio" id="onetime" name="chargingplan" value="One Time Payment">
                  <label for="onetime">One Time Payment</label><br>
                </div>
            </div>
           </form>













<!-- Book -->

          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Book Information:</h4>
           <form action="#" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <label for="" style="font-weight:bold;">Product:</label><br>
                    <input type="checkbox" id="Editing_and_Proofreading" name="Product[]" value="Editing_and_Proofreading" required >
                    <label for="Editing_and_Proofreading">Editing and Proofreading</label><br>
                    <input type="checkbox" id="Marketing" name="Product[]" value="Marketing" required >
                    <label for="Marketing">Marketing</label><br>
                    <input type="checkbox" id="Only_Proofreading" name="Product[]" value="Only_Proofreading" required >
                    <label for="Only_Proofreading">Only Proofreading</label> <br>
                    <input type="checkbox" id="Ghost_Writing" name="Product[]" value="Ghost_Writing" required >
                    <label for="Ghost_Writing">Ghost Writing</label><br>
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Menuscript Provided?</label><br>
                  <input type="radio" id="yes" name="Menuscript_Provided" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="Menuscript_Provided" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Genre of the book?</label>
                  <input type="text" name="genre" required class="form-control">
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;"> Cover Design Included?</label><br>
                  <input type="radio" id="yes" name="cover_design" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="cover_design" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Total number of pages:</label>
                  <input type="number" name="totalpages" required class="form-control">
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Publishing Platforms Offered?</label>
                  <input type="text" name="publishingplatforms" required class="form-control">
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">ISBN offered or Bar code?</label><br>
                  <input type="radio" id="yes" name="isbn_or_barcode" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="isbn_or_barcode" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Anymome commitments?</label>
                  <input type="text" name="any_commitment" required class="form-control">
                </div>
                <div class="col-md-4">
                  <label for="" style="font-weight:bold;">Platform</label><br>
                  <input type="radio" id="Google_Ads" name="platform" value="Google_Ads">
                  <label for="Google_Ads">Google Ads</label><br>
                  <input type="radio" id="Bark Lead" name="platform" value="Bark Lead">
                  <label for="Bark Lead">Bark Lead</label><br>
                  <input type="radio" id="UpWork_Lead" name="platform" value="UpWork_Lead">
                  <label for="UpWork_Lead">UpWork Lead</label><br>
                  <input type="radio" id="Freelanccer" name="platform" value="Freelanccer">
                  <label for="Freelanccer">Freelancer</label><br>
                </div>
            </div>
           </form>







<!-- Website -->

          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Website Information:</h4>
           <form action="#" method="POST">
            @csrf

            <div class="row">
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Package:</label><br>
                    <input type="checkbox" id="Website_Design_Only" name="Package[]" value="Website_Design_Only" required >
                    <label for="Website_Design_Only">Website Design Only</label><br>
                    <input type="checkbox" id="Website_Development_Only" name="Package[]" value="Website_Development_Only" required >
                    <label for="Website_Development_Only">Website Development Only</label><br>
                    <input type="checkbox" id="Website_Design__Development" name="Package[]" value="Website_Design__Development" required >
                    <label for="Website_Design__Development">Website Design & Development</label><br>
                    <input type="checkbox" id="Website_Revamp" name="Package[]" value="Website_Revamp" required >
                    <label for="Website_Revamp">Website Revamp</label><br>
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Other Services:</label><br>
                  <input type="checkbox" id="logo" name="Other_Services[]" value="logo" required >
                  <label for="logo">logo</label><br>
                  <input type="checkbox" id="hosting" name="Other_Services[]" value="hosting" required >
                  <label for="hosting">hosting</label><br>
                  <input type="checkbox" id="content-web" name="Other_Services[]" value="content" required >
                  <label for="content">content</label><br>
                  <input type="checkbox" id="SEO_Marketing" name="Other_Services[]" value="SEO_Marketing" required >
                  <label for="SEO_Marketing">SEO Marketing</label><br>
                  <input type="checkbox" id="SMM_Marketing" name="Other_Services[]" value="SMM_Marketing" required >
                  <label for="SMM_Marketing">SMM Marketing</label><br>
              </div>
              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Other Service Details:</label>
                <input type="text" name="otherservicedetail" required class="form-control">
              </div>
              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Logo:</label>
                <input type="text" name="logo" required class="form-control">
              </div>

            </div>
           </form>









<!-- cld -->
</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">Creative Logo Design Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Package:</label><br>
            <input type="checkbox" id="Website_Design_Only" name="Package[]" value="Website_Design_Only" required >
            <label for="Website_Design_Only">Website Design Only</label><br>
            <input type="checkbox" id="Website_Development_Only" name="Package[]" value="Website_Development_Only" required >
            <label for="Website_Development_Only">Website Development Only</label><br>
            <input type="checkbox" id="Website_Design__Development" name="Package[]" value="Website_Design__Development" required >
            <label for="Website_Design__Development">Website Design & Development</label><br>
            <input type="checkbox" id="Website_Revamp" name="Package[]" value="Website_Revamp" required >
            <label for="Website_Revamp">Website Revamp</label><br>
        </div>
        <div class="col-3 mt-3">
          <label for="" style="font-weight:bold;">Other Services:</label><br>
          <input type="checkbox" id="logo" name="Other_Services[]" value="logo" required >
          <label for="logo">logo</label><br>
          <input type="checkbox" id="hosting" name="Other_Services[]" value="hosting" required >
          <label for="hosting">hosting</label><br>
          <input type="checkbox" id="content-logo" name="Other_Services[]" value="content" required >
          <label for="content">content</label><br>
          <input type="checkbox" id="SEO_Marketing" name="Other_Services[]" value="SEO_Marketing" required >
          <label for="SEO_Marketing">SEO Marketing</label> <br>
          <input type="checkbox" id="SMM_Marketing" name="Other_Services[]" value="SMM_Marketing" required >
          <label for="SMM_Marketing">SMM Marketing</label> <br>
      </div>
      <div class="col-3 mt-3">
        <label for="" style="font-weight:bold;">other service details:</label>
        <input type="text" name="otherservice" required class="form-control">
      </div>
      <div class="col-3 mt-3">
        <label for="" style="font-weight:bold;">logo</label>
        <input type="text" name="logo" required class="form-control">
      </div>





      <div class="col-3">
        <br>
        <input type="submit" value="Create" name="" class="btn btn-success mt-2">
    </div>
    <div class="col-3">
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