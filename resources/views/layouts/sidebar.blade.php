<div class="sidebar-nav">
    <div class="navbar navbar-default kritish-nav" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">Menu</span>
        </div>
        <div class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/feeds/') }}"><span><img src="{{ url('/') }}/default/images/icons/bulb.png" width="25"></span> My Feed</a></li>
                <li><a href="{{ route('my_profile') }}"><span><img src="{{ url('/') }}/default/images/icons/user.png" width="25"></span> My Profile</a></li>
                <li><a href="{{ route('myListing_feeds') }}"><span><img src="{{ url('/') }}/default/images/icons/listing.png" width="25"></span> My Listings</a></li>
                <li><a href="{{ route('my_collaborations') }}"><span><img src="{{ url('/') }}/default/images/icons/mail.png" width="25"></span> My Collaborations <span class="badge"><!-- {{ Session::get('collaborationsCount') }} --></span></a></li>
                <li><a href="{{ route('my_interest') }}"><span><img src="{{ url('/') }}/default/images/icons/tag.png" width="25"></span> My Interest Areas</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>