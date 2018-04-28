
var TaskList = React.createClass({
	getInitialState: function () {
		return {taskGroups: []};
	},
	componentDidMount: function () {
		$.getJSON("task.json", function (result) {
			if (this.isMounted()) {
				this.setState({taskGroups: result.data});
			}
		}.bind(this));
	},
	render: function () {
		return (
			<div className="task-list">
				<div className="today"><TaskGroup tasks={this.state.taskGroups.today} /></div>
				<div className="tommorow"><TaskGroup tasks={this.state.taskGroups.tommorow} /></div>
				<div className="after-tommorow"><TaskGroup tasks={this.state.taskGroups.after_tommorow} /></div>
			</div>
		);
	}
});

var TaskGroup = React.createClass({
	propTypes: {
		tasks: React.PropTypes.array.isRequired,
	},
	getDefaultProps: function () {
		return {tasks: []};
	},
	render: function () {
		var tasks =  this.props.tasks.map(function (content) {
			return <li><Task {...content} /></li>;
		});
		return <ul className="task-group">{tasks}</ul>;
	}
});

var Task = React.createClass({
	propTypes: {
		author: React.PropTypes.string.isRequired,
		title:  React.PropTypes.string.isRequired,
		description: React.PropTypes.string.isRequired,
		done: React.PropTypes.bool.isRequired,
	},
	getInitialState: function () {
		return {done: this.props.done};
	},
	onClick: function () {
		this.setState({done: !this.state.done});
	},
	render: function () {
		return (
			<div className="task">
				<button onClick={this.onClick}>完了({String(this.state.done)})</button>
				<p className="author">{this.props.author} 先生</p>
				<p className="title">{this.props.title}</p>
				<pre className="description">{this.props.description}</pre>
			</div>
		);
	}
});

React.render(<TaskList />, document.body);
