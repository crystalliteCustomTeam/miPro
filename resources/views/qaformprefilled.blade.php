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
            <h3 style="color:black" class="mb-5">General Information:</h3>
           <form action="/forms/qaform/{{$projects[0]->id }}/process" method="POST">
            @csrf
            <input type="hidden" name="clientID" value="{{$projects[0]->ClientName->id }}">
            <input type="hidden" name="projectID" value="{{$projects[0]->id }}">
            <input type="hidden" name="projectmanagerID" value="{{$projects[0]->EmployeeName->id }}">
            <input type="hidden" name="brandID" value="{{$projects[0]->ClientName->projectbrand->id }}">
            <input type="hidden" name="qaformID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">

            <div class="row">
              <div class="col-12">
                <div class="btn-group">
                  <button class="btn btn-outline-primary">Client Name: {{$projects[0]->ClientName->name }}</button>
                  <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
                  <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button>
                  <button class="btn btn-outline-primary">Brand: {{$projects[0]->ClientName->projectbrand->name }}</button>
               </div>
              </div>



                <input type="hidden" name="basecamp" value="{{$projects[0]->basecampUrl }}">
                <div class="col-4 mt-3" >
                  <label for="" style="font-weight:bold;">Last communication with client </label>
                  <input type="date" name="last_communication_with_client" required class="form-control">
                </div>

                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Medium of communication:</label>
                    <select class="form-control select2" name="Medium_of_communication[]" multiple="multiple">
                        <option value="Calls">Calls</option>
                        <option value="Messages">Messages</option>
                        <option value="Basecamp">Basecamp</option>
                        <option value="Email">Email</option>
                        <option value="Whatsapp">Whatsapp</option>
                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Status:</label>
                    <select class="form-control select2" name="status" >
                        <option value="Dispute">Dispute</option>
                        <option value="Refund">Refund</option>
                        <option value="On Going">On Going</option>
                        <option value="Not Started Yet">Not Started Yet</option>
                    </select>
                  </div>
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
