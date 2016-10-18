# -*- coding: utf-8 -*-

import re,sys,urllib2,requests


from bs4 import BeautifulSoup




def research(keywords):
    opener = urllib2.build_opener()
    opener.addheaders = [('User-agent', 'Mozilla/5.0')]
    #for start in range(0,10):
    url = "http://www.google.com/search?q=https://www.google.fr/search?start=0&lr=lan_fr&num"+str(int(sys.argv[1]*4))+"&q=mangas+article+"+keywords
    #print url
    page = opener.open(url)
    soup = BeautifulSoup(page,'lxml')
    res = list()
    for cite in soup.findAll('cite'):
        res.append(cite.text.encode('utf-8'))
        return res


def get_comment(url,attr_id,filename):
    counter = 0
    page = urllib2.urlopen(url)  #ouverture du lien dans pag
    strpage=page.read() #lecture de la page html
    page.close()
    file_p = open(filename, "w")
    soup = BeautifulSoup(strpage,"lxml") #declaration de beautiful soup avec les données de la page html
    nb_user =0
    for comments in soup.findAll('div',{"class",attr_id}): #boucler sur tout les div avec un attribut de class particulier
    	file_p.write("nb_user "+str(nb_user)+"\n")
        text_data = comments.get_text() #récupérer sont text
        lines = (line.strip() for line in text_data.splitlines()) #retirer les retour chariot supplémentaire
        chunks = (phrase.strip() for line in lines for phrase in line.split("  "))
        text_data = '\n'.join(chunk for chunk in chunks if chunk)
        file_p.write(text_data.encode('utf-8'))
        file_p.write("\n\n")
        nb_user+=1
    file_p.close()		    	  	

url = "http://www.lesnumeriques.com/telephone-portable/apple-iphone-6-p17445/avis.html"
get_comment(url,"review-details","lexnum.txt")
url = "http://www.lesmobiles.com/telephones/apple-iphone-6-16go,avis.html"
get_comment(url,"fiche_list_avis","lesmobiles.com.txt")
url = "http://www.cnetfrance.fr/produits/apple-iphone-6-39806097.htm"
get_comment(url,"fyre-review-subpart","cnet_france.txt")
url = "http://belgium-iphone.lesoir.be/2014/10/10/test-iphone-6/"
get_comment(url,"c","belgium.txt")

print 'end of treatment'
