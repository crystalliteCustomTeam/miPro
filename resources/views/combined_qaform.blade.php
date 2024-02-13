@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">QA Form</a>
            <span class="breadcrumb-item active">Set Up QA Form</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up QA From</h4>
            <p class="mg-b-0">QA Form</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h3 style="color:black" class="mb-5">QA Form:</h3>
           <form action="/forms/qaform/{{$projects[0]->id }}/process" method="POST">
            @csrf
            <input type="hidden" name="clientID" value="{{$projects[0]->ClientName->id }}">
            <input type="hidden" name="projectID" value="{{$projects[0]->id }}">
            <input type="hidden" name="projectmanagerID" value="{{$projects[0]->EmployeeName->id }}">
            <input type="hidden" name="brandID" value="{{$projects[0]->ClientName->projectbrand->id }}">
            <input type="hidden" name="qaformID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">
            <input type="hidden" name="ProjectproductionID" value="{{$projects[0]->projectID }}">

            <div class="row">
              <div class="col-12">
                <div class="btn-group">
                  <button class="btn btn-outline-primary">Client Name: {{$projects[0]->ClientName->name }}</button>
                  <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
                  <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button>
                  <button class="btn btn-outline-primary">Brand: {{$projects[0]->ClientName->projectbrand->name }}</button>
                  <a href="#"><button class="btn btn-outline-success">Add Final Remarks</button></a>
               </div>
              </div>



                <input type="hidden" name="basecamp" value="{{$projects[0]->basecampUrl }}">
                <div class="col-6 mt-3" >
                  <label for="" style="font-weight:bold;">Last communication with client </label>
                  <input type="date" name="last_communication_with_client" required class="form-control">
                </div>

                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Medium of communication:</label>
                    <select class="form-control select2" required name="Medium_of_communication[]" multiple="multiple">
                        <option value="Calls">Calls</option>
                        <option value="Messages">Messages</option>
                        <option value="Basecamp">Basecamp</option>
                        <option value="Email">Email</option>
                        <option value="Whatsapp">Whatsapp</option>
                    </select>
                  </div>
                  <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Select Production: </label>
                    <select class="form-control select2" required name="production_name" required>
                        @foreach($productions as $production)
                        <option value="{{ $production->id }}">{{ $production->DepartNameinProjectProduction->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Status:</label>
                    <select class="form-control select2" required name="status"  id="paymentType" onchange="displayfields()">
                        <option value="Dispute">Dispute</option>
                        <option value="Refund">Refund</option>
                        <option value="On Going">On Going</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                    </select>
                </div>

                <div class="col-12 mt-3" id="issues">
                    <label for="" style="font-weight:bold;">Issues:</label>
                    <select class="form-control select2"  name="issues[]" multiple="multiple">
                        <option value="Question Type">Question Type</option>
                        <option value="Editing Issue">Editing Issue</option>
                        <option value="Typos">Typos</option>
                        <option value="Writing issue">Writing issue</option>
                        <option value="Word Omissions">Word Omissions</option>
                        <option value="Grammatical">Grammatical</option>
                        <option value="Illustration issue">Illustration issue</option>
                        <option value="Character Issue">Character Issue</option>
                        <option value="SMM Post Desing">SMM Post Desing</option>
                        <option value="Video Trailer">Video Trailer</option>
                        <option value="Website Mockup">Website Mockup</option>
                        <option value="News Letter Desing">News Letter Desing</option>
                        <option value="Mockup Design">Mockup Design</option>
                        <option value="NFT Desing Issue">NFT Desing Issue</option>
                        <option value="Content Alignment">Content Alignment</option>
                        <option value="Logo Alignment">Logo Alignment</option>
                        <option value="Theme issue'optimisation issue">Theme issue'optimisation issue</option>
                        <option value="Mobile responseviness">Mobile responseviness</option>
                        <option value="Article">Article</option>
                        <option value="Blogs">Blogs</option>
                        <option value="PR Release">PR Release</option>
                        <option value="Author Center">Author Center</option>
                        <option value="Creating Media Account">Creating Media Account</option>
                        <option value="Q&A Session">Q&A Session</option>
                        <option value="Reach BookClub">Reach BookClub</option>
                        <option value="News Letter">News Letter</option>
                        <option value="Influencer Outreach">Influencer Outreach</option>
                        <option value="Amazon Ads Campaign">Amazon Ads Campaign</option>
                        <option value="Posting">Posting</option>
                        <option value="SMM Post Conten">SMM Post Conten</option>
                        <option value="Good Read Account">Good Read Account</option>
                        <option value="Creating Social Media Account">Creating Social Media Account</option>
                        <option value="Keywords">Keywords</option>
                        <option value="GMB">GMB</option>
                        <option value="Ranking">Ranking</option>
                        <option value="On page Optimisation">On page Optimisation</option>
                        <option value="Off page Optimisation">Off page Optimisation</option>
                        <option value="Simple issue">General issue</option>
                        <option value="Timely Update">Timely Update</option>
                        <option value="Understanding issue">Understanding issue</option>
                        <option value="Going Good">Going Good</option>
                    </select>
                </div>

                <div class="col-12 mt-3" id="Description" >
                    <label for="" style="font-weight:bold;">Description of issue</label>
                    <textarea  name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-12 mt-3" id="shareamount" >
                    <label for="" style="font-weight:bold;">Evidence(if any issue) </label>
                    <input type="file" name="Evidence" class="form-control">
                </div>
                {{-- ----------------Remarks------------------- --}}
                <div class="col-3 mt-3" id="remark">
                    <label for="" style="font-weight:bold;">Client Satisfaction Level:</label>
                    <select class="form-control select2" name="client_satisfation">
                        <option value="Extremely Satisfied">Extremely Satisfied</option>
                        <option value="Somewhat Satisfied">Somewhat Satisfied</option>
                        <option value="Neither Satisfied nor Dissatisfied">Neither Satisfied nor Dissatisfied</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                        <option value="Somewhat Dissatisfied">Somewhat Dissatisfied</option>
                        <option value="Extremely Dissatisfied">Extremely Dissatisfied</option>
                    </select>
                  </div>
                <div class="col-3 mt-3" id="expected_refund">
                    <label for="" style="font-weight:bold;">Refund & Dispute Expected :</label>
                    <select class="form-control select2"  name="status_of_refund" >
                        <option value="Going Good">Going Good</option>
                        <option value="Low">Low</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                        <option value="High">High</option>
                    </select>
                  </div>
                  <div class="col-3 mt-3" id="refund_request">
                    <label for="" style="font-weight:bold;">Refund Requested: </label>
                    <select class="form-control select2"  name="Refund_Requested" >
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                  </div>
                <div class="col-3 mt-3" id="ref_req_attachment">
                  <label for="" style="font-weight:bold;">Refund Request Attachment </label>
                  <input type="file" name="Refund_Request_Attachment"  class="form-control">
                </div>
                <div class="col-12 mt-3" id="summery">
                    <label for="" style="font-weight:bold;">Summery </label>
                    <textarea  name="Refund_Request_summery"  class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <script>
                    function displayfields(){
                    var paymenttype = document.getElementById("paymentType").value;
                    var issues = document.getElementById("issues");
                    var shareamount = document.getElementById("shareamount");
                    var Description = document.getElementById("Description");

                    var summery = document.getElementById("summery");
                    var ref_req_attachment = document.getElementById("ref_req_attachment");
                    var refund_request = document.getElementById("refund_request");
                    var expected_refund = document.getElementById("expected_refund");
                    var remark = document.getElementById("remark");

                    if (paymenttype === "Not Started Yet"){
                        issues.style.display = 'none';
                        shareamount.style.display = 'none';
                        Description.style.display = 'none';

                        summery.style.display = 'none';
                        ref_req_attachment.style.display = 'none';
                        refund_request.style.display = 'none';
                        expected_refund.style.display = 'none';
                        remark.style.display = 'none';
                    }else {
                        issues.style.display = 'block';
                        shareamount.style.display = 'block';
                        Description.style.display = 'block';

                        summery.style.display = 'block';
                        ref_req_attachment.style.display = 'block';
                        refund_request.style.display = 'block';
                        expected_refund.style.display = 'block';
                        remark.style.display = 'block';
                    }
                    }
                  </script>
                <div class="col-12">
                    <input type="submit" value="Create Information" class=" mt-3 btn btn-success">
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
