# -*- coding: utf-8 -*-
from opinion import *
from nltk.probability import FreqDist
import operator
import bs4 as BeautifulSoup	
import re
from urllib import urlopen
import urllib2
import io
import sys
import urllib
import os
import encodings
import urlparse
import codecs
import unicodedata
from nltk import ngrams
from lxml import html
import requests
import xml.dom.minidom
from lxml import etree
import sys
reload(sys)
sys.setdefaultencoding('utf-8')

# Encoding non ascii characters
def urlEncodeNonAscii(b):
    return re.sub('[\x80-\xFF]', lambda c: '%%%02x' % ord(c.group(0)), b)

# Trasform IRI to an URI
def iriToUri(iri):
    parts= urlparse.urlparse(iri)
    return urlparse.urlunparse(
        part.encode('idna') if parti==1 else urlEncodeNonAscii(part.encode('utf-8'))
        for parti, part in enumerate(parts)
    )

# Get frensh opinions
def getOpinionFr(directory,product):
	Npage=1
	s=''
	#Creat the results floder in case it doesn't exist
	result = directory
	if not os.path.exists(result):
		os.mkdir(result,0777)

	# activate the API for using internet resources identified by URLs
	open_url = urllib2.build_opener()

	# Add the user agent spoofing in order to allows the network protocol peers to identify the application type
	open_url.addheaders = [('User-agent', 'Mozilla/5.0')]
	i=0
	while(i==0):

		print 'Page : ', Npage
		# The Url that will permit to get the web sites in relation with the arg
		url = 'http://www.beaute-test.com/'+product+'.php?listeavis='+str(Npage)

		# Open url
		page = open_url.open(url)
		
		# Get web site content
		soup = BeautifulSoup.BeautifulSoup(page,'html.parser')

		#get only the paragraphs that contain the the lexique term
		for class_tag in soup.findAll("div", { "class" : "bt__notation__block" }):
			opinion = str(class_tag)
			if(opinion in s):
				i+=1
			else:
				s+=opinion
		
		if(i>0):
			print 'END OF CLOWLING\n'

		Npage+=1

	soup2 = BeautifulSoup.BeautifulSoup(s, 'html.parser')
	
	# Kepp only the pertinent information
	[s.extract() for s in soup2( "div", { "class" : "bt__notation__feedback" })]
	[s.extract() for s in soup2( "div", { "class" : "bt__notation__block__notes" })]

	f = open(directory+'/pages_Fr.xml', "w")
	f.write(soup2.prettify())
	f.close()

	return z

# Add root to xml file
def addRoot(pathFile):
	f = open(pathFile).read()
	f = '<root>\n'+f+'\n</root>'

	file = open(pathFile, "w")
	file.write(f)
	file.close()

	x = etree.parse(pathFile)

	file = open(pathFile, "w")
	file.write(etree.tostring(x, pretty_print = True))
	file.close()

def good_bad_opinions(liste):
	if not os.path.exists('stats'):
		os.mkdir('stats',0777)
	goodList = list()
	badList = list()
	res=''
	for element in liste:
		res+=element+' '
	res=res.replace('\n',' ')
	gd = re.findall ( 'Points forts(.*?)Points faibles', res, re.DOTALL)
	bd = re.findall ( 'Points faibles(.*?)Commentaires', res, re.DOTALL)
	r=''
	for i in gd:
		r+=str(i.strip())+' '

	rb=''
	for i in bd:
		rb+=str(i.strip())+' '
	
	goodList = r.split()

	badList = rb.split()

	r=''
	for i in gd:
		r+=str(i.strip())+'\n'
		r = r.replace('-','')

	rb=''
	for i in bd:
		rb+=str(i.strip())+'\n'
	rb = rb.replace('-','')
	#Open the file and write on it the result
	fe = open('good_opinions_SITE.txt', 'w')
	fe.write(r)
	fe.close()

	#Open the file and write on it the result
	fe = open('bad_opinions_SITE.txt', 'w')
	fe.write(rb)
	fe.close()

	return goodList,badList,r,rb

