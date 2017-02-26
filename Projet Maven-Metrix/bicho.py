
# coding: utf-8

# In[77]:




# In[78]:

import pandas as pd
import MySQLdb
from pandas import Series, DataFrame


# In[79]:

# Etablir une connexion avec la base MySQL (chargement des base de la BD)
mysql_cn = MySQLdb.connect(host='localhost', 
                port=3306,user='root', passwd='milaha', 
                db='bicho_maven')


# In[80]:

# Charger les tables qui nous interessent
changes = pd.read_sql('select * from changes', con=mysql_cn)
comments = pd.read_sql('select * from comments', con=mysql_cn)
issues = pd.read_sql('select * from issues', con=mysql_cn)
issues_ext_jira = pd.read_sql('select * from issues_ext_jira', con=mysql_cn)
people = pd.read_sql('select * from people', con=mysql_cn)
attachments = pd.read_sql('select * from attachments', con=mysql_cn)
issues_watchers= pd.read_sql('select * from issues_watchers', con=mysql_cn)
trackers = pd.read_sql('select * from trackers', con=mysql_cn)
related_to = pd.read_sql('select * from related_to', con=mysql_cn)
supported_trackers = pd.read_sql('select * from supported_trackers', con=mysql_cn)


# In[81]:

# les beugs sont représentés dans cette table
issues


# In[65]:

#Affichage de la table
changes


# In[33]:

#Affichage de table
people


# In[34]:

# Display columns for tables
list=[changes,comments,issues,issues_ext_jira,people,attachments,issues_watchers,trackers,related_to,supported_trackers]
list1=['changes','comments','issues','issues_ext_jira','people','attachments','issues_watchers','trackers','related_to','supported_trackers']
for l in range(len(list)):
    print list1[l]+' : '
    for col in list[l].columns :
        print col+'|',
    print ''


# In[36]:

# how length tables
print 'loaded dataframe changes records:', len(changes)
print 'loaded dataframe comments records:', len(comments)
print 'loaded dataframe issues records:', len(issues)
print 'loaded dataframe issues_ext_jira records:', len(issues_ext_jira)
print 'loaded dataframe people records:', len(people)
print 'loaded dataframe attachments records:', len(attachments)
print 'loaded dataframe trackers records:', len(trackers)
print 'loaded dataframe people records:', len(people)
print 'loaded dataframe related_to records:', len(related_to)
print 'loaded dataframe supported_trackers records:', len(supported_trackers)


# In[104]:

issues_ext_jira


# In[107]:

trackers


# In[82]:

# COMPUTE THE NUMBER OF RESOLUTION FOR EACH TYPE RESOLUTION
iss = issues[['resolution']].groupby(issues.resolution)['resolution'].count()

#Afficher le résultat
iss


# In[83]:

# DISPLAY RESULTS
get_ipython().magic(u'matplotlib inline')
iss.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[84]:

# DISPLAY TYPE OF ISSUES
t=issues[['type']].groupby(issues.type)['type'].count()


# In[66]:

t


# In[42]:

get_ipython().magic(u'matplotlib inline')
t.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[85]:

# GET THE DIFFRENT STATUS OF ISSUES (open or close)
s=issues[['status']].groupby(issues.status)['status'].count()


# In[86]:

get_ipython().magic(u'matplotlib inline')
s.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[87]:

# DISPLAY THE BUGS THAT ARE  NOT RESOLVED 
issues[issues['resolution']=='']


# In[88]:

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


# In[89]:

# Prendre uniquement une colonne en occurence status par exemple juste pour compter le nombre de ligne peut importe a colonne
from datetime import datetime
res = newdf[['status']].groupby(pd.Grouper(freq='Q-DEC')).aggregate(pd.Series.count)


# In[90]:

get_ipython().magic(u'matplotlib inline')
res.plot(kind='bar',figsize=(20,10))


# In[93]:

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
grouped.aggregate(pd.Series.count)


# In[94]:

# récupérer le dernier changement
last_change = grouped.tail(1)[['issue_id','changed_on']]


# In[95]:

# Prendre uniquement les information nécessaire pour la construction de notre nouveau dataframe
first_change = issues[['id','type','resolution','submitted_on']]


# In[96]:

# regarder uniquement les bugs fixés
fixed = first_change[first_change['resolution'] == 'FIXED']


# In[97]:

# merge (join) entre les beug fixed et les beugs changé dernierement
resolu = pd.merge(last_change,fixed,left_on='issue_id',right_on='id',how='right')


# In[98]:

# soustration de fata frame
tdelta = pd.DataFrame(resolu[['changed_on']].sub(resolu['submitted_on'], axis=0)['changed_on'])


# In[99]:

# affichage
tdelta


# In[100]:

# merger le resultat avec la table précedente pour plus de conpréhension
bug_corr = pd.merge(tdelta,resolu,left_index=True,right_index=True)


# In[101]:

bug_corr


# In[102]:

# faire la moyenne de temps de correction de beugs
# faire une moyenne par trimestre est préférable surtout pour un projet qui date de plus de 10 ans
# faire un group by trimestre
# Q-DEC : Quaterly = (trimestre) , DEC = (commencer par le mois de décembre)
# Recombiner les données ensemble en donnant la moyenne (agregate merger par l'index commun)
bug_corr.set_index('submitted_on').groupby(pd.Grouper(freq='Q-DEC')).aggregate(pd.Series.mean)


# In[ ]:

###################################################


# In[126]:

factor12 = issues_ext_jira[['component','environment']]
factor12


# In[137]:

factor3 = issues[['id','priority']]
factor3


# In[138]:

# MERGE 1
merge1 = pd.merge(factor12,factor3,left_index=True,right_index=True)
merge1


# In[131]:

#  NUMBER OF DEVELOPPER THAT INTERACTIN BUGS GROUPE BY BUGS
factor4 = changes[['issue_id']].groupby(changes['issue_id']).count()
factor4.columns = [['Number_in_the_CC']]


# In[132]:

changes_bugs


# In[139]:

# MERGE 2
merge2 = pd.merge(merge1,factor4,left_index='issue_id',right_index='id')
merge2


# In[140]:

# MERGE 3
merge3 = pd.merge(merge2,attachments[['description','issue_id']],left_index='issue_id',right_index='id')
merge3


# In[141]:

# MERGE 4
merge4 = pd.merge(merge3,comments[['text','issue_id']],left_index='issue_id',right_index='id')
merge4


# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:




# In[ ]:



