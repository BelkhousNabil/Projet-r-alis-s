#include <stdio.h>
#include <stdlib.h>
#include "liste.h"

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


Trie createTrie(int maxNode)
{   
	int i, j;
	Trie t  = (Trie) malloc (sizeof(Trie));
	t->maxNode = maxNode;
	t->nextNode = 0;
	
    // allocation de la memoire pour la matrice de transition
    t->transition = (List*) malloc(maxNode * sizeof(List*));

    for (i = 0; i < maxNode; i++)
        t->transition[i] = NULL;
   
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
    int indexTrie = 0;
	int j = 0; 
	while(w[j] != '\0'){
		List tmp = trie->transition[indexTrie];
		while(tmp != NULL){
			if(tmp->letter == w[j]){
				indexTrie = tmp->targetNode;
				j++;
				break;
			}
			else{
				tmp = tmp->next;
			}
		}
		if(tmp == NULL){
			addListeNode(&trie->transition[indexTrie], w[j], ++trie->nextNode);
			j++;
			indexTrie = trie->nextNode;
		}		
	}	
	trie->finite[indexTrie] = 1;
}

AffichageTrie(Trie trie)
{	
	int i;
	for(i= 0; i < trie->maxNode; i++){
		if(trie->transition[i] != NULL){
			List tmp =  trie->transition[i];
			printf("%d",i);
			while(tmp != NULL){
				printf("------->[%c][%d] ",tmp->letter, tmp->targetNode);
				tmp = tmp->next;
			}
			printf("\n");
		}
	}
	printf("******************************************\n");
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
