#define alphabet_2   "ab"
#define alphabet_4   "abcd"
#define alphabet_20  "abcdefghijklmnopqrst"
#define alphabet_70  "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$*%@?!=-"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>


int main(int argc, char **argv) {
	
	if(argc >= 5){ 
		int nbrMot = atoi( argv[1] );
		int lgMin = atoi( argv[2] );
		int lgMax = atoi( argv[3] );
		int tailleAlphabet = atoi( argv[4] );
		char* alphabet = (char*) malloc(100* sizeof(char));

		if (nbrMot < 0 ) {
			printf("Nombre de mots doit etre positif\n");
			exit(EXIT_FAILURE);
		}
		else if(nbrMot > 1000){
			printf("Nombre de mots doit être inférieur à 1000\n");
			exit(EXIT_FAILURE);
		}
		
		if (lgMax < lgMin || lgMin < 0) {
			printf("Taile min et max doivent etre >0 et la taille min doit etre < a taille max\n");
			exit(EXIT_FAILURE);
		}
		
		if(lgMax > 255 || lgMin > 255 ){
			printf("Taile min et max doivent etre inférieur à 255\n");
			exit(EXIT_FAILURE);
		}
		
		switch(tailleAlphabet) {
		  case 2: 
			alphabet = alphabet_2;
			break;
		  case 4:
			alphabet = alphabet_4;
			break;
		  case 20:
			alphabet = alphabet_20;
			break;
		  case 70:
			alphabet = alphabet_70;
			break;
		  default :
			printf("La taille donner est invalide, veuillez donner soit: 2, 4, 20 ou 70 comme taille de l'alphabet\n");
			exit(EXIT_FAILURE);
			break;
		}
		
		int i, j;
		for (i = 0; i < nbrMot; i++) {
			int size = lgMin + (lgMax - lgMin + 1) * ((float) rand()) / ((float) RAND_MAX);
			
			for (j = 0; j < size; j++) {
				int aleatoire = tailleAlphabet * ((float) rand()) / ((float) RAND_MAX);
				printf("%c", alphabet[aleatoire]);
			}
			printf("\n");
		}
	}
	else{
		printf("Paramètres : nbrMot longeurMinMot longeurMaxMot taille_alphabet\n");
	}
	return 0;
}

