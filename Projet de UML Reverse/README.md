Structure du git :
------------------

- documents : contient les documents de gestion de projet. Le document doit être
sous la forme "STB-x-y.pdf" où x est la version, et y la révision ou un nom (si 
le document est à faire en groupe", les sources en Latex de ce doc sont dans le
sous-dossier du même nom.
Un template de document doit être mis en place à la racine du dossier Documents.

- cr : contient les compte rendus de réunions, internes ou avec le client.
Même principe que dans documents, mais les compte rendus sont sous la forme
"AAAA-MM-JJ-x-y.pdf" où x = (c, i) indiquant une réunion avec un client ou en 
interne ; y est un suffixe en cas de numéro de version, ou autre information.

- src : contient les sources du programme.

Pour enregistrer facilement dans votre branche actuelle, vous pouvez utiliser :
$ ./pu.sh "[domaine] texte du commit"
NB : valable que sous linux. curl doit être installé sur votre machine !

Aide sur Latex :
----------------

Petits conseils pour installer latex sur linux: http://doc.ubuntu-fr.org/latex
L'IDE kile est facile à comprendre.
Pour pouvoir compiler, il vous faut certains paquets comme babel
(pour les langues).
Si vous voulez pas vous prendre la tête et que vous avez de la place sur votre
pc installez texlive-full.

Pour modifier le fichier ouvrez le fichier .tex et recompilez le.
Ca mettra à jour le pdf.
