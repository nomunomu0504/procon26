#!/usr/bin/env python
# -*- coding: utf-8 -*-

from flask import flash, redirect, url_for, request
import main # https://plus.google.com/112251891749825300019/posts/1p2ZV9rm75a
from functools import wraps

def login_required(f):
	@wraps(f)
	def decorated_function(*args, **kwargs):
		if main.session.get("username") is None:
			flash(u"ログインしてください") # You need to login first.
			return redirect(url_for("login_get", next = request.url))
		return f(*args, **kwargs)
	return decorated_function