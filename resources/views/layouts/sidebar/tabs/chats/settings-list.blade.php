<div class="settings-wrapper">
    <div class="be-scroller"><span class="category-title">General</span>
        <ul class="settings-list">
            @if(Auth::user()->isOnline())
                <li>
                    <div class="switch-button switch-button-sm">
                        <input type="checkbox" name="chatStatus" checked id="chatStatus" data-size="mini"><span>
                            <label for="chatStatus"></label></span>
                    </div>
                    <span class="name">@lang('auth.available')</span>
                </li>
            @else
                <li>
                    <div class="switch-button switch-button-sm">
                        <input type="checkbox" name="chatStatus" id="chatStatus" data-size="mini"><span>
                            <label for="chatStatus"></label></span>
                    </div><span class="name">@lang('auth.unavailable')</span>
                </li>
            @endif
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" checked="" name="st3" id="st3"><span>
                            <label for="st3"></label></span>
                </div><span class="name">Login with Facebook</span>
            </li>
        </ul>
        <span class="category-title">Notifications</span>
        <ul class="settings-list">
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" name="st4" id="st4"><span>
                            <label for="st4"></label></span>
                </div><span class="name">Email notifications</span>
            </li>
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" checked="" name="st5" id="st5"><span>
                            <label for="st5"></label></span>
                </div><span class="name">Project updates</span>
            </li>
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" checked="" name="st6" id="st6"><span>
                            <label for="st6"></label></span>
                </div><span class="name">New comments</span>
            </li>
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" name="st7" id="st7"><span>
                            <label for="st7"></label></span>
                </div><span class="name">Chat messages</span>
            </li>
        </ul><span class="category-title">Workflow</span>
        <ul class="settings-list">
            <li>
                <div class="switch-button switch-button-sm">
                    <input type="checkbox" name="st8" id="st8"><span>
                            <label for="st8"></label></span>
                </div><span class="name">Deploy on commit</span>
            </li>
        </ul>
    </div>
</div>