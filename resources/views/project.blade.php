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
           <form action="/client/project/process" method="POST">
            @csrf
            <input type="hidden" name="productionID" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6)}}">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Project Name:</label>
                    <input type="text" required name="name" class="form-control" required>
                </div>


                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Client:</label>
                  <select class="form-control" id="select2forme" required name="client">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} -- {{ $client->email }} -- {{ $client->phone }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Select Project Manager:</label>
                  <select class="form-control select2" required name="pm">
                    @foreach ($employee as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                  <input type="text" required name="website" required class="form-control">
                </div>
                <div class="col-8 mt-3">
                  <label for="" style="font-weight:bold;">Basecamp Url</label>
                  <input type="text" required name="basecampurl" required class="form-control">
                </div>
                <div class="col-12 mt-3">
                  <label for="" style="font-weight:bold;">Project Description</label>
                 <textarea required name="openingcomments" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Salact Production"  name="" class="btn btn-success mt-2">
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
