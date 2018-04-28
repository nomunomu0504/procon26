#!/usr/bin/env python
# -*- coding: utf-8 -*-

from google.appengine.ext import ndb

class Task(ndb.Model): # クラス名は変更予定
	
	u"""
	課題タスク
	@var author 投稿者のキー
	@var subject 課題名
	@var explanation 課題についての補足説明
	@var deadline 締切日
	@var aaa とりあえず課題が完了したか（変数名決まってない）
	@var verified 先生は提出確認済みか
	@var created_at 投稿日時
	@var update_at  更新日時
	# どのクラス宛かを示すキーのプロパティも必要
	"""
	
	author = ndb.Keyproperty(kind = "Teacher")
	subject = ndb.StringProperty(indexed = False)
	explanation = ndb.TextProperty() # indexed = False
	deadline = ndb.DateProperty()
	aaa = ndb.BooleanProperty()
	verified = ndb.BooleanProperty()
	created_at = ndb.DateTimeProperty(auto_now_add = True)
	update_at  = ndb.DateTimeProperty(auto_now = True)
  