
<footer class="main-footer">
    <div class="pull-left">
        <b>Beta Version</b> 20.0314
    </div>
    <center>Comprehensive Credit Services Inc.</center>


    <div class="row" hidden id="id_chat">
        <div class="col-sm-2 pull-left chat" style="
            z-index: 98;
            /*-webkit-transform:scale(0.8);*/
            /*-moz-transform:scale(0.8);*/
            /*-ms-transform:scale(0.8);*/
            /*transform:scale(0.8);*/

            /*-ms-transform-origin:0 0;*/
            /*-webkit-transform-origin:0 0;*/
            /*-moz-transform-origin:0 0;*/
            /*transform-origin:0 0;*/
            ">
            <span id="chat_for_sao_dispa">
                <div style=" position:fixed; bottom:0; width: 18%"
                     class="box box-primary box-solid direct-chat direct-chat-primary sidebar-menu tree collapsed-box">
                    <div class="box-header with-border">
                     <h3 class="box-title">General Chat box</h3> <small style="color: white; margin-top: 10px"><br>All Branches (Except C.I)</small>

                        <div class="box-tools pull-left">
                            <span id="change_chat_notif_chat_box">
                                <span id="newmessagetogs_id" data-toggle="tooltip" title="New Messages" class="newmessagetogs badge bg-red"></span>
                            </span>
                            <button id="colls_minus" type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                        <!-- /.box-header -->
                    <div class="box-body" style="display: none;">
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages" id="messageBody">
                            <!-- Message to the right -->
                            <span id="messageNotif"></span>
                        </div>
                        <!--/.direct-chat-messages-->
                    </div>
                        <!-- /.box-body -->
                    <div class="box-footer" style="display: none;">

                        <div id="grouptextarea" class="input-group">
                            <div style="" class="emotion">
                                <div disabled style="margin-top: 3px; margin-right: 2px; width: 100%;white-space:normal;"
                                     class="form-class" id="txtMessage" contenteditable="true"
                                     placeholder="Enter text here..."></div>
                                {{--<input type="text" id="txtMessage" name="txtMessage" contenteditable="true" placeholder="Type Message ..." class="input form-class" style="margin-top: 3px; margin-right: 2px; width: 100%">--}}
                                <span class="emotion-Icon">
                                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                                       <div tabindex="0" style="background-color: white;" class="emotion-area"></div>
                                  </span>
                            </div>
                            <span class="input-group-btn">
                                                        <button style="width: 100%" type="button" id="btnPusher"
                                                                class="btn btn-primary btn-flat">Send</button>
                                                </span>
                            {{--chatloading--}}
                            <span id="chatloading"></span>
                        {{--<div class="overlay">--}}
                        {{--<i class="fa fa-refresh fa-spin"></i>--}}
                        {{--</div>--}}

                        <!-- end loading -->
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!--/.direct-chat -->
                </div>
            </span>
        </div>

        {{--<div class="col-sm-2">--}}
        {{--<div style=" position:fixed; bottom:0; width: 15%" class="box box-primary box-solid direct-chat direct-chat-primary sidebar-menu tree">--}}
        {{--<div class="box-header with-border" data-widget="collapse">--}}
        {{--<h3 class="box-title">"Name Here"<br><small><p style="color: white; margin-top: 10px">Private Message</p></small></h3>--}}
        {{--<div class="box-tools pull-right">--}}
        {{--<span id="newmessagetogs" data-toggle="tooltip" title="New Messages" class="badge bg-red">new</span>--}}
        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>--}}
        {{--</button>--}}
        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
        {{--<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">--}}
        {{--<i class="fa fa-comments"></i></button>--}}
        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- /.box-header -->--}}
        {{--<div class="box-body">--}}
        {{--<!-- Conversations are loaded here -->--}}
        {{--<div class="direct-chat-messages" id="messageBody">--}}
        {{--<!-- Message to the right -->--}}
        {{--<span id="messageNotif"></span>--}}
        {{--</div>--}}
        {{--<!--/.direct-chat-messages-->--}}
        {{--</div>--}}
        {{--<!-- /.box-body -->--}}
        {{--<div class="box-footer">--}}

        {{--<div id="grouptextarea" class="input-group">--}}

        {{--<textarea class="textarea" id="txtMessage" placeholder="Type Message ..."--}}
        {{--style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>--}}
        {{--<textarea type="text" id="txtMessage" name="txtMessage" placeholder="Type Message ..." class="textarea" style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"> </textarea>--}}
        {{--chatready--}}

        {{--<input type="text" id="txtMessage" name="txtMessage" placeholder="Type Message ..." class="form-class" style="margin-top: 3px; margin-right: 2px; width: 100%">--}}
        {{--<span class="input-group-btn">--}}
        {{--<button style="width: 100%" type="button" id="btnPusher" class="btn btn-primary btn-flat">Send</button>--}}
        {{--</span>--}}

        {{--chatloading--}}
        {{--<span id="chatloading"></span>--}}
        {{--<div class="overlay">--}}
        {{--<i class="fa fa-refresh fa-spin"></i>--}}
        {{--</div>--}}

        {{--<!-- end loading -->--}}
        {{--</div>--}}
        {{--<!-- /.box-footer-->--}}
        {{--</div>--}}
        {{--<!--/.direct-chat -->--}}

        {{--</div>--}}
        {{--</div>--}}
    </div>


</footer>