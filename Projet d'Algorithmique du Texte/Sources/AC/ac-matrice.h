#include "../struct/file.h"
#include "../struct/matrice.h" 
#define maxNode 100000

struct _ACMatrice{
	Trie trie;
	int* suppleant;
};

typedef struct _ACMatrice* ACMatrice;

ACMatrice createACMatrice();

ACMatrice preAC(char** mots, int nbrMots);

void completer(ACMatrice acMatrice);

void affichageSup(ACMatrice acMatrice);

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght);
