<div class="content-wrapper">
    <section class="content-header">
        <h1>
            CC Senior Account Officer - General  Search Accounts
        </h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="box-body">
                            <div class="box-title">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <input type="radio" name="gen_search_rad" id="gen_mon_all_search" class="gen_search_date_range_click" value="all">
                                                    <label for="gen_mon_all_search">All</label>
                                                    <input type="radio" name="gen_search_rad" id="gen_mon_date_range_search" checked="" class="gen_search_date_range_click" value="date_range">
                                                    <label for="gen_mon_date_range_search">Date Range</label>
                                                </div>
                                                <div class="form-group" id="gen_search_date_pick_holder">
                                                    <div class="input-group margin" style="" id="">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">From</label>
                                                        </div>
                                                        <input id="gen_search_min" type="date" class="form-control gen_search_date_range_dates" value="{{date('Y-m-d')}}">
                                                        <div class="input-group-btn">
                                                            <label for="" class="btn btn-default">To</label>
                                                        </div>
                                                        <input id="gen_search_max" type="date" class="form-control gen_search_date_range_dates" value="{{date('Y-m-d')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table id="cc_sao_generaltbl" class="tableendorse table-hover table-condensed dataTable dtr-inline" role="grid" aria-describedby="cc_sao_generaltbl_info" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>SITE</th>
                                                <th>TYPE OF REQUEST</th>
                                                <th>DATE/TIME ENDORSED</th>
                                                <th>PROJECT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>PACKAGE</th>
                                                <th>TYPES OF CHECK</th>
                                                <th>REQUESTOR / POC</th>
                                                <th>STATUS</th>
                                                <th>VERIFY STATUS DETAILS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>SITE</th>
                                                <th>TYPE OF REQUEST</th>
                                                <th>DATE/TIME ENDORSED</th>
                                                <th>PROJECT</th>
                                                <th>ACCOUNT NAME</th>
                                                <th>PACKAGE</th>
                                                <th>TYPES OF CHECK</th>
                                                <th>REQUESTOR / POC</th>
                                                <th>STATUS</th>
                                                <th>VERIFY STATUS DETAILS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </tfoot>
                                    </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            Footer
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


