
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft sideleft-scrollbar">
    <form action="#" method="post">

        <div class="col-12 mt-3">
            <label for="">Start Date:</label><br>
            <input  class="form-control" type="Date" name="startdate">
        </div>
        <div class="col-12 mt-3">
            <label for="">End Date:</label><br>
            <input  class="form-control" type="Date" name="enddate">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Select Production:</label>
            <select class="form-control select2"  name="department">
            @foreach($projectproductions as $project)
                <option value="{{ $project->id }}">
                  {{ $project->DepartNameinProjectProduction->name }}
                </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 mt-3">
           <input type="submit" value="Search" class=" mt-3 btn btn-success">
        </div>

    </form>


  <br>
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
