
var get_lat = $('#lat').attr('value');
var get_long = $('#long').attr('value');
var get_ci_id = $('#ci_id').attr('value');

console.log('pogi mo' + get_lat + ', ' + get_long + ', ' + get_ci_id)

get_loc(get_ci_id,get_lat,get_long);

function get_loc(id,lat,long)
{

    $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        type: 'get',
        data:
            {
                //AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY = old
                //AIzaSyBZjFXswzldW3AE2oDOzb7Sm0DJVp3lDNQ = new

                'key' : 'AIzaSyDVPBgvPhZUjIL8ysQKzXqOWkZrYtDCCDY',
                // 'key' : 'AIzaSyBZjFXswzldW3AE2oDOzb7Sm0DJVp3lDNQ',
                'latlng' : lat+","+long,
                'sensor' : 'false'
            },
        success: function (todayValue)
        {
            if (todayValue.status == 'OK')
            {

                console.log('Address: '+todayValue.results[0].formatted_address);
                var loc = todayValue.results[0].formatted_address;

                save_loc(id,loc,lat,long);
            }
            else if(todayValue.status == 'REQUEST_DENIED')
            {
                console.log('REQUEST_DENIED');
                save_loc(id,'no address found',lat,long);

            }
        },
        error: function () {
            console.log('error getting location');
            window.close();
        }
    });

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