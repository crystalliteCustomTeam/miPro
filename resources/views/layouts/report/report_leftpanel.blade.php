
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft sideleft-scrollbar">
    <form action="/project/report/{{$projects[0]->id}}" method="get">

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
            <select class="form-control select2"  name="Production">
            @foreach($projectproductions as $project)
                <option value="{{ $project->id }}" >
                  {{ $project->DepartNameinProjectProduction->name }}
                </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Brand:</label>
            <select class="form-control select2"  name="brand">
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">
                  {{ $brand->name }}
                </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Department:</label>
            <select class="form-control select2"  name="department">
            @foreach($departments as $department)
                <option value="{{ $department->id }}">
                  {{ $department->name }}
                </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Employee:</label>
            <select class="form-control select2"  name="employee">
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">
                  {{ $employee->name }}
                  --
                  @foreach($employee->deparment($employee->id)  as $dm)
                            <strong>{{ $dm->name }}</strong>
                          @endforeach

                </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Issues:</label>
            <select class="form-control select2"  name="issues">
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}">
                        {{ $issue->issues }}
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
