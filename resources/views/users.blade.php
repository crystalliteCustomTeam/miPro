@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">User Management</a>
            <span class="breadcrumb-item active">Create User</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>User Management</h4>
            <p class="mg-b-0">Create User</p>
          </div>
        </div><!-- d-flex -->
  
        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="/createuser/process" method="POST">
            @csrf
            <div class="row">
            
                <div class="col-3">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for="">Extension</label>
                    <input type="text" name="extension" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for="">Brand</label>
                    <select class="form-control" name="selectBrand">
                        @foreach($Brands as $brand)
                            <option value="{{$brand->id}}">{{ $brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label for="">Generate Password </label>
                    <input type="text" class="form-control" minlength="8"  name="password" id="password" value="{{ substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,8); }}">

                </div>
                <div class="col-3">
                    <label for="">Position </label>
                    <input type="text" class="form-control" name="position">
                </div>
                
                <div class="col-3">
                    <br>
                    <input type="submit" value="Create" name="" class="btn btn-success mt-2">
                </div>
                <div class="col-4">
                        @if (Session::has('Success'))

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('Success') }}</strong>
                            <button type="button" class="btn btn-success" data-bs-dismiss="alert" aria-label="Close">X</button>
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
            <div class="mg-b-2">Copyright &copy; 2017. Bracket Plus. All Rights Reserved.</div>
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