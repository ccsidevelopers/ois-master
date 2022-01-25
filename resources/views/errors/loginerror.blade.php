@if( count( $errors ) > 0 )
    @foreach ($errors->all() as $error)
        @if($error == 'Someone is still logged in.')
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-ban"></i> <small>{{$error}} <br> <a href="javascript:void(0)" onClick="redirect()">Click here to redirect to your session.</a> </small>
            </div>
        @else
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-ban"></i> <small>{{$error}}</small>
            </div>
        @endif
    @endforeach
    <script>

        function redirect() {
            window.location.href = "/dashboard-redirect";
        }

    </script>

@endif

