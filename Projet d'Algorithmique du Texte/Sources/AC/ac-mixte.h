#include "../struct/file.h"
#include "../struct/mixte.h" 
#define maxNode 100000

struct _ACMixte{
	Trie trie;
	int* suppleant;
};

typedef struct _ACMixte* ACMixte;

ACMixte createACListe();

ACMixte preAC(char** mots, int nbrMots);

void completer(ACMixte acMixte);

void affichageSup(ACMixte acMixte);

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght);
