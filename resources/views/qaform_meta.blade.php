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
            <h4>Set Up QA Form </h4>
            <p class="mg-b-0">QA Form Department Issue</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Client Project Information:</h4>
           <form action="/forms/qaform/qa_meta/{id}/process" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="formid" value="{{ $qaform[0]->qaformID }}">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Department: </label>
                    <select class="form-control select2" name="department">
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Responsible Person (Working On Project):</label>
                    <select class="form-control select2" name="person">
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Status:</label>
                    <select class="form-control select2" name="status_depart" >
                        <option value="In Process">In Process</option>
                        <option value="Completed">Completed</option>
                        <option value="Not Applicable">Not Applicable</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                        <option value="Waiting for Client Response">Waiting for Client Response</option>
                    </select>
                  </div>

                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Evidence(if any issue) </label>
                    <input type="file" name="Evidence" class="form-control">
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

                <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Description of issue</label>
                    <textarea  name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-12">
                    <input type="submit" value="Create Information" class=" mt-3 btn btn-success">
                </div>
            </div>
           </form>


        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    <div class="br-pagebody">
        <div class="br-section-wrapper">
           <h2>Department Issues:</h2>
              <button class="btn btn-outline-primary">Client Name: {{$projects[0]->ClientName->name }}</button>
              <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
              <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button>
              <button class="btn btn-outline-primary">Brand: {{$projects[0]->ClientName->projectbrand->name }}</button>
              <br><br>

           <table class="table" id="datatable1">
              <tr>
                <td style="font-weight:bold;">Department</td>
                <td style="font-weight:bold;">Responsible Person</td>
                <td style="font-weight:bold;">Status</td>
                <td style="font-weight:bold;">Issue</td>
                <td style="font-weight:bold;">Description</td>
              </tr>
              <tbody>
                @foreach ($qaformmetas as $qaformmeta)
                  <tr>
                    <td>{{ $qaformmeta->DepartNameINQA->name }}</td>
                    <td>{{ $qaformmeta->EmployeeNameINQA->name }}</td>
                    <td>{{ $qaformmeta->status }}</td>
                    <td>{{ $qaformmeta->issues }}</td>
                    <td>{{ $qaformmeta->Description_of_issue}}</td>
                  </tr>
                @endforeach
              </tbody>
           </table>
        </div>
      </div>






      <div class="br-pagebody"  >
        <div class="br-section-wrapper">
           <h2>Project Remarks:</h2>
           <form action="/forms/qaform/qa_remarks/{{ $qaform[0]->qaformID }}/process" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="formid" value="{{ $qaform[0]->qaformID }}">

            <div class="row">
                <div class="col-6 mt-3">
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
                  <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Refund Requested: </label>
                    <select class="form-control select2"  name="Refund_Requested" >
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                  </div>
                <div class="col-6 mt-3">
                  <label for="" style="font-weight:bold;">Refund Request Attachment </label>
                  <input type="file" name="Refund_Request_Attachment"  class="form-control">
                </div>
                <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Summery </label>
                    <textarea  name="Refund_Request_summery" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-12">
                    <input type="submit" value="Submit Form" class=" mt-3 btn btn-success">
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
