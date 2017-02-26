
# coding: utf-8

# In[2]:

import pandas as pd
import MySQLdb
from pandas import Series, DataFrame


# In[3]:

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

dframe=pd.merge(actions[['file_id','commit_id']],scmlog[['committer_id','id']],left_on='commit_id',right_on='id')


# In[17]:

df = dframe.set_index(['file_id'])


# In[22]:

df.ix[28,['author_id']].value_counts().size


# In[24]:

nbdevs_fram = df.sort_index()[['committer_id']]


# In[25]:

nbdevs = nbdevs_fram.groupby(nbdevs_fram.index)['committer_id'].nunique()


# In[26]:

nbdf = DataFrame(nbdevs)


# In[27]:

nbdf.columns = ['nbdevs']


# In[30]:

pd.merge(df,nba,left_on='?',right_on='?')


# In[31]:

scmdate=scmlog[['id','date','committer_id']]


# In[32]:

scmsubset = scmdate[scmdate['date']>'1/1/2010']


# In[33]:

scmsubset.shape[0]


# In[34]:

nbdevs_frame = scmsubset.sort_index()['committer_id']


# In[36]:

nbdevs_unsorted = nbdevs_frame.groupby(nbdevs_frame.committer_id).size


# In[38]:

nbdevs = nbdevs_unsorted.sort_values(ascending=False)
total = 0
val = nbrdevs.value
for i in range(0,lem(val)):
    total=total+val[i]
    if total >= scmsubset.shape[0]/2:
        print total
        print i
        break


# In[ ]:



