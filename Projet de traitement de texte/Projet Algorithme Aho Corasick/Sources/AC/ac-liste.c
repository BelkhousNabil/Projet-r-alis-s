#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include "ac-liste.h"

#define LENGTH_MOT 255
#define TAILLE_MAX 1000
#define TAILLE_MAX_TEXT 5000000

ACListe createACListe(){
	ACListe acListe = (ACListe) malloc (sizeof(ACListe));
	
	acListe->trie = createTrie(maxNode);
	
	acListe->suppleant = (int*) malloc(maxNode * sizeof(int));
	int i;
	for(i=0;i<maxNode;i++){
		acListe->suppleant[i] = -1;
	}
	
	return acListe;
}

ACListe preAC(char** mots, int nbrMots){
	ACListe acListe = createACListe();
	int i;
	for(i = 0; i < nbrMots; i++){
		if(mots[i] == NULL){
			break;
		}
		else{
			insertInTrie(acListe->trie, mots[i]);
		}
	}
	completer(acListe);
	
	return acListe;
}

void completer(ACListe acListe){
	initFile();
	
	int i, suppleant; 
	List l = acListe->trie->transition[0];
	List tmp = NULL;
	
	// Creation d'une liste qui contient toute l'alphabet avec un target qui egale à 0
	List tmpListTransition0 = NULL ;
	for(i = 0; i < alphabet ; i++){
		addListeNode(&tmpListTransition0, (char) i, 0);
	}
	
	while(l != NULL){
		enfiler(l->targetNode);
		acListe->suppleant[l->targetNode] = 0;
		tmp = findNodeByLettre( l, l->letter);
		tmp->targetNode = l->targetNode;
		l = l->next;
	}
	
	l = tmpListTransition0;
	
	while(!isEmpty()){
		int r = defiler();
		l = acListe->trie->transition[r];
		while(l != NULL){
			enfiler(l->targetNode);
			suppleant = acListe->suppleant[r];
			while(findNodeByLettre(acListe->trie->transition[suppleant], l->letter) == NULL){
				suppleant = acListe->suppleant[suppleant];
			}
			acListe->suppleant[l->targetNode] = findNodeByLettre(acListe->trie->transition[suppleant], l->letter)->targetNode;
			acListe->trie->finite[l->targetNode] +=  acListe->trie->finite[acListe->suppleant[l->targetNode]];
			l = l->next;
		}
	}
}

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght){
	ACListe acListe = preAC(mots, nbrMots);
	int target = 0, nbrOcc = 0, i;
	for( i = 0; i < textLenght; i++){
		while(findNodeByLettre(acListe->trie->transition[target], text[i]) == NULL ){
			target = acListe->suppleant[target];
		}
		target = findNodeByLettre(acListe->trie->transition[target], text[i])->targetNode;
		nbrOcc += acListe->trie->finite[target];
	}
	printf("AC-LISTE - Le nombre d'occurence est : %d\n", nbrOcc);	
}

void affichageSup(ACListe acListe){
    int i;
    for(i=0;i<maxNode;i++){
		if(acListe->suppleant[i] != -1){
			printf("Sup[%d] = %d \n",i,acListe->suppleant[i]);
		}
    }
}


int main(int argc, char **argv)
{	
	clock_t tDeb,tFin;
    float temps_execution;
    
	if(argc >= 2){
		char* motsFileName = argv[1];
		char* textFileName = argv[2];
		
		FILE* textFile = fopen(textFileName, "r");
		FILE* motsFile = fopen(motsFileName, "r");
		
		char** mots = (char**) malloc(TAILLE_MAX * sizeof(char*));
		char text[TAILLE_MAX_TEXT];
		
		if (textFile == NULL || motsFile == NULL){
			printf("Erreur dans la lecture du fichier\n");
			exit (0);
		}
		else{	
			int i = 0;
			char* tmpMot = malloc(LENGTH_MOT * sizeof(char));
			while(fgets(tmpMot, LENGTH_MOT, motsFile) != NULL){
				mots[i] = malloc(LENGTH_MOT * sizeof(char)); 
				strcpy(mots[i], strtok(tmpMot, "\n"));
				i++;
			}
			
			fscanf(textFile, "%s", text);
			int lenghtText = strlen(text);
			
			tDeb=clock();
			ac(mots, TAILLE_MAX, text, lenghtText);
			tFin=clock();
			fclose(textFile);
			fclose(motsFile);
			
			temps_execution =(float)(tFin-tDeb)/CLOCKS_PER_SEC;
			printf("Le temps d'exécution est: %f s\n",temps_execution);
			
		}
	}
	else{
		printf("Il vous manque des paramètres\n");
	}
	
	return 0;
}
