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

# Afficher un petit message pour 
print 'loaded dataframe from MySQL. records:', len(actions)
print 'loaded dataframe from MySQL. records:', len(files)
print 'loaded dataframe from MySQL. records:', len(people)
print 'loaded dataframe from MySQL. records:', len(scmlog)

actions


# La table avec tous les commits
scmlog

# Les dimensions du dataframe
scmlog.shape

# Le nombre de cellules du dataframe
scmlog.size

# Combien de fois un fichier a été modifié. Dans la colonne de gauche on voit l'ID du fichier.

nbactions=actions['file_id'].value_counts()
nbactions

# De quel type est nbactions
type(nbactions)


# Transformer nbactions en DataFrame
nbact=pd.DataFrame(nbactions)
nbact

# Corrigeons le nom de la colonne

nbact.columns=(['freq'])
nbact

# Le ID d'un fichier n'est pas très parlant. Essayons d'ajouter le nom du fichier

nba=pd.merge(nbact,flinks[['file_id','file_path']],left_index=True, right_on='file_id')
nba

# Faisons un tri par nombre de modifs. ATTENTION : le DataFrame reste modifié après
nba.sort(['freq'],ascending=False)

# Filtrons uniquement les fichiers avec du code
nba[nba['file_path'].map(lambda x: x.endswith('.c'))]
