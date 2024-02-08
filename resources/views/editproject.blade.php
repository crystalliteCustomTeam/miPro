@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Set Up Client project</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Client Project </h4>
            <p class="mg-b-0">Client Project </p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">Client Project Information:</h4>
            @foreach ($projects as $project)

           <form action="/client/editproject/{{$project->id}}/process" method="POST">
            @csrf

            <div class="row">
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Project Name:</label>
                    <input type="text" required name="name" class="form-control" required value="{{$project->name}}">
                </div>


                <div class="col-5 mt-3">
                  <label for="" style="font-weight:bold;">Client:</label>
                  <select class="form-control" id="select2forme" required name="client">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"{{ $client->id == $project->clientID ? 'selected' : '' }}>{{ $client->name }} -- {{ $client->email }} -- {{ $client->phone }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Select Project Manager:</label>
                  <select class="form-control select2" required name="pm">
                    @foreach ($employee as $client)
                        <option value="{{ $client->id }}" {{ $client->id == $project->projectManager ? 'selected' : '' }}>{{ $client->name }} </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Select Production:</label>
                    <select class="form-control select2" required name="production">
                      @foreach ($employee as $client)
                          <option value="{{ $client->id }}" {{ $client->id == $project->productionID ? 'selected' : '' }}>{{ $client->name }}</option>
                      @endforeach
                    </select>
                  </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                  <input type="text" required name="website" required class="form-control" value="{{$project->domainOrwebsite}}">
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Basecamp Url</label>
                  <input type="text" required name="basecampurl" required class="form-control"  value="{{$project->basecampUrl}}">
                </div>

                <div class="col-12 mt-3">
                  <label for="" style="font-weight:bold;">Project Description</label>
                 <textarea required name="openingcomments" class="form-control" id="" cols="30" rows="10" >{{$project->projectDescription}}</textarea>
                </textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Update"  name="" class="btn btn-success mt-2">
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
           @endforeach







@endsection
