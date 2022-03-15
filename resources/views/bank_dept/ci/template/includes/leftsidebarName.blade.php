<div class="user-panel">
    <div class="pull-left image">
        <img src="{{ Auth::user()->pix_path }}" class="img-circle" alt="User Image">
    </div>
    <div style="white-space: normal" class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <span id="statusConnection"></span>
    </div>
    <br/>
    <br/>
</div>