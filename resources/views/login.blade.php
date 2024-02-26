<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>CRYSTAL PRO</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">
  </head>


  <body>

    <div class="row no-gutters flex-row-reverse ht-100v">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <form action="/loginProcess" method="POST">
            @csrf
          <h4 class="tx-inverse tx-center">Sign In</h4>
          <p class="tx-center mg-b-60">Welcome back my friend! Please sign in.</p>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your username" name="userName" required>
          </div><!-- form-group -->

          <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter your password" name="userPassword" required>
            <a href="" class="tx-12 d-block mg-t-10">Forgot password?</a>
          </div><!-- form-group -->
          <button type="submit" class="btn btn-success btn-block">Sign In</button>

          <div class="mg-t-60 tx-center">Not yet a member? <a href="/register">Sign Up</a></div>
        </form>
        </div><!-- login-wrapper -->
      </div><!-- col -->
      <div class="col-md-6 bg-primary d-flex align-items-center justify-content-center">
        <div class="wd-250 wd-xl-450 mg-y-30">
          <div class="signin-logo tx-28 tx-bold tx-white"><span class="tx-normal">[</span> Crystal <span class="tx-white-8">pro</span> <span class="tx-normal">]</span></div>
          <div class="tx-white-8 mg-b-60">Crystal lite QA ERP</div>

          <h5 class="tx-white">Why Crystal Pro?</h5>
          <p class="tx-white-6">When it comes to websites or apps, one of the first impression you consider is the design. It needs to be high quality enough otherwise you will lose potential users due to bad design.</p>
          <p class="tx-white-6 mg-b-60">When your website or app is attractive to use, your users will not simply be using it, they’ll look forward to using it. This means that you should fashion the look and feel of your interface for your users.</p>

        </div><!-- wd-500 -->
      </div>
    </div><!-- row -->

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/ui/widgets/datepicker.js') }} "></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  </body>
</html>
