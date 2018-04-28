#!/usr/bin/env python
# -*- coding: utf-8 -*-

from google.appengine.ext import ndb
from webapp2_extras import auth
from webapp2_extras import security
from webapp2_extras.appengine.auth.models import Unique

from school import School

class User(ndb.Model):
	
	firstname = ndb.StringProperty()
	lastname = ndb.StringProperty()
	school_key = ndb.KeyProperty()
	password = ndb.StringProperty(indexed = False)
	
	@classmethod
	def create(cls, firstname, lastname, school, password_raw):
		"""
		アカウント作成
		@param str firstname 名前
		@param str lastname  苗字
		@param str school 所属学校名
		@param str password_raw パスワード
		@return (bool, User|None) 成功か, ユーザ
		"""
		
		if not (firstname and lastname and school and password_raw):
			print(u"入力し忘れあるんじゃない？".encode("utf-8"))
			return False, None
		
		# Get the school'key. If it did not exist, quit this function.
		school_key = School.query(School.name == school).get(keys_only = True)
		if not school_key:
			return False, None
			
		# Create a user. returun this user.
		user = cls(
			firstname = firstname,
			lastname = lastname,
			school_key = school_key,
			password_raw = security.generate_password_hash(password_raw, length = 20))
		user.put()
		return True, user
		
	@classmethod
	def get_by_password(self, firstname, lastname, password):
		u"""
		
		@param str firstname 名前
		@param str lastname  苗字
		@param str password パスワード
		@return User
		@raises auth.InvalidAuthIdError() | auth.InvalidPasswordError()
		"""
		
		user = cls.query(
			firstname == firstname and
			lastname == lastname
		).get()
		
		if not user:
			raise auth.InvalidAuthIdError()
		if not security.check_password_hash(password, user.password):
			raise auth.InvalidPasswordError()
			
		return user
		
		
		
class Student(User):
	teachers = ndb.KeyProperty(kind = "Teacher", repeated = True)
	
	
class Teacher(User):
	pass
  