struct _node{
    int target;
    struct _node *next;
};

typedef struct _node* node;

node firstNode; 

void enfiler(int target);

int defiler();

int isEmpty();

void afficherFile();


