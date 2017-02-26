
# coding: utf-8

# In[2]:

import pandas as pd
import MySQLdb
from pandas import Series, DataFrame


# In[3]:

# Etablir une connexion avec la base MySQL (chargement des base de la BD)
mysql_cn = MySQLdb.connect(host='localhost', 
                port=3306,user='root', passwd='nabil', 
                db='bicho_apache')


# In[4]:

# Charger les tables qui nous interessent
changes = pd.read_sql('select * from changes', con=mysql_cn)
comments = pd.read_sql('select * from comments', con=mysql_cn)
issues = pd.read_sql('select * from issues', con=mysql_cn)
issues_ext_bugzilla = pd.read_sql('select * from issues_ext_bugzilla', con=mysql_cn)
people = pd.read_sql('select * from people', con=mysql_cn)


# In[5]:

#Affichage de la table
changes


# In[6]:

# les beugs sont représentés dans cette table
issues


# In[7]:

# combient il y a de beug résolu et non réolu sous format de graphe
# organisé les cout en categorie(groupby)
# on doit le trasformer car c'est pas une série sachat que le count travail uniquement sur les seriesGroup by
# et la on a un objet de type group by, dont on fait rajoute [resoltion] pour le trasformer en serieGroupby
iss = issues[['resolution']].groupby(issues.resolution)['resolution'].count()


# In[8]:

#Afficher le résultat
iss


# In[9]:

# créer le graphe

# comme je ne peux pas faire ipython notebook --matplotlib inline et que je fais matplotlib=inline
# je rajoute %matplotlib inline
get_ipython().magic(u'matplotlib inline')
iss.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[10]:

# affiche du graphe selon le type
t=issues[['type']].groupby(issues.type)['type'].count()


# In[11]:

get_ipython().magic(u'matplotlib inline')
t.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[12]:

# affiche du graphe selon le status
s=issues[['status']].groupby(issues.status)['status'].count()


# In[13]:

get_ipython().magic(u'matplotlib inline')
s.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[14]:

# faire ressortir tout les beugs qui ne sont pas encore résolu (resolution== '')
issues[issues['resolution']=='']


# In[15]:

# calculer le nombre de beug par trimestre

# on va commenncer par modifier le dataset en mettant la colonne submitted_on comme index de la table issues
# mais on fabrique un nouveau dataframe pour ne pas toucher a issus
# Le temps moyen d'une correction pour un beug
# il faut essayer de trouver la date de résolution peut être dans changes(le dernier change d'un beug)
# on sinteresse uniquement qu'aux beugs fixed et résolved
# introduire la date dans la table changes pour chaque changement(ligne)
# dans la table issues, on fait un merge avec le bug_id et les beugs resolved and closes pour issues, et aussi le submitted on
# La différence entre la date de début de bug et la date de subbmitted on.
# faire la moyenne
# faire la moyenne par trimestre
newdf = issues.set_index(pd.to_datetime(issues.submitted_on))


# In[16]:

# Prendre uniquement une colonne en occurence status par exemple juste pour compter le nombre de ligne peut importe a colonne
from datetime import datetime
res = newdf[['status']].groupby(pd.Grouper(freq='Q-DEC')).aggregate(pd.Series.count)


# In[17]:

get_ipython().magic(u'matplotlib inline')
res.plot(kind='bar',figsize=(20,10))


# In[18]:

# Le temps moyen d'une correction pour un beug
# il faut essayer de trouver la date de résolution peut être dans changes(le dernier change d'un beug)
# on sinteresse uniquement qu'aux beugs fixed et résolved
# introduire la date dans la table changes pour chaque changement(ligne)
# dans la table issues, on fait un merge avec le bug_id et les beugs resolved and closes pour issues, et aussi le submitted on
# La différence entre la date de début de bug et la date de subbmitted on.
# faire la moyenne
# faire la moyenne par trimestre


# In[21]:

# Avec la table changes, on fera un groupement pour chaque issues_id on veux avoir tout les changement qui ont eu lieu
# et pour chaque regrouppement, on prend la dernière valeur c.a.d le dernier changement
grouped = changes.groupby(changes['issue_id']) 
# or changes['issue_id'] = changes.issue_id


# In[22]:

# récupérer le dernier changement
last_change = grouped.tail(1)[['issue_id','changed_on']]


# In[26]:

# Prendre uniquement les information nécessaire pour la construction de notre nouveau dataframe
first_change = issues[['id','type','resolution','submitted_on']]


# In[28]:

# regarder uniquement les bugs fixés
fixed = first_change[first_change['resolution'] == 'FIXED']


# In[41]:

# merge (join) entre les beug fixed et les beugs changé dernierement
resolu = pd.merge(last_change,fixed,left_on='issue_id',right_on='id',how='right')


# In[49]:

# soustration de fata frame
tdelta = pd.DataFrame(resolu[['changed_on']].sub(resolu['submitted_on'], axis=0)['changed_on'])


# In[50]:

# affichage
tdelta


# In[51]:

# merger le resultat avec la table précedente pour plus de conpréhension
bug_corr = pd.merge(tdelta,resolu,left_index=True,right_index=True)


# In[52]:

bug_corr


# In[56]:

# faire la moyenne de temps de correction de beugs
# faire une moyenne par trimestre est préférable surtout pour un projet qui date de plus de 10 ans
# faire un group by trimestre
# Q-DEC : Quaterly = (trimestre) , DEC = (commencer par le mois de décembre)
# Recombiner les données ensemble en donnant la moyenne (agregate merger par l'index commun)
bug_corr.set_index('submitted_on').groupby(pd.Grouper(freq='Q-DEC')).aggregate(pd.Series.mean)


# In[63]:

# prendre uniquement les jours car les milli secondes rendre la construction de graphe difficile.
# pour cela on va créer une fonctin lambda
get_ipython().magic(u'matplotlib inline')
bug_corr[['changed_on_x']].apply(lambda x:x.astype('timedelta64[D]')).plot(kind='bar',figsize=(20,10))


# In[ ]:



