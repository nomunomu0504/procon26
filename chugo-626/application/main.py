#!/usr/bin/env python
# -*- coding: utf-8 -*-

from flask import Flask, redirect, url_for, request, render_template, abort, flash, get_flashed_messages
from flask import Session
from flask.ext.cache import Cache

app = Flask(__name__)
cache = Cache(app, config = {"CACHE_TYPE":"simple"})
session = Session()

from decorators import login_required

from models.school import School
from models.user import Student, Teacher


@app.route("/")
def home():
	if session.get("username") is not None:
		username = session["username"]
		#values = {}
		#return render_template("task.html", **values)
		return render_template("task.html")
	else:
		return render_template("introduction.html")


@app.route("/login", methods = ["GET"])
def login_get():
	if session.get("username") is not None:
		return redirect("/")
	return render_template("login.html", url = request.url)
	

@app.route("/login", methods = ["POST"])
def login_post():
	lastname = request.form["lastname"]
	firstname = request.form["firstname"]
	password = request.form["password"]
	#school = request.form["school"]
	try:
		user = Student.get_by_password(
			lastname = lastname,
			firstname = firstname,
			password_raw = password
		)
		session["username"] = " ".join(firstname, lastname)
		return redirect(request.args.get("next", "/"))
	except Exception, e:
		# Redirect to login_get
		return redirect(request.url)
	

@app.route("/logout", methods = ["GET","POST"])
@login_required
def logout():
	if request.method == "GET":
		return render_template("logout.html", url = request.url)
	elif request.method == "POST":
		session.pop("username", None)
		return redirect("/")
		

@app.route("/signup", methods = ["GET"])
def signup_get():
	return render_template("signup.html", url = request.url)
			
			
@app.route("/signup", methods = ["POST"])
def signup_post():
	# Get data from forms.
	lastname = request.form["lastname"]
	firstname = request.form["firstname"]
	school = request.form["school"]
	password = request.form["password"]
	# Create a student account. If not successed, redirect for input once more.
	success, student = Student.create(
		lastname = lastname,
		firstname = firstname,
		school = school,
		password_raw = password
	)
	if success:
		return u"生徒用アカウント作成に成功しましたよー。"
	else:
		return redirect(request.url)


@app.errorhandler(404)
def page_not_found(e):
	return render_template("404.html"), 404;
	

@app.errorhandler(500)
def page_not_found(e):
	return "Sorry, unexpected error: {}".format(e), 500
	