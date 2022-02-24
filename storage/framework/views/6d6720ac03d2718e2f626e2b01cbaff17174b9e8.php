<div class="user-panel">
    <div class="pull-left image">
        <img src="<?php echo e(Auth::user()->pix_path); ?>" class="img-circle" alt="User Image">
    </div>
    <div style="white-space: normal" class="pull-left info">
        <p><?php echo e(Auth::user()->name); ?></p>
        <span id="statusConnection"></span>
    </div>
    <br/>
    <br/>
</div>