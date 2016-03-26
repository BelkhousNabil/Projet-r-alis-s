#include <stdio.h>
#include <stdlib.h>
#include "matrice.h"

Trie createTrie(int maxNode)
{   
	int i ,j;
	Trie t  = (Trie) malloc (sizeof(Trie));
	t->maxNode = maxNode;
	t->nextNode = 0;
	
    // allocation de la memoire pour la matrice de transition
    t->transition = (int**) malloc(maxNode * sizeof(int*));

    for (i = 0; i < maxNode; i++)
        t->transition[i] = (int*) malloc((alphabet) * sizeof(int));
        
    // allocation du tableau des etats
      
	t->finite = (int*) malloc(maxNode * sizeof(int));
      
	//****************************************** 
	for (i=0;i<maxNode;i++)
	{
		for (j=0;j<alphabet;j++)  
		{
			t->transition[i][j] = -1;
		}  
	}
	  
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
    int codeAscii =-1;
	int i,memo = 0,j=0,booleen=0,fin=0;
	
	// traitement du premier mot donner
	if (trie->nextNode == 0) // premier ajout dans le trie
	{
		while (w[j] != '\0')
		{  
			codeAscii = w[j];
			trie->transition[trie->nextNode][codeAscii] = trie->nextNode+1;
			trie->nextNode++;
			j++;
		}	
		trie->finite[trie->nextNode] = 1;	
	} 
	else{	
		codeAscii = w[j];
		if (trie->transition[0][codeAscii] == -1) // ajout depuis la racine E
		{
			trie->transition[0][codeAscii] = trie->nextNode+1;
			trie->nextNode++;
			j++;
			while (w[j] != '\0')
			{                              
				codeAscii = w[j];
				trie->transition[trie->nextNode][codeAscii] = trie->nextNode+1;
				trie->nextNode++;
				j++;
			}
			trie->finite[trie->nextNode] = 1;
		}
		else // ajout depuis un noeud au milieu
		{	
			j=0;booleen = 0;				
			while (w[j] != '\0')
			{
				booleen = 0;
				while ((memo < trie->nextNode) && (booleen == 0))
				{	
					codeAscii = w[j];					
					if (trie->transition[memo][codeAscii] != -1) // existe un chemin
					{
						memo = trie->transition[memo][codeAscii]; // enregister le dernier noeud du chemin
						j++;// Avancer au prochaine caractere de 'w'
					}
					else if (trie->transition[memo][codeAscii] == -1)// fin du chemin existant
					{
						trie->transition[memo][codeAscii] = trie->nextNode+1;
						trie->nextNode++;
						j++;
						fin = 1;
						booleen=1;
					}
					
				}
				while (w[j] != '\0')
					{  
						codeAscii = w[j];
						trie->transition[trie->nextNode][codeAscii] = trie->nextNode+1;
						trie->nextNode++;
						j++;
					}
				trie->finite[trie->nextNode] = 1;
			}	
										
		}					
	}                         
}
	
AffichageTrie(Trie trie)
{
	int i,j;
	//******************************************
    for (i=0;i<trie->maxNode;i++)
    {	
		printf("\n%d : ",i);
		for (j=0;j<alphabet;j++)  
        {		
			if (trie->transition[i][j] != -1)
			{	
                printf("-------->[%c][%d]",(char)j,trie->transition[i][j]);
            }
              
        }  
    }
	printf("******************************************\n");
	for (i=0;i<trie->maxNode;i++)
    {	
		if(trie->finite[i] != 0)
			printf("[%d] = %c \n\n",i,trie->finite[i]);
    }
    
   //******************************************	
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
