# -*- coding: utf-8 -*-

import re,sys,urllib2,requests


from bs4 import BeautifulSoup


if not (len(sys.argv) == 2):
    print "Usage: "+sys.argv[0]+" nb_documents_par_terme"
    exit(-1)

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


def term_corpus_creator(term):
    link = research('mangas+'+term)

    counter = 0
    for url in link:
        if(not (url.find("youtube") == -1)) or (not (url.find("amazon") == -1)):
            continue
        try: #test de l'url de la recherche google
            page = urllib2.urlopen(url)  #ouverture du lien dans page
        except:
            try:
                page = urllib2.urlopen('https://'+url)    
            except:
                try:
                    page = urllib2.urlopen('http://'+url)
                except :
                    print url+' ne peut être traité sous http/https'
                    continue
        
        strpage=page.read() #lecture de la page html
        page.close()
        filename = "documents_"+term+str(counter)+".ex"
        soup = BeautifulSoup(strpage,"lxml") #declaration de beautiful soup avec les données de la page html
        for script in soup(["script","style","comments","head","title"]):  #extraction du bruit dans script
            script.extract()
        text_data = soup.get_text() #récupération de toutes les données texte
        if not(text_data.find("FTpanel") == -1):
            continue
        lines = (line.strip() for line in text_data.splitlines()) #retirer les retour chariot supplémentaire
        chunks = (phrase.strip() for line in lines for phrase in line.split("  "))
        text_data = '\n'.join(chunk for chunk in chunks if chunk)
        file = open(filename,"w")
        file.write(text_data.encode('utf-8')) #écrire le résultat dans un fichier
        file.close()
        counter +=1
        print filename +" traite le lien "+url
        if(counter >= int(sys.argv[1])):
            print '\n\n'
            return

for term in open("lexique.txt","r").read().split("\r\n"):
    if(len(term) <= 2 ):
        break
    print 'traitement du terme : '+term
    term_corpus_creator(term)

print 'fin'