# Extract information from the opinions
def excractInformation(pathFile):

	#variables
	dates = list()
	users = list()
	coms = list()

	#Tree of the xml file
	tree = etree.parse(pathFile)

	for date in tree.xpath('//p[@class="bt__notation__block__header__title"]'):
		dates.append(date.text)	

	for user in tree.xpath('//a[@class="bt__link__user"]/text()'):
		users.append(user)
	i=0
	for com in tree.xpath('//div[@class="bt__notation__block__content"]//p//text()'):
		coms.append(com)

	goodBad = good_bad_opinions(coms)

	return dates,users,coms,goodBad[0],goodBad[1]

# Normalization of the informations
def normalize(liste):
	i=0
	while(i<len(liste)):
		liste[i] = liste[i].replace('Commentaire du ', ' ')
		liste[i] = liste[i].replace('par', ' ')
		liste[i] = liste[i].strip()
		liste[i] = liste[i].replace('\n', ' ')
		i+=1
	return liste

# Stats of dates and owners
def stats(dictionary,filename):
	#Creat the results floder in case it doesn't exist
	result = "stats"
	if not os.path.exists(result):
		os.mkdir(result,0777)

	dictionary = sorted(dictionary.items(), key=operator.itemgetter(1), reverse=True)

	result = ''
	for x in dictionary:
		result += str(x)+'\n'

	#Open the file and write on it the result
	fe = open('stats/'+filename+'.txt', 'w')
	fe.write(result)
	fe.close()

	return dictionary

# Comments tokenization
def opinion_tokens_Fr(liste):
	#Creat the results floder in case it doesn't exist
	result = "stats"
	if not os.path.exists(result):
		os.mkdir(result,0777)

	i=0
	comments = ''
	while(i<len(liste)):
		comments+=liste[i]+'\n'
		i+=1

	comments=comments.lower()

	#Open the file and write on it the result
	f = open('opinions.txt', 'w')
	f.write(comments)
	f.close()

	w=['"','→','–','’','»','«',',','.','[',']','|','{','}',':',';','!','?','(',')','_','-','=','/',
	' qui ',' cette ',' mais ',' ou ',' où ',' et ',' donc ',' or ',' ni ',' car ',' la ',' là ',' le ',
	' les ',' de ',' des ',' du ',' tout ',' tous ',' toutes ',' que ',' comme ',' si ',' quand ',' je ',
	' tu ',' il ',' elle ',' nous ',' vous ',' ils ',' elles ',' un ',' une ',' au ',' aux ',' dans ',' ce '
	,' se ',' ces ',' ses ',' on ',' en ',' leur ',' leurs ',' a ',' à ',' pour ',' par ',' sous ',' sur ']

	#Open the file and write on it the result
	with codecs.open('opinions.txt','r') as myfile:
    	
		content=myfile.read()
		content=content.replace('points forts', ' ')
		content=content.replace('points faibles', ' ')
		content=content.replace('commentaires', ' ')
		
		# remove numeric forms
		content = ''.join([i for i in content if not i.isdigit()])
		while w:
			# remove conjuction, connectors, ...			
			content=content.replace(w.pop(0), ' ')

	content = content.split()

	tokenDict = FreqDist(content)
	tokenDict = sorted(tokenDict.items(), key=operator.itemgetter(1), reverse=True)

	s=''
	for x in tokenDict:
		s+= '(\''+x[0].decode('utf-8', 'ignore').encode('utf-8')+'\' , ' +str(x[1])+')\n'
	fe = open('stats/freq_tokens.txt', 'w')
	fe.write(s)
	fe.close()

	return tokenDict

def ns_grams(filePath,n):
	l = list()

	#Open the file and write on it the result
	with codecs.open(filePath,'r') as myfile:
		sentence=myfile.read()
		sentence=sentence.replace('points forts', ' ')
		sentence=sentence.replace('points faibles', ' ')
		sentence=sentence.replace('commentaires', ' ')

	n_grams = ngrams(sentence.split(), n)
	s=''
	for grams in n_grams:
		l.append(grams)

	Dict = FreqDist(l)
	Dict = sorted(Dict.items(), key=operator.itemgetter(1), reverse=True)

	t=''
	for x in Dict:
		t+= '(\''+str(x[0])+'\' , ' +str(x[1])+')\n'
	fe = open('stats/Freq-'+str(n)+'-gram.txt', 'w')
	fe.write(t)
	fe.close()

