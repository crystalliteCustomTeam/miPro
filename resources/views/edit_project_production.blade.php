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
            @foreach ($projectProductions as $projectProduction)
           <form action="/client/project/editproduction/{{ $projectProduction->id }}/process" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Department: </label>
                    <select class="form-control select2" name="department">
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}"{{ $department->id == $projectProduction->departmant ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Production:</label>
                    <select class="form-control" id="frontsale"  required name="production">
                    @foreach($employees as $pm)
                        <option value="{{ $pm->id }}"{{ $pm->id == $projectProduction->responsible_person ? 'selected' : '' }}>
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
                        <option value="selected">{{$projectProduction->services}}</option>
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
                    <label for="" style="font-weight:bold;">Any Comment:</label>
                    <textarea  name="Description" class="form-control" id="" cols="30" rows="10">{{$projectProduction->anycomment}}</textarea>
                </div>
                <div class="col-12">
                    <input type="submit" value="Add Production" class=" mt-3 btn btn-success">
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
