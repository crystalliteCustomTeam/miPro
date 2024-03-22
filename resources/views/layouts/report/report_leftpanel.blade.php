
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft report-scroller">
        <form action="/allproject/report/{id?}" method="get">

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
                <label for="" style="font-weight:bold;">Select Brand:</label>
                <select class="form-control select2"  name="brand" onchange="createURL11(this.value)" >
                    <option value="0" >Select</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" >
                      {{ $brand->name }}
                    </option>
                @endforeach
              </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Select Client:</label>
                <select class="form-control select2"  name="client" onchange="createURL7(this.value)" >
                    <option value="0" >Select</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" >
                      {{ $client->name }}
                    </option>
                @endforeach
              </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Select Department:</label>
                <select class="form-control select2"  name="Production" onchange="createURL2(this.value)" >
                    <option value="0" >Select</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" >
                      {{ $department->name }}
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
                <label for="" style="font-weight:bold;">Status:</label>
                <select class="form-control select2"  name="status" onchange="createURL8(this.value)">
                    <option value="0" >Select</option>
                    <option value="Dispute">Dispute</option>
                    <option value="Refund">Refund</option>
                    <option value="On Going">On Going</option>
                    <option value="Not Started Yet">Not Started Yet</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Client Satisfaction Level:</label>
                <select class="form-control select2"  name="remarks" onchange="createURL9(this.value)">
                    <option value="0" >Select</option>
                    <option value="Extremely Satisfied">Extremely Satisfied</option>
                    <option value="Somewhat Satisfied">Somewhat Satisfied</option>
                    <option value="Neither Satisfied nor Dissatisfied">Neither Satisfied nor Dissatisfied</option>
                    <option value="Somewhat Dissatisfied">Somewhat Dissatisfied</option>
                    <option value="Extremely Dissatisfied">Extremely Dissatisfied</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Refund & Dispute Expected:</label>
                <select class="form-control select2"  name="expectedRefund" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="Going Good">Going Good</option>
                    <option value="Low">Low</option>
                    <option value="Moderate">Moderate</option>
                    <option value="High">High</option>
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
                        "issue": 0,
                        "client": 0,
                        "status": 0,
                        "remarks": 0,
                        "expectedRefund": 0,
                        "expectedRefund": 0
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

            function createURL7(value) {
                if (baseURL.hasOwnProperty("client")) {
                    // Update the existing "start" property
                    baseURL["client"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["client"] = value;
                }
                console.log(baseURL);
            }

            function createURL8(value) {
                if (baseURL.hasOwnProperty("status")) {
                    // Update the existing "start" property
                    baseURL["status"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["status"] = value;
                }
                console.log(baseURL);
            }

            function createURL9(value) {
                if (baseURL.hasOwnProperty("remarks")) {
                    // Update the existing "start" property
                    baseURL["remarks"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["remarks"] = value;
                }
                console.log(baseURL);
            }

            function createURL10(value) {
                if (baseURL.hasOwnProperty("expectedRefund")) {
                    // Update the existing "start" property
                    baseURL["expectedRefund"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["expectedRefund"] = value;
                }
                console.log(baseURL);
            }

            function createURL11(value) {
                if (baseURL.hasOwnProperty("brand")) {
                    // Update the existing "start" property
                    baseURL["brand"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["brand"] = value;
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
