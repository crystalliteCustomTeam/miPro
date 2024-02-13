!@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">QA Form</a>
            <span class="breadcrumb-item active">Client</span>
            <span class="breadcrumb-item active">Project</span>
            <span class="breadcrumb-item active">Production</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Client: </h4>
            <p class="mg-b-0">Project Production:</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Client Project Information:</h4>
           <form action="/client/project/production/{id}/process" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="projectid" value="{{ $project_id[0]->productionID }}">
            <input type="hidden" name="clientname" value="{{$projects[0]->ClientName->id }}">

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
                    <label for="" style="font-weight:bold;">Production:</label>
                    <select class="form-control" id="frontsale"  required name="production">
                    @foreach($employees as $pm)
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
                <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Services:</label>
                    <select class="form-control select2" name="services[]" multiple="multiple">
                        @foreach($productionservices as $productionservice)
                        <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                        @endforeach
                    </select>
                  </div>

                <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Any Comment:</label>
                    <textarea  name="Description" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-12">
                    <input type="submit" value="Add Production" class=" mt-3 btn btn-success">
                </div>
            </div>
           </form>


        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    <div class="br-pagebody">
        <div class="br-section-wrapper">
           <h2>Project Production:</h2>
              <button class="btn btn-outline-primary">Client Name: {{$projects[0]->ClientName->name }}</button>
              <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
              <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button>
              {{-- <button class="btn btn-outline-primary">Brand: {{$projects[0]->ClientName->projectbrand->name }}</button> --}}
              <br><br>

           <table class="table" id="datatable1"  >
              <tr>
                <td style="font-weight:bold;">Department</td>
                <td style="font-weight:bold;">Assignee</td>
                <td style="font-weight:bold;">Servies</td>
                <td style="font-weight:bold;">Description</td>
              </tr>
              <tbody>
                @foreach ($productions as $production)
                  <tr>
                    <td>{{ $production->DepartNameinProjectProduction->name }}</td>
                    <td>{{ $production->EmployeeNameinProjectProduction->name }}</td>
                    <td>{{ $production->services }}</td>
                    <td>{{ $production->anycomment}}</td>
                  </tr>
                @endforeach
              </tbody>
           </table>
           <div class="col-12">
            <a href="/client/details/{{$projects[0]->clientID }}"><button class=" mt-3 btn btn-success" >Submit</button></a>
        </div>
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
