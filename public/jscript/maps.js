
function dash_map_init() {
    jQuery(function() {
        // Asynchronously Load the map API

        //AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY = old
        //AIzaSyBZjFXswzldW3AE2oDOzb7Sm0DJVp3lDNQ = new

        var script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY&callback=maploop";
        document.body.appendChild(script);
    });
}


var markerarray = [];
var markerinfowindow = [];
var centerit = false;
var getbranch = 0;
var positiontocenter;
$('#btn_refresh').attr('disabled','disabled');

function getdatafirst() {


    var id = 1;
    var ctr = 0;
    $.ajax({
        url: '/gen-dashboard-getdatalatlong',
        type: 'GET',
        data:
            {
                'id': id
            },
        dataType: 'json',
        success: function (data) {

            for(ctr; ctr <= data[0].length-1; ctr++)
            {
                markerarray[ctr]=[];
                markerinfowindow[ctr]=[];
                var status = '';
                for(ii = 0; ii <= 3; ii++)
                {
                    if(ii === 0)
                    {
                        markerarray[ctr][ii] = data[0][ctr].CI_Name;
                    }
                    else if (ii === 1)
                    {
                        markerarray[ctr][ii] = parseFloat(data[0][ctr].Lat);
                    }
                    else if (ii === 2)
                    {
                        markerarray[ctr][ii] = parseFloat(data[0][ctr].Long);
                    }
                }

                if(data[0][ctr].Status === 'Online'){
                    status = '<p style="color: green;width: 100%;height: 100%;margin-top: -7px;line-height:10px; ">Online</p>'
                }
                else if(data[0][ctr].Status === 'Idle') {
                    status =  '<p style="color: orange;width: 100%;height: 100%;margin-top: -7px;line-height:10px;">Idle</p>'
                }
                else{
                    status =  '<p style="color: red;width: 100%;height: 100%;margin-top: -7px;line-height:10px;">Offline</p>'
                }



                markerinfowindow[ctr][0] = '<div class="info_content" style= "white-space:normal;">' +
                    '<p><b>'+data[0][ctr].CI_Name+'</b></p>' +
                    status +
                    '<p style = "width: 100%;height: 12px;">Last Update: '+data[0][ctr].Last_Update+'</p></div>'+
                    '<p style = "width: 100%;height: 100%;margin-top: -7px;line-height:10px;" >Location: '+data[0][ctr].Address+'</p>' +
                    '</div>'

            }
            // console.log(data);
            getbranch = data[1];
            //  console.log('what branch?: '+getbranch);


        },
        error: function (data) {
            // console.log('error');
        }
    });
}


function maploop() {

    if(!centerit){
        getdatafirst();
    }


    setTimeout(function () {
        initialize();
        $('#btn_refresh').removeAttr('disabled');
    },3000);

    $('#btn_refresh').click(function (event) {
        getdatafirst();
        var countdown = 3;

        var downloadTimer = setInterval(function(){
            countdown--;
            $('#btn_refresh').html("REFRESHING . . . ("+countdown+")");
            if(countdown <= 0)
                clearInterval(downloadTimer);
        },1000);

        $('#btn_refresh').attr('disabled','disabled');
        // console.log('refreshed');
        centerit = true;
        maploop();
    });

}


function initialize() {
    

    if(getbranch === "25")
    {
        //cavite
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Silang, Cavite)&nbsp</p>\n");
        positiontocenter = new google.maps.LatLng(14.22195,120.97354);

    }
    else if(getbranch === "1")
    {
        //mandaluyong
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Summit, Mandaluyong)&nbsp</p>");
        positiontocenter = new google.maps.LatLng(14.586542,121.046612);
    }
    else if(getbranch === "26")
    {
        //cebu
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Cebu Branch)&nbsp</p>");
        positiontocenter = new google.maps.LatLng(10.316820,123.901247);
    }
    else if(getbranch === "30")
    {
        //davao
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Davao Branch)&nbsp</p>");
        positiontocenter = new google.maps.LatLng(7.050568,125.590574);
    }
    else if(getbranch === "61")
    {
        //davao
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Pampanga Branch)&nbsp</p>");
        positiontocenter = new google.maps.LatLng(15.044501,120.687837);
    }
    else
    {
        $('#mapcentertext').html("<p class=\"pull-left\" style=\"margin-top: 6px; font-size: 20px\">MAP CENTER: (CCSI: Summit, Mandaluyong)&nbsp</p>");
        positiontocenter = new google.maps.LatLng(14.586542,121.046612);
    }

    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);

    var markers = markerarray;

    var infoWindowContent = markerinfowindow;
    //  console.log(infoWindowContent);


    for( i = 0; i < markers.length; i++ ) {
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        marker = new google.maps.Marker({
            position: position,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/motorcycling.png',
            map: map,
            title: markers[i][0]
        });

        google.maps.event.addListener(marker,'click', (function(marker,i,infoWindow){
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map,marker);
            };
        })(marker,i,infoWindow));
        infoWindow.setContent(infoWindowContent[i][0]);
        infoWindow.open(map,marker);
        // Automatically center the map fitting all markers on the screen
        qwe();
    }

    //{{--//CCSI DASMARINAS : 14.333636, 120.98663--}}
    // {{--//CCSI Silang : 	14.22195, 120.97354--}}
    // CCSI SUMMIT : 14.586542,121.046612


    (function() {

    })();

    if(getbranch === "25")
    {
        //cavite
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Silang, Cavite"
        });

    }
    else if(getbranch === "1")
    {
        //manila
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Summit, Mandaluyong"
        });
    }
    else if(getbranch === "26")
    {
        //cebu
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Cebu Branch"
        });
    }
    else if(getbranch === "30")
    {
        //davao
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Davao Branch"
        });
    }
    else if(getbranch === "61")
    {
        //pampanga
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Pampanga Branch"
        });
    }
    else
    {
        var markerDasma = new google.maps.Marker({
            position: positiontocenter,
            map: map,
            icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-pushpin.png',
            title:"CCSI : Summit, Mandaluyong"
        });
    }


    // $('#locationviewer').click(function () {
    //
    //     // console.log($(this).attr('name'));
    //
    //     var getlatlong = $(this).attr('name');
    //     var split = getlatlong.split(':');
    //     // console.log(split[1]+"-"+split[2]);'
    //
    //
    //
    //     map.panTo(new google.maps.LatLng(split[1], split[2]));
    //     map.setZoom(20);
    //
    //
    // });


    setTimeout(function () {
        qwe();
    },4000);



    function qwe() {
        map.setZoom(15);
        map.setCenter(positiontocenter);
        $('#btn_refresh').html('REFRESH');
    }
}
