#!/usr/bin/env python
# -*- coding: utf-8 -*-

from google.appengine.ext import ndb
from webapp2_extras.appengine.auth.models import Unique

		
class School(ndb.Model):

	name = ndb.StringProperty()
	#email = ndb.StringProperty()
	
	@classmethod
	def create(cls, name):
		u"""
		
		@param str name 学校名
		"""
		
		unique = "%s.name.%s" % (cls.__name__, name)
		success, existing = Unique.create(unique)
		
		if success:
			school = cls(name = name)
			return True, school
		else:
			return False, None


class Class(ndb.Model):

	u"""
	クラス
	@var school 所属学校のキー
	@var name クラス名（表示用？）
	@var 
	"""
	
	school = ndb.KeyProperty(kind = "School")
	name = ndb.StringProperty()
	