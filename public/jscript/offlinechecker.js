
var check_first = true;

setInterval(function () {

    if(check_first)
    {
        check_first = false;
        var ctr = 0;
        $.ajax({
            type: 'GET',
            url: 'cicheckeroffline/ok',
            data:
                {
                    'ID': ID = 1
                },
            success: function (data)
            {
                console.log(data);

                for(ctr; ctr <= data[0].length-1; ctr++)
                {

                    // get_loc(data[0][ctr].CI_ID,data[0][ctr].Lat,data[0][ctr].Long);

                    // var promise = $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY&latlng="+data[0][ctr].Lat+","+data[0][ctr].Long+"&sensor=false");
                    // var get_loc = 'cannot received location at thi moment';
                    // promise.done(function(todayValue)
                    // {

                    // });

                    //offline or online checker
                    check_offline_online(data[0][ctr].Status,data[0][ctr].Time_Limit,data[1].date,data[0][ctr].CI_ID,data[0][ctr].CI_Name);
                }
            },
            error: function (data) {

            },
            complete: function () {
                check_first = true;
            }
        });
    }

},10000);

function get_loc(id,lat,long) {

    $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        type: 'get',
        data:
            {
                'key' : 'AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY',
                'latlng' : lat+","+long,
                'sensor' : 'false'
            },
        success: function (todayValue)
        {
            if (todayValue.status == 'OK')
            {

                console.log('Address: '+todayValue.results[0].formatted_address);
                var loc = todayValue.results[0].formatted_address;

                save_loc(id,loc);
            }
        },
        error: function () {
            console.log('error getting location');
        }
    });

}

function save_loc(id,loc) {

    $.ajax({
        type: 'get',
        url: 'cicheckeroffline/address',
        data:
            {
                'id': id,
                'address' : loc
            },
        success: function (dataa)
        {
            console.log(dataa);
        },
        error: function () {
            console.log('error');
        },
        complete: function () {

        }
    });

}

function check_offline_online(status,time_limit,date_now,ci_id,ci_name) {

    if(status === 'Offline')
    {
        console.log(ci_name+": user is offline already do nothing..");
    }
    else if(time_limit < date_now)
    {
        console.log(ci_name+": offline");
        $.ajax({
            type: 'get',
            url: 'cicheckeroffline/off',
            data:
                {
                    'id': ci_id
                },
            success: function (dataa)
            {
                console.log(ci_name+": success passing id");
                console.log(dataa+": data receive");
            },
            error: function () {
                console.log(ci_name+": error passing id");
            }
        });

    }
    else{
        console.log(ci_name+": online");
    }
}