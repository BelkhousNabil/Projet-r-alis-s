#define alphabet 256

struct _trie {
int maxNode; /* Nombre maximal de noeuds du trie */
int nextNode; /* Indice du prochain noeud disponible */
int **transition; /* matrice de transition */
int *finite; /* etats terminaux */
};

typedef struct _trie *Trie;
Trie createTrie(int maxNode);
void insertInTrie(Trie trie, unsigned char *w);
