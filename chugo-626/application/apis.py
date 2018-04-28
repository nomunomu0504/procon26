#!/usr/bin/env python
# -*- coding: utf-8 -*-

from main import app
from flask import jsonify

#from models.school import School
#from models.user import Student, Teacher

# JSONのプロパティの説明は「models/task.py」にあります

dumy_tasks = {
	0 : {
		"author" : u"福井太郎 先生",
		"subject" : u"定積分のプリント29",
		"explanation" : u"最後の問題は、難しいので解かなくてもよい。",
		"deadline" : "2015-1-15",
		"aaa" : True,
		"verified" : True
	},
	1 : {
		"author" : u"石川健 先生",
		"subject" : u"国語のワーク P20~23",
		"deadline" : "2015-1-21",
		"aaa" : True,
		"verified" : False
	},
	2 : {
		"author" : u"福井太郎 先生","subject" : u"不定積分のプリント28",
		"deadline" : "2014-12-22",
		"aaa" : False,
		"verified" : False
	}
}


@app.route("/api/<int:version>/<int:student_id>/tasks.json", methods = ["GET"])
def get_tasks(version, student_id):
	# API-version の判定をしていない
	# student = Student.get_by_id(student_id)
	# if student:
	response = jsonify(dumy_tasks)
	response.status_code = 200
	return response

