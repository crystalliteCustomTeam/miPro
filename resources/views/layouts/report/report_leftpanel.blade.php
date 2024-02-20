
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft sideleft-scrollbar">
    <form action="/project/report/{{$projects[0]->id}}" method="get">

        <input type="hidden" id="data" name="datas">

        <div class="col-12 mt-3">
            <label for="">Start Date:</label><br>
            <input onchange="createURL(this.value)" class="form-control" type="Date" name="startdate">
        </div>
        <div class="col-12 mt-3">
            <label for="">End Date:</label><br>
            <input onchange="createURL1(this.value)" class="form-control" type="Date" name="enddate">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Select Production:</label>
            <select class="form-control select2"  name="Production" onchange="createURL2(this.value)" >
                <option value="0" >Select</option>
            @foreach($projectproductions as $project)
                <option value="{{ $project->id }}" >
                  {{ $project->DepartNameinProjectProduction->name }}
                </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Employee:</label>
            <select class="form-control select2"  name="employee" onchange="createURL5(this.value)">
                <option value="0" >Select</option>
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
            <select class="form-control select2"  name="issues" onchange="createURL6(this.value)">
                <option value="0" >Select</option>
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}">
                        {{ $issue->issues }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="col-12 mt-3">
           <input type="submit" value="Search" onsubmit="url()" class=" mt-3 btn btn-success">
        </div>

    </form>

    <script>
    var baseURL = {
                "start" : 0,
                "end" : 0,
                "production": 0,
                "employee": 0,
                "issue": 0
            };


    function createURL(value) {
        if (baseURL.hasOwnProperty("start")) {
            // Update the existing "start" property
            baseURL["start"] = value;
        } else {
            // If "start" property doesn't exist, add it
            baseURL["start"] = value;
        }
        console.log(baseURL);
    }

    function createURL1(value) {
        if (baseURL.hasOwnProperty("end")) {
            // Update the existing "start" property
            baseURL["end"] = value;
        } else {
            // If "start" property doesn't exist, add it
            baseURL["end"] = value;
        }
        console.log(baseURL);
    }

    function createURL2(value) {
        if (baseURL.hasOwnProperty("production")) {
            // Update the existing "start" property
            baseURL["production"] = value;
        } else {
            // If "start" property doesn't exist, add it
            baseURL["production"] = value;
        }
        console.log(baseURL);
    }

    function createURL5(value) {
        if (baseURL.hasOwnProperty("employee")) {
            // Update the existing "start" property
            baseURL["employee"] = value;
        } else {
            // If "start" property doesn't exist, add it
            baseURL["employee"] = value;
        }
        console.log(baseURL);
    }

    function createURL6(value) {
        if (baseURL.hasOwnProperty("issue")) {
            // Update the existing "start" property
            baseURL["issue"] = value;
        } else {
            // If "start" property doesn't exist, add it
            baseURL["issue"] = value;
        }
        console.log(baseURL);
    }

    var out = [];

    function url(){
    for (var key in baseURL) {
    if (baseURL.hasOwnProperty(key)) {
        out.push(key + '=' + encodeURIComponent(baseURL[key]));
    }
}

out.join('&');

document.getElementById("data").value = out



    }


    </script>
  <br>
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
