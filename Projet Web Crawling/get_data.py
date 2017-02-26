import requests
import bs4 as BeautifulSoup	
import re
from urllib import urlopen
import urllib2
import io
import sys
import urllib
import os
import encodings


encoding = 'utf-8'

opener = urllib2.build_opener()
opener.addheaders = [('User-agent', 'Mozilla/5.0')]

List = open("lexique.txt").read().splitlines()

result = "results"
if not os.path.exists(result):
		os.mkdir(result,0777)

while List:
	argv = List.pop(0)
	path_result = result+"/"+argv

	argv = "".join(argv)
	argv = urllib.quote_plus(argv)

	url = "https://www.google.fr/search?site=&source=hp&q=" + argv + "&num=5"
	page = opener.open(url)
	soup = BeautifulSoup.BeautifulSoup(page,'lxml')

	res = ""
	print("\nSITES SOURCES:\n")
	for cite in soup.findAll('cite'):
		temp = cite.text;
		if not cite.text.startswith("https://") and not cite.text.startswith("http://"):
			temp =  "http://" + temp
		print(temp)	
		try:	
			html = urlopen(temp).read()
			#soup2 = BeautifulSoup.BeautifulSoup(html,'lxml')
			#[s.extract() for s in soup2(['style', 'script', '[document]', 'head', 'title'])]
			
			#text = soup2.get_text()
			

			soup2 = BeautifulSoup.BeautifulSoup(html,'lxml')
			[s.extract() for s in soup2(['style', 'script', '[document]', 'head', 'title','ifram','header','nav','footer','form'])]
			
			text = soup2.get_text()
			res+=text
			
		except EnvironmentError:
			print

	

	if not os.path.exists(path_result):
		os.mkdir(path_result,0777)
		path=path_result+"/"+argv+".txt"
		#new_file = open(path, "w",encoding=encoding)
		#new_file.write(res)
		with io.open(path,'w',encoding=encoding) as f:
			f.write(res)











	