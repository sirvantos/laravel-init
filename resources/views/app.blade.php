<!DOCTYPE html>
<html lang="en" id="app">
	<head>
		<meta charset="UTF-8">
		<title>@{{pageTitle}}</title>
		<link rel="stylesheet" href="{{elixir('css/app.css')}}">
	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="navbar-collapse collapse" id="search-bar">
					<ul class="nav navbar-nav navbar-right">
						<li><a v-link="{ path: '/' }">Index</a></li>
						<li><a v-link="{ path: '/movies' }">Movies</a></li>
						<li><a v-link="{ path: '/about' }">About</a></li>
					</ul>
					<search></search>
				</div>
			</div><!-- /.container-fluid -->
		</nav>

		<section class="row">
			<div class="container">
				<!-- use router-view element as route outlet -->
				<router-view></router-view>
			</div>
		</section>

		<footer class="row">

		</footer>

		<script src="{{elixir('js/all.js')}}"></script>

	</body>
</html>