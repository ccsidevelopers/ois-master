<div class="user-panel">
    <div class="pull-left image">
        <img src="<?php echo e(Auth::user()->pix_path); ?>" class="img-circle afterUpload" alt="User Image">
    </div>
    <div style="white-space: normal" class="pull-left info">
        <p><?php echo e(Auth::user()->name); ?></p>
        <span id="span_bi_account"></span>
        <span id="statusConnection"></span>
    </div>
    <br/>
    <br/>
</div>