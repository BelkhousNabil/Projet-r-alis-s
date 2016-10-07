cc=gcc

all: ac-matrice ac-liste ac-mixte genere-texte genere-mots clean

ac-matrice: matrice.o file.o ac-matrice.o
	$(cc) $(CFLAGS) ac-matrice.o matrice.o file.o -o ac-matrice

ac-liste: liste.o file.o ac-liste.o
	$(cc) $(CFLAGS) ac-liste.o liste.o file.o -o ac-liste

ac-mixte: mixte.o file.o ac-mixte.o
	$(cc) $(CFLAGS) ac-mixte.o mixte.o file.o -o ac-mixte


ac-matrice.o: AC/ac-matrice.c
	$(cc) -c $(CFLAGS) AC/ac-matrice.c

ac-liste.o: AC/ac-liste.c
	$(cc) -c $(CFLAGS) AC/ac-liste.c

ac-mixte.o: AC/ac-mixte.c
	$(cc) -c $(CFLAGS) AC/ac-mixte.c

matrice.o: struct/matrice.c
	$(cc) -c $(CFLAGS) struct/matrice.c

liste.o: struct/liste.c
	$(cc) -c $(CFLAGS) struct/liste.c

mixte.o: struct/mixte.c
	$(cc) -c $(CFLAGS) struct/mixte.c

file.o: struct/file.c
	$(cc) -c $(CFLAGS) struct/file.c

genere-texte: genere-texte.o
	$(CC) genere-texte.o -o  genere-texte

genere-texte.o: Generateur/genere-texte.c 
	$(CC) -c Generateur/genere-texte.c

genere-mots: genere-mots.o
	$(CC) genere-mots.o -o genere-mots

genere-mots.o: Generateur/genere-mots.c
	$(CC) -c Generateur/genere-mots.c

clean:
	rm -rf *.o;
