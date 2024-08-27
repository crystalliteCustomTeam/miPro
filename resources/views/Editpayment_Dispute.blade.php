@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Client Edit Dispute:</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Dispute</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
                @foreach ($client_payment as $item)
                    <form action="/client/project/payment/EditDispute/process/{{$item->id}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                                <label for="" style="font-size:150%;">{{$item->disputeclientName->name }}</label>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                                <label for="" style="font-size:150%;">
                                    @if (isset($item->disputeprojectName->name) && $item->disputeprojectName->name != null)
                                    {{$item->disputeprojectName->name }}
                                    @else
                                        undefined
                                    @endif
                                </label>
                            </div>
                            <div class="col-4 mt-3">
                                <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                                @if (isset($item->disputeEmployeeName->name) and $item->disputeEmployeeName->name !== null)
                                <label for="" style="font-size:150%;">{{$item->disputeEmployeeName->name }}</label>
                                @else
                                <label for="" style="font-size:150%;"><p style="color: red">User Deleted</p></label>
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Chargeback Type:</label>
                                <select class="form-control select2" required name="chargebacktype" >
                                    <option value="Dispute" selected>Dispute</option>
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Dispute Date:</label>
                                @if ($theme == 1)
                            <input type="date"  required name="disputedate" class="form-control-dark wd-600" style="height: 50px;" value="{{$item->dispute_Date}}">
                            @else
                            <input type="date" class="form-control" required name="disputedate" value="{{$item->dispute_Date}}">
                            @endif
                            </div>

                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;" >Account Manager:</label>
                                <select class="form-control select2" required name="accountmanager">
                                @foreach ($pmemployee as $client)
                                        @if (isset($item->ProjectManager) and $item->ProjectManager !== null)
                                        <option value="{{ $client->id }}"{{ $client->id == $item->ProjectManager ? 'selected' : '' }}>{{ $client->name }}
                                        --
                                        @else
                                        <option value="{{ $client->id }}">{{ $client->name }}
                                        --
                                        @endif
                                        @foreach($client->deparment($client->id)  as $dm)
                                        <strong>{{ $dm->name }}</strong>
                                        @endforeach
                                    </option>
                                @endforeach
                                </select>
                            </div>


                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Dispute amount</label>
                                @if ($theme == 1)
                                <input type="text" class="form-control-dark wd-600" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" required style="height: 50px;" value="{{$item->disputedAmount}}">
                                @else
                                <input id="amountPaid" type="text" class="form-control" required onkeypress="return /[0-9]/i.test(event.key)" name="clientpaid" value="{{$item->disputedAmount}}">
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Dispute Fee</label>
                                @if ($theme == 1)
                            <input type="text" class="form-control-dark wd-600" placeholder="  Enter Name" onkeypress="return /[0-9]/i.test(event.key)" name="disputefee" required style="height: 50px;" value="{{$item->disputefee}}">
                            @else
                            <input id="disputefee" type="text" class="form-control" required  onkeypress="return /[0-9]/i.test(event.key)" name="disputefee" value="{{$item->disputefee}}">
                            @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Payments Include:</label>
                                <select class="form-control select2" required name="chargebacktype"  id="chargebacktype" >
                                    <option value="this" >This</option>
                                    <option value="this and remaining" >This and Remaining</option>
                                    <option value="all payments" >All Payments</option>
                            </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="" style="font-weight:bold;">Dispute Reason:</label><br>
                                @if ($theme == 1)
                                <textarea required name="description" class="form-control-dark wd-1000" id="desc" cols="30" rows="10">{{$item->disputeReason}}</textarea>
                                @else
                                <textarea required name="description" class="form-control" id="desc" cols="30" rows="10">{{$item->disputeReason}}</textarea>
                                @endif
                            </div>
                            <div class="col-12 mt-3">
                                <br><br>
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
                @endforeach


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
