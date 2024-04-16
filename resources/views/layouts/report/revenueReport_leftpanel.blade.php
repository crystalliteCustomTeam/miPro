
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft report-scroller">
        <form action="/client/revenue/{id?}" method="get">

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Type:</label>
                {{-- <select class="form-control select2"  name="type" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="Received" >Received</option>
                    <option value="Upcoming" >Upcoming</option>
                    <option value="Missed" >Missed</option>
                </select> --}}
                @if(isset($_GET['type']))
                <select class="form-control select2"  name="type" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="{{ $_GET['type'] }}" selected>{{ $_GET['type'] }}</option>
                    <option value="Received" >Received</option>
                    <option value="Upcoming" >Upcoming</option>
                    <option value="Missed" >Missed</option>
                </select>
                @else
                <select class="form-control select2"  name="type" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="Received" >Received</option>
                    <option value="Upcoming" >Upcoming</option>
                    <option value="Missed" >Missed</option>
                </select>
                @endif
            </div>

            <input type="hidden" id="data" name="datas">

            <div class="col-12 mt-3">
                <label for="">Start Date:</label><br>
                @if(isset($_GET['startdate']))
                      <input onchange="createURL(this.value)" value="{{ $_GET['startdate'] }}" class="form-control" type="Date" name="startdate">
                @else
                 <input onchange="createURL(this.value)"  class="form-control" type="Date" name="startdate">
                @endif

            </div>

            <div class="col-12 mt-3">
                <label for="">End Date:</label><br>
                @if(isset($_GET['enddate']))

                      <input onchange="createURL1(this.value)"   value="{{ $_GET['enddate'] }}" class="form-control" type="Date" name="enddate">
                @else
                    <input onchange="createURL1(this.value)"    class="form-control" type="Date" name="enddate">
                @endif

            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Select Brand:</label>
                <select class="form-control select2"  name="brand" onchange="createURL2(this.value)" >
                    <option value="0" >Select</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">
                      {{ $brand->name }}
                    </option>
                @endforeach
              </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Charging Mode:</label>
                <select class="form-control select2"  name="chargingMode" onchange="createURL11(this.value)">
                    <option value="0" >Select</option>
                    <option value="Renewal">Renewal</option>
                    <option value="Recurring">Recurring</option>
                    <option value="One Time Payment">One Time Payment</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Payment Nature:</label>
                <select class="form-control select2"  name="paymentNature" onchange="createURL12(this.value)">
                    <option value="0" >Select</option>
                    <option value="New Lead">New Lead</option>
                    <option value="New Sale">New Sale</option>
                    <option value="Renewal Payment">Renewal Payment</option>
                    <option value="Recurring Payment">Recurring Payment</option>
                    <option value="Small Payment">Small Payment</option>
                    <option value="Upsell">Upsell</option>
                    <option value="Remaining">Remaining</option>
                    <option value="One Time Payment">One Time Payment</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Project Manager:</label>
                <select class="form-control select2"  name="projectmanager" onchange="createURL3(this.value)">
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
                <label for="" style="font-weight:bold;">Select Client:</label>
                <select class="form-control select2"  name="client" onchange="createURL4(this.value)" >
                    <option value="0" >Select</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" >
                      {{ $client->name }}
                    </option>
                @endforeach
              </select>
            </div>

            <div class="col-12 mt-3">
                <label for="" style="font-weight:bold;">Status:</label>
                <select class="form-control select2"  name="status" onchange="createURL7(this.value)">
                    <option value="0" >Select</option>
                    <option value="On Going">On Going</option>
                    <option value="Dispute">Dispute</option>
                    <option value="Refund">Refund</option>
                </select>
            </div>

            <div class="col-12 mt-3">
               <input type="submit" value="Search" onsubmit="url()" class=" mt-3 btn btn-success">
            </div>

        </form>

        <script>
            var baseURL = {
                        "type": 0,
                        "start" : 0,
                        "end" : 0,
                        "brand" : 0,
                        "chargingMode" : 0,
                        "paymentNature" : 0,
                        "projectmanager" : 0,
                        "client": 0,
                        "status": 0,
                    };


            function createURL10(value) {
                if (baseURL.hasOwnProperty("type")) {
                    // Update the existing "start" property
                    baseURL["type"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["type"] = value;
                }
                console.log(baseURL);
            }

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
                if (baseURL.hasOwnProperty("brand")) {
                    // Update the existing "start" property
                    baseURL["brand"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["brand"] = value;
                }
                console.log(baseURL);
            }

            function createURL11(value) {
                if (baseURL.hasOwnProperty("chargingMode")) {
                    // Update the existing "start" property
                    baseURL["chargingMode"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["chargingMode"] = value;
                }
                console.log(baseURL);
            }

            function createURL12(value) {
                if (baseURL.hasOwnProperty("paymentNature")) {
                    // Update the existing "start" property
                    baseURL["paymentNature"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["paymentNature"] = value;
                }
                console.log(baseURL);
            }

            function createURL3(value) {
                if (baseURL.hasOwnProperty("projectmanager")) {
                    // Update the existing "start" property
                    baseURL["projectmanager"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["projectmanager"] = value;
                }
                console.log(baseURL);
            }

            function createURL4(value) {
                if (baseURL.hasOwnProperty("client")) {
                    // Update the existing "start" property
                    baseURL["client"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["client"] = value;
                }
                console.log(baseURL);
            }

            function createURL7(value) {
                if (baseURL.hasOwnProperty("status")) {
                    // Update the existing "start" property
                    baseURL["status"] = value;
                } else {
                    // If "start" property doesn't exist, add it
                    baseURL["status"] = value;
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
