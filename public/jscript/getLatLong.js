
// $.ajaxSetup
// ({
//     headers:
//         {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
// });
//


jQuery(function() {
    // Asynchronously Load the map API
    var script = document.createElement('script');
    script.src = "https://maps.google.com/maps/api/js?key=AIzaSyBZjFXswzldW3AE2oDOzb7Sm0DJVp3lDNQ&callback=initialise";
    document.body.appendChild(script);
});

var time_out = '';

function toast_error_timeout() {
    time_out = setTimeout(function () {
        $('#modal-update-location').modal('hide');

        setTimeout(function () {

            toastr.options =
                {
                    "closeButton": true,
                    "debug": true,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "10000",
                    "extendedTimeOut": "5000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            toastr["error"]("It seems we cannot detect your location at this moment, please make sure that your GPS is on. Please try again later.","Location Update Failed!");

            //save login_logs even failed
            $.ajax({
                type: 'get',
                url: 'cicheckeroffline/address',
                data:
                    {
                        'id': "check",
                        'address' : "cannot detect gps",
                        'lat' : "0",
                        'long' : "0"
                    },
                success: function (dataa)
                {
                    console.log(dataa);
                },
                error: function () {
                    console.log('error');
                    window.close();
                },
                complete: function () {
                    window.close();
                }
            });


        },1000);
    },30000)
}

$('#location_Check').click(function ()
{
    initialise();
    $('#modal-update-location').modal('show');
});
//
// $('#locationviewer').click(function () {
//
//     // console.log($(this).attr('name'));
//
//     var getlatlong = $(this).attr('name');
//     var split = getlatlong.split(':');
//     // console.log(split[1]+"-"+split[2]);'
//     //
//     // var str = "Free Web Building Tutorials!";
//     // var result = str.link("https://www.w3schools.com");
//     // document.getElementById("demo").innerHTML = result;
//
//
//     //
//     // map.panTo(new google.maps.LatLng(split[1], split[2]));
//     // map.setZoom(20);
//
//
// });

function initialise()
{
    if(geoPosition.init())
    {
        geoPosition.getCurrentPosition(showPosition);
        console.log("no latlong");
        console.log(geoPosition);
        toast_error_timeout();

        // $('#TextInfoLoc').html('<p style="color: red">Updating location failed, Please try again.</p>\<p style="color: red">(add "https://" in the beggining of url or try to refresh the page)</p>');

    }
    else
    {
        console.log("Functionality not available");
    }
}

function showPosition(p)
{
    var latitude = parseFloat( p.coords.latitude );
    var longitude = parseFloat( p.coords.longitude );

    console.log(p);

    setTimeout(function () {
        $.ajax({
            url: '/ci-dashboard-passdatalatlong',
            type: 'get',
            data:
                {
                    'latitude': latitude,
                    'longitude' : longitude,
                    // 'address' : todayValue.results[0].formatted_address
                },
            success: function (data) {

                console.log('passdatacomplete: '+data);
                // alert('Location Updated.')
                $('#update_text').html('Success updating your location!');

            },
            error: function (data) {
                console.log('error passing data');

                alert('Cannot find your location, please open your GPS or allow location service in your browser.')
            },
            complete: function () {

                console.log("lat :"+latitude);
                console.log("long :"+longitude);
                console.log("have latlong");
                clearTimeout(time_out);
                get_loc(latitude,longitude);

                setTimeout(function () {
                    // $('#modal-update-location').attr('class','modal modal-warning fade');
                    $('#modal-update-location').modal('hide');

                    $('#update_text').html('Please wait.. <img width="10%" src="dist/img/loading.gif">');

                    toastr["success"]("Your location is updated, and you are marked as online.", "Location updated!");
                    toastr.options =
                        {
                            "closeButton": true,
                            "debug": true,
                            "newestOnTop": true,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };

                },1000)

            }

        });

        // $('#TextInfoLoc').html('<p style="color: green">Location updated successfully!</p>');

    },3000);
}

function get_loc(lat,long) {


    save_loc('check','no address found',lat,long);


}


function save_loc(id,loc,lat,long)
{

    $.ajax({
        type: 'get',
        url: 'cicheckeroffline/address',
        data:
            {
                'id': id,
                'address' : loc,
                'lat' : lat,
                'long' : long
            },
        success: function (dataa)
        {
            console.log('good');
        },
        error: function () {
            console.log('error');
            window.close();
        },
        complete: function () {
            window.close();
        }
    });

}
var geoPosition=function() {

    var pub = {};
    var provider=null;
    var u="undefined";
    var ipGeolocationSrv = 'https://freegeoip.net/json/?callback=JSONPCallback';

    pub.getCurrentPosition = function(success,error,opts)
    {
        provider.getCurrentPosition(success, error,opts);
    };

    pub.jsonp = {
        callbackCounter: 0,

        fetch: function(url, callback) {
            var fn = 'JSONPCallback_' + this.callbackCounter++;
            window[fn] = this.evalJSONP(callback);
            url = url.replace('=JSONPCallback', '=' + fn);

            var scriptTag = document.createElement('SCRIPT');
            scriptTag.src = url;
            document.getElementsByTagName('HEAD')[0].appendChild(scriptTag);
        },

        evalJSONP: function(callback) {
            return function(data) {
                callback(data);
            }
        }
    };

    pub.confirmation = function()
    {
        return confirm('CCSI Tracks.\nYou need to allow this.');
    };

    pub.init = function()
    {
        try
        {
            var hasGeolocation = typeof(navigator.geolocation)!=u;
            if( !hasGeolocation ){
                if( !pub.confirmation() ){
                    return false;
                }
            }

            if ( ( typeof(geoPositionSimulator)!=u ) && (geoPositionSimulator.length > 0 ) ){
                provider=geoPositionSimulator;
            } else if (typeof(bondi)!=u && typeof(bondi.geolocation)!=u  ) {
                provider=bondi.geolocation;
            } else if ( hasGeolocation ) {
                provider=navigator.geolocation;
                pub.getCurrentPosition = function(success, error, opts) {
                    function _success(p) {
                        //for mozilla geode,it returns the coordinates slightly differently
                        var params;
                        if(typeof(p.latitude)!=u) {
                            params = {
                                timestamp: p.timestamp,
                                coords: {
                                    latitude:  p.latitude,
                                    longitude: p.longitude
                                }
                            };
                        } else {
                            params = p;
                        }
                        success( params );
                    }
                    provider.getCurrentPosition(_success,error,opts);
                }
            } else if(typeof(window.blackberry)!=u && blackberry.location.GPSSupported) {
                // set to autonomous mode
                if(typeof(blackberry.location.setAidMode)==u) {
                    return false;
                }
                blackberry.location.setAidMode(2);
                //override default method implementation
                pub.getCurrentPosition = function(success,error,opts)
                {
                    //passing over callbacks as parameter didn't work consistently
                    //in the onLocationUpdate method, thats why they have to be set outside
                    bb.success = success;
                    bb.error = error;
                    //function needs to be a string according to
                    //http://www.tonybunce.com/2008/05/08/Blackberry-Browser-Amp-GPS.aspx
                    if(opts['timeout']) {
                        bb.blackberryTimeoutId = setTimeout("handleBlackBerryLocationTimeout()",opts['timeout']);
                    } else {
                        //default timeout when none is given to prevent a hanging script
                        bb.blackberryTimeoutId = setTimeout("handleBlackBerryLocationTimeout()",60000);
                    }
                    blackberry.location.onLocationUpdate("handleBlackBerryLocation()");
                    blackberry.location.refreshLocation();
                };
                provider = blackberry.location;

            } else if ( typeof(Mojo) !=u && typeof(Mojo.Service.Request)!="Mojo.Service.Request") {
                provider = true;
                pub.getCurrentPosition = function(success, error, opts) {
                    parameters = {};
                    if( opts ) {
                        if (opts.enableHighAccuracy && opts.enableHighAccuracy == true ){
                            parameters.accuracy = 1;
                        }
                        if ( opts.maximumAge ) {
                            parameters.maximumAge = opts.maximumAge;
                        }
                        if (opts.responseTime) {
                            if( opts.responseTime < 5 ) {
                                parameters.responseTime = 1;
                            } else if ( opts.responseTime < 20 ) {
                                parameters.responseTime = 2;
                            } else {
                                parameters.timeout = 3;
                            }
                        }
                    }

                    r = new Mojo.Service.Request( 'palm://com.palm.location' , {
                        method:"getCurrentPosition",
                        parameters:parameters,
                        onSuccess: function( p ){
                            success( { timestamp: p.timestamp,
                                coords: {
                                    latitude:  p.latitude,
                                    longitude: p.longitude,
                                    heading:   p.heading
                                }
                            });
                        },
                        onFailure: function( e ){
                            if (e.errorCode==1) {
                                error({ code:       3,
                                    message:    "Timeout"
                                });
                            } else if (e.errorCode==2){
                                error({ code:       2,
                                    message:    "Position unavailable"
                                });
                            } else {
                                error({ code:       0,
                                    message:    "Unknown Error: webOS-code" + errorCode
                                });
                            }
                        }
                    });
                }

            }
            else if (typeof(device)!=u && typeof(device.getServiceObject)!=u) {
                provider=device.getServiceObject("Service.Location", "ILocation");

                //override default method implementation
                pub.getCurrentPosition = function(success, error, opts){
                    function callback(transId, eventCode, result) {
                        if (eventCode == 4) {
                            error({message:"Position unavailable", code:2});
                        } else {
                            //no timestamp of location given?
                            success( {  timestamp:null,
                                coords: {
                                    latitude:   result.ReturnValue.Latitude,
                                    longitude:  result.ReturnValue.Longitude,
                                    altitude:   result.ReturnValue.Altitude,
                                    heading:    result.ReturnValue.Heading }
                            });
                        }
                    }
                    //location criteria

                    var criteria = new Object();
                    criteria.LocationInformationClass = "BasicLocationInformation";
                    //make the call
                    provider.ILocation.GetLocation(criteria,callback);
                }
            } else  {
                pub.getCurrentPosition = function(success, error, opts) {
                    pub.jsonp.fetch(ipGeolocationSrv,
                        function( p ){ success( { timestamp: p.timestamp,
                            coords: {
                                latitude:   p.latitude,
                                longitude:  p.longitude,
                                heading:    p.heading
                            }
                        });});
                };
                provider = true;
            }
        }
        catch (e){
            if( typeof(console) != u ) console.log(e);
            return false;
        }
        return  provider!=null;
    };
    return pub;
}();

//
// javascript-mobile-desktop-geolocation
// https://github.com/estebanav/javascript-mobile-desktop-geolocation
//
// Copyright J. Esteban Acosta Villafañe
// Licensed under the MIT licenses.
//
// Based on Stan Wiechers > geo-location-javascript v0.4.8 > http://code.google.com/p/geo-location-javascript/
//
// Revision: $Rev: 01 $:
// Author: $Author: estebanav $:
// Date: $Date: 2012-09-07 23:03:53 -0300 (Fri, 07 Sep 2012) $:


var geoPositionSimulator=function(){
    var pub = {};
    var currentPosition=null;
    /*
    * Example:
    * array = [ { coords: {
    *						latitude: 	30.293095,
    *						longitude: 	-97.5763955
    *						}
    *			}]
    *
    */
    pub.init = function(array)
    {
        var next=0;
        for (i in array)
        {
            if( i == 0 )
            {
                currentPosition=array[i];
            }
            else
            {
                setTimeout((function(pos) {
                    return function() {
                        currentPosition=pos;
                    }
                })(array[i]),next);
            }
            next+=array[i].duration;
        }
    };

    pub.getCurrentPosition = function(locationCallback,errorCallback)
    {
        locationCallback(currentPosition);
    };
    return pub;
}();

get_uploader_attendace();

var itemCounterAttendance = [];

function get_uploader_attendace()
{
    var datenow = new Date();
    var month = (parseInt(datenow.getMonth()) + 1);
    var day = datenow.getDate();
    if(month < 10)
    {
        month = '0' + month;
    }

    if(day < 10)
    {
        day = '0' + day;
    }

    var dateNow = datenow.getFullYear() + '' + month + '' + day + '' + datenow.getHours() + '' + datenow.getMinutes() + '' + datenow.getSeconds() + '' + datenow.getMilliseconds();
    var dateNowAjax = datenow.getFullYear() + '' + month + '' + day;

    $('#attendance-fine').html('');

    fineupload = new $('#attendance-fine').fineUploader
    ({
        template: 'qq-attendance-template-manual-trigger',
        request:
            {
                endpoint: 'ci_upload_pic_daily_fineuploader/' + dateNow,
                customHeaders:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
        thumbnails:
            {
                placeholders:
                    {
                        waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                        notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                    }
            },
        retry:
            {
                enableAuto: true,
                maxAutoAttempts: 5
            },
        scaling:
            {
                sendOriginal: false,
                sizes:
                    [
                        {maxSize: 800}
                    ]
            },
        validation:
            {
                itemLimit: 5,
                allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp']
                // allowedExtensions: ['jpe', 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw']
            },
        callbacks:
            {
                onStatusChange: function (id,status_old,status_new)
                {
                    item_status = status_new;

                    if(status_new == 'submitted')
                    {
                        itemCounterAttendance.push(this.getName(id));
                    }
                    else if(status_new == 'canceled')
                    {
                        itemCounterAttendance.pop();
                    }
                },
                onComplete: function (id)
                {

                },
                onAllComplete: function (id)
                {
                    $('#submitPhotoAttendance').attr('disabled', false);

                    itemCounterAttendance = [];
                    $.ajax({
                        type: 'get',
                        url: 'ci_update_attendace_photo',
                        data: {
                            'unang_folder' : dateNowAjax,
                            'pangalawang_folder' : dateNow
                        },
                        success: function(data)
                        {
                            $('#modal-upload-selfie-daily').modal('hide');
                            alert('Attendance picture successfully uploaded.');
                        },
                        error: function(e)
                        {
                            console.log(e);
                            alert('Attendance picture failed to upload. Contact administrator for assistance');
                        }
                    });

                    get_uploader_attendace();
                    // setTimeout(function()
                    // {
                    //     $('#wait-loading').modal('hide');
                    //     submittedFilesArray = [];
                    // }, 500);
                    //
                    // alert('Encoded Successfully');
                    //
                    // setTimeout(function()
                    // {
                    //     window.location.reload();
                    // }, 1000);
                }
            },
        autoUpload: false,
        maxConnections: 1
    });

}

$('#submitPhotoAttendance').click(function()
{
    var btn = $(this);
    if(itemCounterAttendance.length > 0)
    {
        btn.attr('disabled', true);
        $('#attendance-fine').fineUploader('uploadStoredFiles');
    }
    else
    {
        alert('Attach a photo for attendance');
    }

    // var btn = $(this);
    // btn.attr('disabled', true);
    //
    // var fileSelf = $('#ci_selfie_daily').prop('files')[0];
    //
    // var formData = new FormData;
    //
    // formData.append('file', fileSelf);
    //
    // if($('#ci_selfie_daily').val() != '')
    // {
    //     if(fileSelf.type == 'image/jpeg' || fileSelf.type == 'image/gif' || fileSelf.type == 'image/png')
    //     {
    //         $.ajax
    //         ({
    //             xhr: function() {
    //                 var xhr = new window.XMLHttpRequest();
    //                 //Upload progress
    //                 xhr.upload.addEventListener("progress", function (evt) {
    //                     if (evt.lengthComputable) {
    //                         var percentComplete = evt.loaded / evt.total;
    //                         //Do something with upload progress
    //                         $('#ulPercentage_self').html('');
    //                         // $('#ulPercentage').append(percentComplete*100);
    //                         $('#ulPercentage_self').append(Math.floor(percentComplete * 100));
    //                         $('#progressbar_self').show();
    //                         $('#progressbar_self').progressbar
    //                         (
    //                             {
    //                                 value: percentComplete * 100
    //                             }
    //                         )
    //                     }
    //                 }, false);
    //                 //Download progress
    //                 xhr.addEventListener("progress", function (evt) {
    //                     if (evt.lengthComputable) {
    //                         var percentComplete = evt.loaded / evt.total;
    //                         //Do something with download progress
    //                         // console.log(percentComplete);
    //                     }
    //                 }, false);
    //                 return xhr;
    //             },
    //             type : 'post',
    //             url : 'ci-upload-pic-daily',
    //             contentType: false,
    //             processData: false,
    //             async: true,
    //             data : formData,
    //             success : function()
    //             {
    //
    //             },
    //             complete : function()
    //             {
    //                 alert('Successfully uploaded image!');
    //                 btn.attr('disabled', false);
    //                 $('#modal-upload-selfie-daily').modal('hide');
    //                 $('#progressbar_self').hide();
    //                 $('#progressbar_self').html('');
    //                 $('#ulPercentage_self').html('');
    //                 $('#ci_selfie_daily').val('')
    //
    //                 initialise();
    //
    //             }
    //         })
    //     }
    //     else
    //     {
    //         alert('Please select an image file!');
    //         btn.attr('disabled', false);
    //     }
    //
    //
    // }
    // else
    // {
    //     alert('Please select a file');
    //     btn.attr('disabled', false);
    // }
});