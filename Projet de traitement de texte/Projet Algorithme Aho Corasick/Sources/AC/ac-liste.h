#include "../struct/file.h"
#include "../struct/liste.h" 
#define maxNode 100000

struct _ACListe{
	Trie trie;
	int* suppleant;
};

typedef struct _ACListe* ACListe;

ACListe createACListe();

ACListe preAC(char** mots, int nbrMots);

void completer(ACListe acListe);

void affichageSup(ACListe acListe);

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght);
