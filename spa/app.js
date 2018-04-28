/** @jsx React.DOM */

'use strict';

var Router = ReactRouter;
var Route = ReactRouter.Route;
//var Routes = ReactRouter.Routes;
var DefaultRoute = ReactRouter.DefaultRoute;
var Link = ReactRouter.Link;
var RouteHandler = ReactRouter.RouteHandler;
var NotFoundRoute = ReactRouter.NotFoundRoute;
var Redirect = ReactRouter.Redirect;


var HOST = 'https://******.****.**';
var params = {
	'subscription-key': '********************',
};
class App extends React.Component {
	loadDataFromServer() {
		var url = HOST + '/teacher';
		$.getJSON(url, params, (result) => {
			var subscriptionKey = result['subscription-key'];
			console.log(result);
		}).fail(() => {
			alert('error');
		});
	}
	componentDidMount() {
		this.loadDataFromServer();
	}
	render() {
		return (
			<div>
				<NavigationBar />
				<RouteHandler />
			</div>
		);
	}
}

var NavigationBar = React.createClass({
	render: function () {
		return (
			<header>
				<ul>
					<li><Link to="app">Home</Link></li>
					<li><Link to="profile" params={{username: 'chugo'}}>Profile</Link></li>
				</ul>
			</header>
		);
	}
});


class Profile extends React.Component {
	render() {
		var {router} = this.context;
		var username = router.getCurrentParams().username;
		return <div>@{username}.</div>
	}
}

Profile.contextTypes = {
	router: React.PropTypes.func,
};


class NotFound extends React.Component {
	render() {
		return (
			<h1>このページは存在しません。</h1>
		);
	}
}


class TaskList extends React.Component {
	render() {
		return <div>TaskList.</div>;
	}
}

class Sample extends React.Component {
	render() {
		return <div>Sample.</div>;
	}
}



var routes = (
	<Route name="app" path="/" handler={App}>
		<DefaultRoute handler={TaskList} />
		<Route name="profile" path="/@:username" handler={Profile} />
		<Route name="settings" handler={Sample}>
			<Route name="account" handler={Sample} />
			<Route name="password" handler={Sample} />
		</Route>
		<NotFoundRoute handler={NotFound} />
	</Route>
);


Router.run(routes, function(Handler) {
	React.render(<Handler/>, document.getElementById('app'));
});