@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Brand</a>
            <span class="breadcrumb-item active">Set Up Roles</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Brand Sales Team</h4>
            <p class="mg-b-0">Brand Sales Team</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            @foreach ($allleads as $item1)
            <form action="/sales/originalroles/process/edit/{{$item1->id}}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-6 mt-3">
                            <label for="" style="font-weight:bold;">Name:</label>
                            @if ($theme == 1)
                            <input type="text" name="name" class="form-control-dark wd-600" value="{{$item1->Name}}" placeholder="  Enter Name" required style="height: 50px;">
                            @else
                            <input type="text" name="name" class="form-control" value="{{$item1->Name}}" required>
                            @endif
                    </div>

                    <div class="col-6 mt-3">
                        <label for="" style="font-weight:bold;">Brand:</label>
                        <select class="form-control select2" required name="brand">
                            @foreach ($brand as $brands)
                                <option value="{{ $brands->id }}"{{ $brands->id == $item1->Brand ? 'selected' : '' }}>{{ $brands->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Select Front</label>
                            @php
                                $usersIndepartment = json_decode($item1->Front);
                            @endphp
                            <select class="form-control select2" name="front[]" multiple="multiple">
                                @foreach ($employees as $client)
                                @php
                                    $matched = false;
                                @endphp
                                    @foreach ($usersIndepartment as $item)
                                        @if ($client->id == $item)
                                            @php
                                                $matched = true;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                @if ($matched)
                                    <option value="{{ $client->id }}" selected>{{ $client->name }}
                                        --
                                        @foreach($client->deparment($client->id)  as $dm)
                                        <strong>{{ $dm->name }}</strong>
                                        @endforeach
                                    </option>
                                @endif

                                <option value="{{ $client->id }}">{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-12 mt-3">
                        <label for="" style="font-weight:bold;">Select Support</label>
                        @php
                            $usersIndepartment1 = json_decode($item1->Front);
                        @endphp
                        <select class="form-control select2" name="Support[]" multiple="multiple">
                            @foreach ($employees as $client)
                            @php
                                $matched = false;
                            @endphp
                                @foreach ($usersIndepartment1 as $item)
                                    @if ($client->id == $item)
                                        @php
                                            $matched = true;
                                        @endphp
                                        @break;
                                    @endif
                                @endforeach

                            @if ($matched)
                                <option value="{{ $client->id }}" selected>{{ $client->name }}
                                    --
                                    @foreach($client->deparment($client->id)  as $dm)
                                    <strong>{{ $dm->name }}</strong>
                                    @endforeach
                                </option>
                            @endif

                            <option value="{{ $client->id }}">{{ $client->name }}
                                --
                                @foreach($client->deparment($client->id)  as $dm)
                                <strong>{{ $dm->name }}</strong>
                                @endforeach
                            </option>
                        @endforeach
                        </select>
                    </div>


                    <div class="col-4">
                        <br>
                        <input type="submit" value="Update" name="" class="btn btn-success mt-2">
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

            @endforeach










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
