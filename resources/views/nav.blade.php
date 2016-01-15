<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" ui-sref="index">Trans-Amigos Express</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

		@if (Auth::check())
	    	<li><a href="{!! route('home') !!}">Make Labels</a></li>
		@endif

		@if (Auth::check() && Auth::user()->admin)
			<li><a href="{!! route('couriers.index') !!}">Couriers</a></li>
			<li><a href="{!! route('institutions.index') !!}">Institutions</a></li>
			<li><a href="{!! route('users.index') !!}">Users</a></li>
		@endif

	  </ul>
	  @if (Auth::check())
	  <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				Hello, {!! Auth::user()->username !!}&nbsp;<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="{!! route('users.edit', Auth::user()->id) !!}">Change Password</a></li>
				<li><a href="{!! route('auth.logout') !!}">Logout</a></li>
			</ul>
		  </li>
      </ul>
	  @endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>