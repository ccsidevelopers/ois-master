<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="_token">
    <title>Comprehensive Credit Services Inc.</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<!-- HTML5 Shim and Respond.js IE8 sup{{ asset('') }}port of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    {{--header icon--}}
    <link rel="icon" href="dist/img/ccsi-icon.ico">
</head>
<body>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <input type="text" id="bi_account" hidden>
                                <div class="box-title">Account/Project</div><small style="color: orange;"> (Optional Field)</small>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="project_name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <div class="box-title">LOB</div><small style="color: orange;"> (Optional Field)</small>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="bi_account_lob">
                                                <option value="-">-</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <div class="box-title">Select Package</div><small style="color: red;"> (Required Field)</small>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                    <span id="bi_package"><select class="form-control" id="type_package">
                                            <option name="-" value="-">-</option>
                                        </select></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <div class="box-title">Personal Information</div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Last Name:</label><small style="color: red;"> (Required Field)</small>
                                            <input type="text" class="form-control" id="acct_last">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Suffix Name:</label><small style="color: orange;"> (Optional Field)</small>
                                            <input type="text" class="form-control" id="acct_suffix">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Birth Day:</label><small style="color: red;"> (Required field)</small>
                                            <select class="form-control" id="acct_birthdate_day">
                                                <option value="-">-</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Age:</label><small style="color: red;"> (Required Field/Auto)</small>
                                            <input type="number" disabled="" class="form-control" id="acct_birthdate_age">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>First Name:</label><small style="color: red;"> (Required Field)</small>
                                            <input type="text" class="form-control" id="acct_first">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Gender:</label><small style="color: orange;"> (Optional Field)</small>
                                            <select class="acct_gender form-control" name="" id="acct_gender">
                                                <option value="-">-</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Birth Month:</label><small style="color: red;"> (Required field)</small>
                                            <select class="form-control" id="acct_birthdate_month">
                                                <option value="-">-</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Citizenship:</label><small style="color: orange;"> (Optional Field)</small>
                                            <input type="text" class="form-control" id="acct_citizenship">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Middle Name:</label><small style="color: orange;"> (Optional Field)</small>
                                            <input type="text" class="form-control" id="acct_middle">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Marital Status:</label><small style="color: orange;"> (Optional Field)</small>
                                            <select class="acct_marital_status form-control" name="" id="acct_marital_status">
                                                <option value="-">-</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Separated">Separated</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Birth Year:</label><small style="color: red;"> (Required field)</small>
                                            <select class="form-control" id="acct_birthdate_year"><option value="-">-</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option></select>
                                        </div>




                                    </div>
                                    <div hidden="" id="if_married_check" class="box">
                                        <div class="box-header with-border">IF MARRIED - Maiden Information: (This Row will only show if "Married" is selected)</div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>Maiden Last Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                    <input type="text" class="form-control" id="acct_maiden_last_name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Maiden First Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                    <input type="text" class="form-control" id="acct_maiden_first_name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Maiden Middle Name:</label><small style="color: orange;"> (Optional Field)</small>
                                                    <input type="text" class="form-control" id="acct_maiden_middle_name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <div class="box-title">Valid Government Issued ID Number/s</div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="">SSS Number:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <input type="text" class="form-control" id="accnt_sss_num">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">PhilHealth Number:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <input type="text" class="form-control" id="accnt_philhealth_num">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">Pag-ibig Number:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <input type="text" class="form-control" id="accnt_pag_ibig_number">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">Tax Identification Number:</label><small style="color: orange;"> (Optional Field)</small>
                                                                <input type="text" class="form-control" id="accnt_tin_number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="box box-danger">
                                        <div class="box-header with-border">
                                            <div class="box-title" style="font-weight: bold">Address/es</div>
                                        </div>
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <b>Present Address</b>
                                            </div>
                                            <div class="box-body">
                                                <div>
                                                    <div class="row">
                                                        <input type="hidden" id="bi_present_idProvince">
                                                        <input type="hidden" id="bi_present_idMunicipality">
                                                        <div class="form-group col-xs-4">
                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                            <input type="text" class="form-control" placeholder="" id="bi_present_address" name="address">
                                                        </div>
                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="" data-original-title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">
                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>
                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_present_municipality" name="municipality" autocomplete="off">
                                                        </div>
                                                        <div class="form-group col-xs-4">
                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_present_Prov"></span>
                                                            <input type="text" class="form-control" placeholder="" id="bi_present_province" name="province" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="checkbox" id="bi_check_same_address" value="same_address">
                                        <strong>
                                            Check if "Permanent Address" same as "Present Address"
                                        </strong>

                                        <div class="box" style="margin-top: 20px">
                                            <div class="box-header with-border">
                                                <b>Permanent Address</b>
                                            </div>
                                            <div class="box-body">
                                                <div>
                                                    <div class="row">
                                                        <input type="hidden" id="bi_permanent_idProvince">
                                                        <input type="hidden" id="bi_permanent_idMunicipality">
                                                        <div class="form-group col-xs-4">
                                                            <label>Unit #, Bldg/Street, Subd/Brgy.</label><small style="color: red;"> (Required Field)</small>
                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_address" name="address">
                                                        </div>
                                                        <div class="form-group col-xs-4" data-toggle="tooltip" title="" data-original-title="Please select city/municipality suggestion list appear below the textbox, this will be auto generate the province">
                                                            <label>City/Municipality</label><small style="color: red;"> (Required Field)</small>
                                                            <input type="text" class="form-control ui-autocomplete-input" placeholder="" id="bi_permanent_municipality" name="municipality" autocomplete="off">
                                                        </div>
                                                        <div class="form-group col-xs-4">
                                                            <label>Province</label><small style="color: red;"> (Auto Generated)</small><span id="loading_permanent_Prov"></span>
                                                            <input type="text" class="form-control" placeholder="" id="bi_permanent_province" name="province" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addAdditionalAddressBi">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-flat btn-block bg-gray pull-right" id="AddNewAddressBiClient"><i class="glyphicon glyphicon-plus"></i> Add Address</button>
                                            </div>
                                            <div id="remove_div" class="col-md-12" hidden="">
                                                <button class="btn btn-flat btn-block bg-gray pull-right" id="RemoveAddressBiClient"><i class="glyphicon glyphicon-minus"></i> Remove Address</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <div class="box-title">Attachments</div><small style="color: red;"> (Required atleast 1 attachment)</small>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Attachment 1 (TOR)</label>
                                        <input class="bi_attached_file" type="file" id="attach1">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Attachment 2(Application Form)</label>
                                        <input class="bi_attached_file" type="file" id="attach2">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Attachment 3(COE)</label>
                                        <input class="bi_attached_file" type="file" id="attach3">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Attachment 4(Others)</label>
                                        <input class="bi_attached_file" type="file" id="attach4">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" hidden>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <div class="box-title">Select Check</div><small style="color: red;"> (Required Field)</small>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                                                <span id="span_check_box_for_checkings">          <div class="row">
               <div class="form-group col-md-12">
                   <input type="checkbox" class="check_list_checking minimal-red" value="qwe"><strong> qwe</strong><span data-toggle="tooltip" title="qwe" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>               </div>
          </div>          <div class="row">
               <div class="form-group col-md-12">
                   <input type="checkbox" class="check_list_checking minimal-red" value="qwesad"><strong> qwesad</strong><span data-toggle="tooltip" title="asdqwe" style="margin-left: 5px" class="badge bg-black"><i class="fa fa-info"></i></span>               </div>
          </div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <div class="box-title">Endorsed By (Recruiter/BI POC)</div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Name of Endorser: </label><small style="color: red;"> (Required Field)</small>
                                    <input type="text" class="form-control" id="acct_endorsedby">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <button type="button" id="btn_bi_submit_endorsement" class="btn btn-success btn-lg pull-right" typee="direct">Submit</button>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>


<div class="modal modal-success fade" id="modal_success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Successfully endorsed. Thank you!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-warning fade" id="modal_loading">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Please wait..</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">We are processing your request. <img src="{{ asset('dist/img/loading.gif') }}" style="width: 5%;"></p>

                <span id="ulPercentage_attachment"></span>
                <div id="progressbar_attachment" hidden></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-danger fade" id="modal_error">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Oops something went wrong!</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Can't process your endorsement, Please contact the system administrator. Thank you.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-danger fade" id="modal_inc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Required Field.</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center">Please Complete All Required Field.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="{{ asset('jscript/bi.js') }}"></script>
<script src="{{ asset('jscript/directEndorse.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>





</body>
</html>
