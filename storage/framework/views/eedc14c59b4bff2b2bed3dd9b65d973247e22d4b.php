<style>
    @media  print {
        body
        {
            visibility: hidden;
        }
        #barcode_container
        {
            margin-top: -160px;
            visibility: visible;
        }

    }
</style>
<div class="content-wrapper" id="testingwrapper">
    <section class="content-header">
        <h1>Generate Barcodes</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="panel-body">
                        <div class="row" style = "padding-top : 15px;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Barode count to Generate:</label>
                                    <input type="number" class="form-control" title="Enter between 1-50" id="barcode_count">
                                    <small style="color: red; font-weight: bold">(Note: You can enter between 1-60)</small>
                                </div>
                                <div class="form-group">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-md" id="btn_generate_barcodes">Generate</button>
                                <button class="btn btn-warning btn-md" id="generate_new">New</button>
                                <span class = "pull-right" id = "showPrintQr" hidden><button class="btn btn-primary btn-md pull-right" id="btn_print_barcode" >Print Generated Barcode</button></span>
                            </div>
                        </div>
                    </div>
                    <span>
                    <div class="box-body" id = "showGeneratedQrs" hidden>
                        <div class = "row">
                             <div class="col-md-12">
                            <div class="box">
                                <div class="box-body" id="barcode_container">
                                </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>