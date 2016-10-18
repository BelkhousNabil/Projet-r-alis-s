# -*- coding: utf-8 -*-
import os

List = open("lexique.txt").read().splitlines()
print (List)

while List:
	l = List.pop(0)
	print (l)