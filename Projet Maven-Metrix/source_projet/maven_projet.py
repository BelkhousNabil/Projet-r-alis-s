
# coding: utf-8

# In[71]:




# In[72]:

# Import necessary libraries
import pandas as pd
import MySQLdb
from pandas import Series, DataFrame


# In[73]:

# Establish connexcion DB
mysql_cn = MySQLdb.connect(host='localhost', 
                port=3306,user='cvsanaly', passwd='cvsanaly', 
                db='maven_trunk')


# In[74]:

# Charge necessary tables
action_files = pd.read_sql('select * from action_files ', con=mysql_cn)
actions = pd.read_sql('select * from actions', con=mysql_cn)
actions_file_names = pd.read_sql('select * from actions_file_names', con=mysql_cn)
commit_graph = pd.read_sql('select * from commit_graph', con=mysql_cn)
file_copies = pd.read_sql('select * from file_copies',con=mysql_cn)
branches = pd.read_sql('select * from branches',con=mysql_cn)

file_links = pd.read_sql('select * from file_links', con=mysql_cn)
files = pd.read_sql('select * from files', con=mysql_cn)
people = pd.read_sql('select * from people', con=mysql_cn)
repositories = pd.read_sql('select * from repositories', con=mysql_cn)
scmlog = pd.read_sql('select * from scmlog',con=mysql_cn)

tag_revisions = pd.read_sql('select * from tag_revisions', con=mysql_cn)
tags = pd.read_sql('select * from tags',con=mysql_cn)


# In[75]:

# how length tables
print 'loaded dataframe action_files. records:', len(action_files)
print 'loaded dataframe actions. records:', len(actions)
print 'loaded dataframe actions_file_names. records:', len(actions_file_names)
print 'loaded dataframe commit_graph. records:', len(commit_graph)
print 'loaded dataframe file_copies. records:', len(file_copies)
print 'loaded dataframe file_links. records:', len(file_links)
print 'loaded dataframe files. records:', len(files)
print 'loaded dataframe people. records:', len(people)
print 'loaded dataframe repositories. records:', len(repositories)
print 'loaded dataframe scmlog. records:', len(scmlog)
print 'loaded dataframe tag_revisions. records:', len(tag_revisions)
print 'loaded dataframe tags. records:', len(tags)


# In[76]:

# Tables: actions_file_names, commit_graph, repositories, tag_revisions and records are empty


# In[77]:

# Display columns for tables
list=[action_files,actions,actions_file_names,file_copies,file_links,files,people,repositories,scmlog,tag_revisions,tags]
list1=['action_files','actions','actions_file_names','file_copies','file_links','files','people','repositories','scmlog','tag_revisions','tags']
for l in range(len(list)):
    print list1[l]+' : '
    for col in list[l].columns :
        print col+'|',
    print ''


# In[78]:

# Display statistics for action_files
action_files.describe()


# In[79]:

# Display statistics for action_files
actions.describe()


# In[80]:

# Display statistics for action_files
scmlog.describe()


# In[81]:

# dispay scmlog table
scmlog


# In[82]:

# dispay branches table
branches


# In[83]:

# dispay action_files table
action_files


# In[84]:

# dispay actions table
actions


# In[85]:

# dispay actions table
actions_file_names


# In[86]:

# dispay commit_graph table
commit_graph


# In[87]:

# dispay file_copies table
file_copies


# In[88]:

# dispay file_links table
file_links


# In[89]:

# dispay files table
files


# In[90]:

# dispay people table
people


# In[91]:

# dispay repositories table
repositories


# In[92]:

# dispay tag_revisions table
tag_revisions


# In[93]:

# dispay tags table
tags 


# In[105]:

# Comput the commit number for each developper
nbComDev= scmlog[['committer_id']].groupby(['committer_id'])


# In[106]:

# Construire un dictionnaire en sortie de l'aggregate pour calculer le nombre de commit par committer_id
# Build a dictionary output for the agregation computing
Result_nbComDev = nbComDev.aggregate({'committer_id':"count"})


# In[107]:

Result_nbComDev


# In[102]:

# Create pie graphic for the number of commit per developper
get_ipython().magic(u'matplotlib inline')
Result_nbComDev.plot(kind='pie',figsize=(10,10),legend=True,subplots=False)


# In[ ]:



