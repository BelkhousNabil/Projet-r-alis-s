#define alphabet 256

struct _list {
	int targetNode; /* cible de la transition */
	unsigned char letter; /* etiquette de la transition */
	struct _list *next; /* maillon suivant */
};

typedef struct _list* List;

struct _trie {
	int maxNode; /* Nombre maximal de noeuds du trie */
	int nextNode; /* Indice du prochain noeud disponible */
	int *transitionRoot; /* transitions de la racine */
	List *transitionOthers; /* transitions des autres noeuds */
	int *finite; /* etats terminaux */
};

typedef struct _trie *Trie;
void addListeNode(List* liste, unsigned char c, int index);
Trie createTrie(int maxNode);
void insertInTrie(Trie trie, unsigned char *w);
List findNodeByLettre(List liste, unsigned char c);
int getTargetNodeInTrie(Trie trie, int indexNodeTransition, char c);