def get_positive_grams(filePath,n):
	l = list()

	#Open the file and write on it the result
	with codecs.open(filePath,'r') as myfile:
		sentence=myfile.read()
		sentence=sentence.replace('points forts', ' ')
		sentence=sentence.replace('points faibles', ' ')
		sentence=sentence.replace('commentaires', ' ')

	n_grams = ngrams(sentence.split(), n)
	s=''
	for grams in n_grams:
		if(n==2 or n==3):
			if(grams[0]=='trop' or grams[0]=='très' or grams[0]=='bon' or grams[0]=='bonne' or grams[0]=='dure' or grams[0]=='jolie' or grams[0]=='parfum' or grams[0]=='j\'aime' or grams[0]=='j\'adore' or grams[0]=='joli' or grams[0]=='j' ):
				s+=str(grams)+'\n'
				l.append(grams)

		if(n==3):
			if(grams[1]=='trop' or grams[1]=='très' or grams[1]=='bon' or grams[1]=='bonne' or grams[1]=='dure' or grams[1]=='jolie' or grams[1]=='parfum' or grams[1]=='j\'aime' or grams[1]=='j\'adore' or grams[1]=='joli' ):
				s+=str(grams)+'\n'
				l.append(grams)

	'''fe = open('positive-'+str(n)+'-gram.txt', 'w')
	fe.write(s)
	fe.close()'''

	Dict = FreqDist(l)
	Dict = sorted(Dict.items(), key=operator.itemgetter(1), reverse=True)

	t=''
	for x in Dict:
		t+= '(\''+str(x[0])+'\' , ' +str(x[1])+')\n'
	fe = open('stats/Freq_positive-'+str(n)+'-gram.txt', 'w')
	fe.write(t)
	fe.close()

def get_negative_grams(filePath,n):
	l = list()
	#Open the file and write on it the result
	with codecs.open(filePath,'r') as myfile:
		sentence=myfile.read()
		sentence=sentence.replace('points forts', ' ')
		sentence=sentence.replace('points faibles', ' ')
		sentence=sentence.replace('commentaires', ' ')

	n_grams = ngrams(sentence.split(), n)
	s=''
	for grams in n_grams:
		if('est pas' in grams or 'ai pas' in grams or 'pas' in grams or 'cher' in grams):
			s+=str(grams)+'\n'
			l.append(grams)

	'''fe = open('negative-'+str(n)+'-gram.txt', 'w')
	fe.write(s)
	fe.close()'''

	Dict = FreqDist(l)
	Dict = sorted(Dict.items(), key=operator.itemgetter(1), reverse=True)

	t=''
	for x in Dict:
		t+= '(\''+str(x[0])+'\' , ' +str(x[1])+')\n'

	fe = open('stats/Freq_negative-'+str(n)+'-gram.txt', 'w')
	fe.write(t)
	fe.close()

def positive(comm,n):
	l = list()

	comm=comm.replace('points forts', ' ')
	comm=comm.replace('points faibles', ' ')
	comm=comm.replace('commentaires', ' ')

	n_grams = ngrams(comm.split(), n)

	for grams in n_grams:
		if(n==2 or n==3):
			if(grams[0]=='trop' or grams[0]=='très' or grams[0]=='bon' or grams[0]=='bonne' or grams[0]=='dure' or grams[0]=='jolie' or grams[0]=='parfum' or grams[0]=='j\'aime' or grams[0]=='j\'adore' or grams[0]=='joli' or grams[0]=='j' ):
				l.append(grams)

		if(n==3):
			if(grams[1]=='trop' or grams[1]=='très' or grams[1]=='bon' or grams[1]=='bonne' or grams[1]=='dure' or grams[1]=='jolie' or grams[1]=='parfum' or grams[1]=='j\'aime' or grams[1]=='j\'adore' or grams[1]=='joli' ):
				l.append(grams)

	return len(l)

def negative(comm,n):
	l = list()
	comm=comm.replace('points forts', ' ')
	comm=comm.replace('points faibles', ' ')
	comm=comm.replace('commentaires', ' ')

	n_grams = ngrams(comm.split(), n)
	s=''
	for grams in n_grams:
		if('est pas' in grams or 'ai pas' in grams or 'pas' in grams or 'cher' in grams or 'peu' in grams):
			s+=str(grams)+'\n'
			l.append(grams)
	return len(l)

#Creatint the good and bad opinion corpus and the scorring
def scoring(dates,owners,comments):
	i=0		
	j=0	
	k=0	
	cptn=0
	cptp=0				
	text=''
	listGood = list()
	listBad = list()
	while(i<len(dates)):

		c=''
		while(j<k+15):
			c += comments[j]
			j+=1
		k=j
		c=c.replace('Points forts', ' ')
		c=c.replace('Points faibles', ' ')
		c=c.replace('Commentaires', ' ')
		c=c.replace('\n', ' ')
		c=c.replace('-', ' ')

		pp= positive(c,2)
		nn= negative(c,4)
		if(pp>=nn):
			score='+'
			text += '\nCOMMENTED ON : '+dates[i]+' BY : '+owners[i]+' WITH SCORE : '+score+'\n'
			cptp+=1
			listGood.append(text)
		if(nn>pp):
			score='-'
			text += '\nCOMMENTED ON : '+dates[i]+' BY : '+owners[i]+' WITH SCORE : '+score+'\n'
			cptn+=1
			listBad.append(text)
		i+=1

	if(cptp > cptn):
		global_note = (((cptp*100)/(cptp+cptn))/20.0)
		print 'Le parfum Lady Million est un BON produit : Bon opinions = '+str(cptp)+' | mauvais opinions = '+str(cptn)
		print 'Note globale du produit : '+str(global_note)
	else: 
		global_note = (((cptn*100)/(cptp+cptn))/20.0)
		print 'Le parfum Lady Million est un BON produit : Bon opinions = '+str(cptp)+' | mauvais opinions = '+str(cptn)
		print 'Note globale du produit : '+str(global_note)

	fe = open('OPINIONS_scors.txt', 'w')
	fe.write(text)
	fe.close()

######################################################################### Main #########################################################################


################## French opinions treatment ##################
# Get opinions 								 				  #
'''															  #
getOpinionFr('CrawlingResults','lady_million_paco_rabanne')	  #
															  #
#Add root to the xml file 									  #
addRoot('CrawlingResults/pages_Fr.xml')					  	  #
'''														  	  #
# Get important information 								  #
info = excractInformation('CrawlingResults/pages_Fr.xml')	  #														  
# Add informations into list opinions 						  #
															  #
dates = info[0]												  #
owners = info[1]											  #
comments = info[2]											  #
good = info[3]												  #
bad = info[4]												  #
															  #
# good opinions frequences									  #
gdOpDict = FreqDist(good)									  #
gdOpDict = stats(gdOpDict,'freq_good_opinions_SITE')		  #
															  #
# bad opinions frequences									  #
bdOpDict = FreqDist(bad)									  #
bdOpDict = stats(bdOpDict,'freq_bad_opinions__SITE')		  #
															  #
# Remove texte aroud date									  #
dates = normalize(dates)									  #
# Remove texte aroud owner opinion							  #
owners = normalize(owners)									  #
															  #
# Dates frequences											  #
dateDict = FreqDist(dates)									  #
dateDict = stats(dateDict,'freq_dates')						  #
															  #
# Owners frequences											  #
OwnersDict = FreqDist(owners)								  #
OwnersDict = stats(OwnersDict,'freq_owners')				  #	
															  #
															  #
# File comment + tokens frequency							  #
opinion_tokensFr = opinion_tokens_Fr(comments)				  #
															  #
opinions = list()											  #
															  #
# Scorring of the product									  #
scoring(dates,owners,comments)								  #
															  #
ns_grams('opinions.txt',2)									  #	
ns_grams('opinions.txt',3)								  	  #
ns_grams('opinions.txt',4)								  	  #
															  #
# New way to buil positive and negative apprentissage corpus  #
get_positive_grams('opinions.txt',2)                          #
get_positive_grams('opinions.txt',3)                          #
get_negative_grams('opinions.txt',3)                          #
get_negative_grams('opinions.txt',4)                          #
															  #
###############################################################