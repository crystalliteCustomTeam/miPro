@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Brand</a>
            <span class="breadcrumb-item active">Set Up Brand</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Brand</h4>
            <p class="mg-b-0">Brand</p>
          </div>
        </div><!-- d-flex -->
  
        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
            
                <div class="col-3">
                    <label for="">Client Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for="">Phone Number: </label>
                    <input type="text" name="tel" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Email </label>
                    <input type="email" name="email" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Paid </label>
                  <input type="number" name="paid" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Remaining amount if any </label>
                  <input type="text" name="remainingamt" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Next Payment </label>
                  <input type="number" name="nextpayment" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Sales Person </label>
                  <input type="text" name="salesperson" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Project manager </label>
                  <input type="text" name="projectmanager" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Brand </label>
                  <input type="text" name="brand" required class="form-control">
                </div>
            </div>
            {{-- <div class="row mt-3">
                <div class="col-3">
                    <label for="">Address </label>
                    <input type="text" name="address" required class="form-control">
                </div>
                <div class="col-4">
                    <br>
                    <input type="submit" value="Create" name="" class="btn btn-success mt-2">
                </div>
                <div class="col-4">
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
            </div> --}}
           </form>
  
       
            
            
          
            
   
<!--SEO-->
  
          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-3">
                    <label for="">Website URL</label>
                    <input type="url" name="website" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for="">Package</label>
                    <input type="text" name="package" class="form-control" required>
                </div>
                
                <div class="col-3">
                    <label for="">Keyword Count</label>
                    <input type="text" name="keywordcount" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Target Market </label><br>
                    <input type="checkbox" id="Global" name="global" value="global" required >
                    <label for="Global">Global</label><br>
                    <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
                    <label for="Nationwide">Nationwide</label><br>
                    <input type="checkbox" id="Local" name="local" value="local" required >
                    <label for="Local">Local</label>  
                </div>
                <div class="col-3">
                  <label for="">Other Services </label>
                  <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
                  <label for="SMM">SMM</label><br>
                  <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
                  <label for="GMB">GMB</label><br>
                  <input type="checkbox" id="adword" name="adword" value="adword"  >
                  <label for="adword">Adword Campaign</label>  
                  <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
                  <label for="Facebook">Facebook Campaign</label>  
                  <input type="checkbox" id="Website" name="Website" value="Website"  >
                  <label for="Website">Website</label>  
                  <input type="checkbox" id="NFT" name="NFT" value="NFT"  >
                  <label for="NFT">NFT</label>  
                  <input type="checkbox" id="NFTMarketing" name="NFTMarketing" value="NFTMarketing"  >
                  <label for="NFTMarketing">NFT Marketing</label>  
                </div>
                <div class="col-3">
                  <label for="">Charging Plan </label>
                  <input type="radio" id="monthly" name="chargingplan" value="monthly">
                  <label for="monthly">Monthly</label><br>
                  <input type="radio" id="3_month" name="chargingplan" value="3 months">
                  <label for="3_month">3 Months</label><br>
                  <input type="radio" id="4_month" name="chargingplan" value="4 months">
                  <label for="4_month">4 Months</label>
                  <input type="radio" id="6_month" name="chargingplan" value="6 months">
                  <label for="6_month">6 Months</label><br>
                  <input type="radio" id="12_month" name="chargingplan" value="12 months">
                  <label for="12_month">12 Months</label><br>
                  <input type="radio" id="Hourly" name="chargingplan" value="Hourly">
                  <label for="Hourly">Hourly</label>
                  <input type="radio" id="2_month" name="chargingplan" value="2 months">
                  <label for="2_month">2 Months</label><br>
                  <input type="radio" id="onetime" name="chargingplan" value="One Time Payment">
                  <label for="onetime">One Time Payment</label><br>
                </div>
                <div class="col-3">
                  <label for="">Lead Platform </label>
                  <input type="text" name="leadplatform" required class="form-control">
                </div>
            </div>
           </form>













