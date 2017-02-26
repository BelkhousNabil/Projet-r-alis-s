
# coding: utf-8

# In[2]:

import pandas as pd
import MySQLdb
from pandas import Series, DataFrame


# Etablir une connexion avec la base MySQL
mysql_cn = MySQLdb.connect(host='localhost', 
                port=3306,user='cvsanaly', passwd='cvsanaly', 
                db='httpd_trunk')

# Charger les tables qui nous interessent
actions = pd.read_sql('select * from actions where branch_id=\'1\';', con=mysql_cn)
files = pd.read_sql('select * from files', con=mysql_cn)
people = pd.read_sql('select * from people', con=mysql_cn)
scmlog = pd.read_sql('select * from scmlog', con=mysql_cn)
flinks = pd.read_sql('select * from file_links',con=mysql_cn)


# In[3]:

# Afficher un petit message pour 
print 'loaded dataframe from MySQL. records:', len(actions)
print 'loaded dataframe from MySQL. records:', len(files)
print 'loaded dataframe from MySQL. records:', len(people)
print 'loaded dataframe from MySQL. records:', len(scmlog)


# In[4]:

actions


# In[5]:

# La table avec tous les commits
scmlog


# In[6]:

# Les dimensions du dataframe
scmlog.shape


# In[7]:

# Le nombre de cellules du dataframe
scmlog.size


# In[8]:

# Combien de fois un fichier a été modifié. Dans la colonne de gauche on voit l'ID du fichier.

nbactions=actions['file_id'].value_counts()
nbactions


# In[9]:

# De quel type est nbactions
type(nbactions)


# In[10]:

# Transformer nbactions en DataFrame
nbact=pd.DataFrame(nbactions)
nbact


# In[11]:

# Corrigeons le nom de la colonne
nbact.columns=(['freq'])
nbact


# In[12]:

# Le ID d'un fichier n'est pas très parlant. Essayons d'ajouter le nom du fichier
nba=pd.merge(nbact,flinks[['file_id','file_path']],left_index=True, right_on='file_id')
nba


# In[13]:

# Faisons un tri par nombre de modifs. ATTENTION : le DataFrame reste modifié après
nba.sort(['freq'],ascending=False)


# In[14]:

# Filtrons uniquement les fichiers avec du code
nba[nba['file_path'].map(lambda x: x.endswith('.c'))]


# In[16]:

nscm = scmlog[['date','committer_id']]


# In[23]:

#regrouppememnt
get_ipython().magic(u'matplotlib inline')
nscm.set_index(nscm.date)[['committer_id']].groupby(pd.Grouper(freq='Q-DEC')).aggregate(pd.Series.nunique).plot(kind='bar',figsize=(20,10))


# In[25]:

# Comment calculer le nombre de commit par trimestre et par developpeur
# On va faire un groupe selon deux critère et non pas deux group by
nbrcomdev = scmlog[['committer_id']].set_index(scmlog.date).groupby([pd.Grouper(freq='Q-DEC'),'committer_id'])


# In[38]:

# Construire un dictionnaire en sortie de l'aggregate pour calculer le nombre de commit par committer_id
nbrcomdev_agregate = nbrcomdev.aggregate({'committer_id':"count"})


# In[39]:

nbrcomdev_agregate


# In[40]:

# information sur la dataframe
get_ipython().magic(u'pinfo nbrcomdev_agregate.index')


# In[42]:

#enlever la colonne committeur_id (enlever le deuxieme index avec froplevel(1))
newdf = nbrcomdev_agregate.set_index(nbrcomdev_agregate.index.droplevel(1))


# In[43]:

get_ipython().magic(u'matplotlib inline')
newdf.groupby(newdf.index).aggregate(pd.Series.mean).plot(kind='bar',figsize=(20,10))


# In[ ]:



