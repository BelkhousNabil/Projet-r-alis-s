#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include "ac-matrice.h"

#define LENGTH_MOT 255
#define TAILLE_MAX 1000
#define TAILLE_MAX_TEXT 5000000

ACMatrice createACMatrice(){
	ACMatrice acMatrice = (ACMatrice) malloc (sizeof(ACMatrice));
	
	acMatrice->trie = createTrie(maxNode);
	
	acMatrice->suppleant = (int*) malloc(maxNode * sizeof(int));
	int i;
	for(i=0;i<maxNode;i++){
		acMatrice->suppleant[i] = -1;
	}
	
	return acMatrice;
}

ACMatrice preAC(char** mots, int nbrMots){
	ACMatrice acMatrice = createACMatrice();
	int i;
	for(i = 0; i < nbrMots; i++){
		if(mots[i] == NULL){
			break;
		}
		else{
			insertInTrie(acMatrice->trie, mots[i]);
		}
	}
	
	for(i = 0; i < alphabet; i++){
		if(acMatrice->trie->transition[0][i] == -1){
			acMatrice->trie->transition[0][i] = 0;
		}
	}
	completer(acMatrice);
	
	return acMatrice;
}

void completer(ACMatrice acMatrice){
	initFile();
	
	int i, suppleant; 
	int * l = acMatrice->trie->transition[0];
	for(i = 0; i < alphabet; i++){
		if(l[i] != 0){
			enfiler(l[i]);
			acMatrice->suppleant[l[i]] = 0;
		} 
	}
	
	while(!isEmpty()){
		int r = defiler();
		l = acMatrice->trie->transition[r];
		for(i = 0; i < alphabet; i++){
			if(l[i] != -1){
				enfiler(l[i]);
				suppleant = acMatrice->suppleant[r];
				while(acMatrice->trie->transition[suppleant][i] == -1){
					suppleant = acMatrice->suppleant[suppleant];
				}
				acMatrice->suppleant[l[i]] = acMatrice->trie->transition[suppleant][i];
				acMatrice->trie->finite[l[i]] += acMatrice->trie->finite[acMatrice->suppleant[l[i]]];
			}
		}
	}
}

void ac(char** mots, int nbrMots,unsigned char* text, int textLenght){
	ACMatrice acMatrice = preAC(mots, nbrMots);
	int target = 0, nbrOcc = 0, i;
	for( i = 0; i < textLenght; i++){
		while(acMatrice->trie->transition[target][(int)text[i]] == -1){
			target = acMatrice->suppleant[target];
		}
		target = acMatrice->trie->transition[target][(int) text[i]];
		nbrOcc += acMatrice->trie->finite[target];
	}
	printf("AC-MATRICE - Le nombre d'occurence est : %d\n", nbrOcc);	
}

void affichageSup(ACMatrice acMatrice){
    int i;
    for(i=0;i<maxNode;i++){
		if(acMatrice->suppleant[i] != -1){
			printf("Sup[%d] = %d \n",i,acMatrice->suppleant[i]);
		}
    }
}

int main(int argc, char **argv){	
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
