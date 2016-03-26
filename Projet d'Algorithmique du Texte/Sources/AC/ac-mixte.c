#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include "ac-mixte.h"

#define LENGTH_MOT 255
#define TAILLE_MAX 1000
#define TAILLE_MAX_TEXT 5000000

ACMixte createACMixte(){
	ACMixte acMixte = (ACMixte) malloc (sizeof(ACMixte));
	
	acMixte->trie = createTrie(maxNode);
	
	acMixte->suppleant = (int*) malloc(maxNode * sizeof(int));
	int i;
	for(i=0;i<maxNode;i++){
		acMixte->suppleant[i] = -1;
	}
	return acMixte;
}

ACMixte preAC(char** mots, int nbrMots){
	ACMixte acMixte = createACMixte();
	int i;
	for(i = 0; i < nbrMots; i++){
		if(mots[i] == NULL){
			break;
		}
		else{
			insertInTrie(acMixte->trie, mots[i]);
		}
	}
		
	for(i = 0; i < alphabet; i++){
		if(acMixte->trie->transitionRoot[i] == -1){
			acMixte->trie->transitionRoot[i] = 0;
		}
	}
	
	completer(acMixte);
	
	return acMixte;
}

void completer(ACMixte acMixte){
	initFile();
	
	int i, suppleant, targetNode; 
	
	for(i = 0; i < alphabet; i++){
		targetNode = acMixte->trie->transitionRoot[i];
		if(targetNode != 0){
			enfiler(targetNode);
			acMixte->suppleant[targetNode] = 0;
		} 
	}

	List l = NULL;
	
	while(!isEmpty()){
		int r = defiler();
		l = acMixte->trie->transitionOthers[r];
		while(l != NULL){
			enfiler(l->targetNode);
			suppleant = acMixte->suppleant[r];
			while(getTargetNodeInTrie(acMixte->trie, suppleant, l->letter) == -1){
				suppleant = acMixte->suppleant[suppleant];
			}
			acMixte->suppleant[l->targetNode] = getTargetNodeInTrie(acMixte->trie, suppleant, l->letter);
			acMixte->trie->finite[l->targetNode] +=  acMixte->trie->finite[acMixte->suppleant[l->targetNode]];
			l = l->next;
		}
	}
}

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght){
	ACMixte acMixte = preAC(mots, nbrMots);
	int target = 0, nbrOcc = 0, i;
	for( i = 0; i < textLenght; i++){
		while(getTargetNodeInTrie(acMixte->trie, target, text[i]) == -1 ){
			target = acMixte->suppleant[target];
		}
		target = getTargetNodeInTrie(acMixte->trie, target, text[i]);
		nbrOcc +=   acMixte->trie->finite[target];
	}
	printf("AC-MIXTE - Le nombre d'occurence est : %d\n", nbrOcc);	
}

void affichageSup(ACMixte acMixte){
    int i;
    for(i=0;i<maxNode;i++){
		if(acMixte->suppleant[i] != -1){
			printf("Sup[%d] = %d \n",i,acMixte->suppleant[i]);
		}
    }
}

int main(int argc, char **argv){	
	clock_t tDeb,tFin;
    float temps_execution;
    
	if(argc >= 2){
		char* motsFileName = argv[1];
		char* textFileName = argv[2];
		char** mots = malloc(TAILLE_MAX * sizeof(char*));
		char* tmpMot = malloc(LENGTH_MOT * sizeof(char));
		FILE* textFile = fopen(textFileName, "r");
		FILE* motsFile = fopen(motsFileName, "r");
		
		char* text = malloc(TAILLE_MAX_TEXT * sizeof(char));
		
		if (textFile == NULL || motsFile == NULL){
			printf("Erreur dans la lecture du fichier\n");
			exit (0);
		}
		else{	
			int i = 0; 
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

