#include <stdio.h>
#include <stdlib.h>
#include "mixte.h"

void addListeNode(List* liste, unsigned char c, int index){
	if(*liste == NULL){
		List new = (List) malloc(sizeof(List));
		new->targetNode = index;
		new->letter = c;
		new->next = NULL;
		*liste = new;
	}
	else{
		List tmp;
		tmp = *liste;
		while(tmp->next != NULL){
				tmp = tmp->next;
		}
		List new = (List) malloc(sizeof(List));
		new->targetNode = index;
		new->letter = c;
		new->next = NULL;
		tmp->next = new;
	}
}

List findNodeByLettre(List liste, unsigned char c){
	List tmp = liste;
	while(tmp != NULL){
		if(tmp->letter == c){
			return tmp;
		}
		tmp = tmp->next;
	}
	
	return NULL;
}

int getTargetNodeInTrie(Trie trie, int indexNodeTransition, char c){
	
	if(indexNodeTransition == 0){
		return trie->transitionRoot[(int) c];
	}
	else{
		List tmp = findNodeByLettre(trie->transitionOthers[indexNodeTransition], c);
		if(tmp != NULL){
			return tmp->targetNode;
		}
	}
	
	return -1;
}

Trie createTrie(int maxNode)
{   
	int i, j;
	Trie t  = (Trie) malloc (sizeof(Trie));
	t->maxNode = maxNode;
	t->nextNode = 0;
	
	// allocation de la mémoire pour le tableau d'état 0
	t->transitionRoot = (int*) malloc(alphabet * sizeof(int*));
	for (i = 0; i < alphabet; i++)
        t->transitionRoot[i] = -1;
	
	
    // allocation de la memoire pour la liste d'adjacence
    t->transitionOthers = (List*) malloc(maxNode * sizeof(List*));

    for (i = 0; i < maxNode; i++)
        t->transitionOthers[i] = NULL;
   
	// allocation du tableau des etats
    t->finite = (int*) malloc(maxNode * sizeof(int));
       
	// initialisation du tabealu des fineaux
	for (i=0;i<maxNode;i++)
	{         
		t->finite[i] = 0;		
	}
	
	//******************************************
    return t;	
}


void insertInTrie(Trie trie, unsigned char *w)
{	
	if(strcmp(w,"") == 0){
		return;
	}
	
    int indexTrie = 0, j = 1, codeAscii = w[0], isFirstinsert = 1; 
	if(trie->transitionRoot[codeAscii] == -1){
		trie->transitionRoot[codeAscii] = ++trie->nextNode;
		indexTrie = trie->nextNode;
	}
	else{
		indexTrie = trie->transitionRoot[codeAscii];
	}
	
	while(w[j] != '\0'){
		List tmp = trie->transitionOthers[indexTrie];
		
		while(tmp != NULL && tmp->letter != w[j]) {
			tmp = tmp->next;
		}
		
		if(tmp == NULL){
			addListeNode(&trie->transitionOthers[indexTrie], w[j], ++trie->nextNode);
			indexTrie = trie->nextNode;
		}
		else{
			indexTrie = tmp->targetNode;
		}
		
		j++;
	}
	trie->finite[indexTrie] = 1;
}		
		
AffichageTrie(Trie trie)
{	
	int i,j;
	for(i= 0; i < alphabet; i++){
		if(trie->transitionRoot[i]!=-1){
			printf("[%d] = %d ||| ",i,trie->transitionRoot[i]);
		}
	}
	printf("\n******************************************\n");
	for(j=0;j<trie->maxNode;j++){
		List tmp =  trie->transitionOthers[j];
		printf("\n%d : ",j);
		while(tmp != NULL){
			printf("------->[%c][%d] ",tmp->letter, tmp->targetNode);
			tmp = tmp->next;
		}
	}
	printf("\n******************************************\n");
	for (i=0;i<trie->maxNode;i++)
    {	
		if(trie->finite[i] != 0)
			printf("[%d] = %c \n\n",i,trie->finite[i]);
    }
}

/*
int main(void)
{        
    Trie t = createTrie(40);
	insertInTrie(t ,"cbbabc");
	insertInTrie(t ,"abb");
	insertInTrie(t ,"bcbbc");
	insertInTrie(t ,"cbbac");
	insertInTrie(t ,"cccb");
	insertInTrie(t ,"abba");
	insertInTrie(t ,"bba");
	insertInTrie(t ,"aacb");
	insertInTrie(t ,"aba");
	insertInTrie(t ,"ccabac");
	AffichageTrie(t);
    system("pause");
    return 0;
}
*/