<!-- Book -->

          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-3">
                    <label for="">Product </label><br>
                    <input type="checkbox" id="Editing_and_Proofreading" name="Editing_and_Proofreading" value="Editing_and_Proofreading" required >
                    <label for="Editing_and_Proofreading">Editing and Proofreading</label><br>
                    <input type="checkbox" id="Marketing" name="Marketing" value="Marketing" required >
                    <label for="Marketing">Marketing</label><br>
                    <input type="checkbox" id="Only_Proofreading" name="Only_Proofreading" value="Only_Proofreading" required >
                    <label for="Only_Proofreading">Only Proofreading</label> 
                    <input type="checkbox" id="Ghost_Writing" name="Ghost_Writing" value="Ghost_Writing" required >
                    <label for="Ghost_Writing">Ghost Writing</label>  
                </div>
                <div class="col-3">
                  <label for="">Menuscript Provided? </label>
                  <input type="radio" id="yes" name="Menuscript_Provided" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="Menuscript_Provided" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-3">
                  <label for="">Genre of the book? </label>
                  <input type="text" name="genre" required class="form-control">
                </div>
                <div class="col-3">
                  <label for=""> Cover Design Included? </label>
                  <input type="radio" id="yes" name="cover_design" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="cover_design" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-3">
                  <label for="">Total number of pages </label>
                  <input type="number" name="totalpages" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Publishing Platforms Offered? </label>
                  <input type="text" name="publishingplatforms" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">ISBN offered or Bar code?</label>
                  <input type="radio" id="yes" name="isbn_or_barcode" value="yes">
                  <label for="yes">Yes</label><br>
                  <input type="radio" id="no" name="isbn_or_barcode" value="no">
                  <label for="no">No</label><br>
                </div>
                <div class="col-3">
                  <label for="">Anymome commitments? </label>
                  <input type="text" name="salesperson" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Platform</label>
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
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-3">
                    <label for="">Package </label><br>
                    <input type="checkbox" id="Website_Design_Only" name="Website_Design_Only" value="Website_Design_Only" required >
                    <label for="Website_Design_Only">Website Design Only</label><br>
                    <input type="checkbox" id="Website_Development_Only" name="Website_Development_Only" value="Website_Development_Only" required >
                    <label for="Website_Development_Only">Website Development Only</label><br>
                    <input type="checkbox" id="Website_Design__Development" name="Website_Design__Development" value="Website_Design__Development" required >
                    <label for="Website_Design__Development">Website Design & Development</label> 
                    <input type="checkbox" id="Website_Revamp" name="Website_Revamp" value="Website_Revamp" required >
                    <label for="Website_Revamp">Website Revamp</label>  
                </div>
                <div class="col-3">
                  <label for="">Other Services </label><br>
                  <input type="checkbox" id="logo" name="logo" value="logo" required >
                  <label for="logo">logo</label><br>
                  <input type="checkbox" id="hosting" name="hosting" value="hosting" required >
                  <label for="hosting">hosting</label><br>
                  <input type="checkbox" id="content" name="content" value="content" required >
                  <label for="content">content</label> 
                  <input type="checkbox" id="SEO_Marketing" name="SEO_Marketing" value="SEO_Marketing" required >
                  <label for="SEO_Marketing">SEO Marketing</label>  
                  <input type="checkbox" id="SMM_Marketing" name="SMM_Marketing" value="SMM_Marketing" required >
                  <label for="SMM_Marketing">SMM Marketing</label>  
              </div>
              <div class="col-3">
                <label for="">other service details</label>
                <input type="text" name="otherservice" required class="form-control">
              </div>
              <div class="col-3">
                <label for="">logo</label>
                <input type="text" name="brand" required class="form-control">
              </div>

            </div>
           </form>

  
       






<!-- cld -->         
</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for="">Package </label><br>
            <input type="checkbox" id="Website_Design_Only" name="Website_Design_Only" value="Website_Design_Only" required >
            <label for="Website_Design_Only">Website Design Only</label><br>
            <input type="checkbox" id="Website_Development_Only" name="Website_Development_Only" value="Website_Development_Only" required >
            <label for="Website_Development_Only">Website Development Only</label><br>
            <input type="checkbox" id="Website_Design__Development" name="Website_Design__Development" value="Website_Design__Development" required >
            <label for="Website_Design__Development">Website Design & Development</label> 
            <input type="checkbox" id="Website_Revamp" name="Website_Revamp" value="Website_Revamp" required >
            <label for="Website_Revamp">Website Revamp</label>  
        </div>
        <div class="col-3">
          <label for="">Other Services </label><br>
          <input type="checkbox" id="logo" name="logo" value="logo" required >
          <label for="logo">logo</label><br>
          <input type="checkbox" id="hosting" name="hosting" value="hosting" required >
          <label for="hosting">hosting</label><br>
          <input type="checkbox" id="content" name="content" value="content" required >
          <label for="content">content</label> 
          <input type="checkbox" id="SEO_Marketing" name="SEO_Marketing" value="SEO_Marketing" required >
          <label for="SEO_Marketing">SEO Marketing</label>  
          <input type="checkbox" id="SMM_Marketing" name="SMM_Marketing" value="SMM_Marketing" required >
          <label for="SMM_Marketing">SMM Marketing</label>  
      </div>
      <div class="col-3">
        <label for="">other service details</label>
        <input type="text" name="otherservice" required class="form-control">
      </div>
      <div class="col-3">
        <label for="">logo</label>
        <input type="text" name="brand" required class="form-control">
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