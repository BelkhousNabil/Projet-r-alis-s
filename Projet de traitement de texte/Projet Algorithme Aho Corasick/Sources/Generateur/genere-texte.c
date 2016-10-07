#define alphabet_2   "ab"
#define alphabet_4   "abcd"
#define alphabet_20  "abcdefghijklmnopqrst"
#define alphabet_70  "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$*%@?!=-"

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

int main(int argc, char **argv) {

	if(argc >= 3){ 
		int tailleText = atoi( argv[1] );
		int tailleAlphabet =  atoi( argv[2] );
		
		if (tailleText < 5000000 ) {
			printf("La taille du texte doit être inférieur à 5000000\n");
			exit(EXIT_FAILURE);
		}
		
		char* alphabet = (char*) malloc(100* sizeof(char));
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
		int i;
		for (i = 0; i < tailleText; i++) {
			int aleatoire = tailleAlphabet * ((float) rand()) / ((float) RAND_MAX);
			printf("%c", alphabet[aleatoire]);
		}
		
	}
	else{
		printf("Paramètres : taille_texte taille_alphabet(2, 4, 20, 70)\n");
	}
	return 0;
}
