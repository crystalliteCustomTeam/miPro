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
            <h4 style="font-weight:bold;">General Information:</h4>
           <form action="#" method="POST">
            @csrf

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                    <label for="" style="font-size:150%;">{{$projects[0]->ClientName->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                    <label for="" style="font-size:150%;">{{$projects[0]->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                    <label for="" style="font-size:150%;">{{$projects[0]->EmployeeName->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Brand:</label>
                    <label for="" style="font-size:150%;">{{$projects[0]->ClientName->brand }}</label>
                </div>
                <div class="col-8 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Basecamplink:</label>
                    <label for="" style="font-size:150%;">{{$projects[0]->basecampUrl }}</label>
                </div>
                <div class="col-3 mt-3" >
                  <label for="" style="font-weight:bold;">Last communication with client </label>
                  <input type="date" name="last_communication_with_client" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Medium of communication:</label>
                    <select class="form-control select2" name="Medium_of_communication[]" multiple="multiple">
                        <option value="Calls">Calls</option>
                        <option value="Messages">Messages</option>
                        <option value="Basecamp">Basecamp</option>
                        <option value="Email">Email</option>
                        <option value="Whatsapp">Whatsapp</option>
                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Status:</label>
                    <select class="form-control select2" name="status" >
                        <option value="Dispute">Dispute</option>
                        <option value="Refund">Refund</option>
                        <option value="On Going">On Going</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Refund Requested:</label>
                    <select class="form-control select2" name="Refund_Requested" >
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                  </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Refund Request Attachment </label>
                  <input type="file" name="Refund_Request_Attachment" required class="form-control">
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












<!--QA Form-->

</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">QA From:</h4>
   <form action="#" method="POST">
    @csrf

        <div class="row">
            <div class="col-6 mt-3">
                <label for="" style="font-weight:bold;">Department: </label>
                <select class="form-control select2" name="department">
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;">Department Person:</label>
            <select class="form-control select2" name="person">
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;">Status:</label>
            <select class="form-control select2" name="status_depart" >
                <option value="In Process">In Process</option>
                <option value="Completed">Completed</option>
                <option value="Not Applicable">Not Applicable</option>
                <option value="Not Started Yet">Not Started Yet</option>
                <option value="Waiting for Client Response">Waiting for Client Response</option>
            </select>
          </div>
          <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;">Evidence(if any issue) </label>
            <input type="file" name="Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Issues:</label>
            <select class="form-control select2" name="issues[]" multiple="multiple">
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
                <option value="Simple issue">General issue</option>
                <option value="Timely Update">Timely Update</option>
                <option value="Understanding issue">Understanding issue</option>
                <option value="Going Good">Going Good</option>
            </select>
          </div>

        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue</label>
            <textarea required name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
   </form>




   <!--Remarks-->

</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">Remarks:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;">Client Satisfaction Level:</label>
            <select class="form-control select2" name="client_satisfation" >
                <option value="Extremely Satisfied">Extremely Satisfied</option>
                <option value="Somewhat Satisfied">Somewhat Satisfied</option>
                <option value="Neither Satisfied nor Dissatisfied">Neither Satisfied nor Dissatisfied</option>
                <option value="Not Started Yet">Not Started Yet</option>
                <option value="Somewhat Dissatisfied">Somewhat Dissatisfied</option>
                <option value="Extremely Dissatisfied">Extremely Dissatisfied</option>
            </select>
          </div>
        <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;">Refund & Dispute Expected :</label>
            <select class="form-control select2" name="status_of_refund" >
                <option value="Going Good">Going Good</option>
                <option value="Low">Low</option>
                <option value="Moderate">Moderate</option>
                <option value="Not Started Yet">Not Started Yet</option>
                <option value="High">High</option>
            </select>
          </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Summery </label>
            <textarea required name="Refund_Request_summery" class="form-control" id="" cols="30" rows="10"></textarea>
        </div>







        <div class="col-4 mt-3">
            <br>
            <input type="submit" value="Submit" name="" class="btn btn-success mt-2">
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
