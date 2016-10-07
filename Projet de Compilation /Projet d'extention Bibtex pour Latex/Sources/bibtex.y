%{ 
	#include <stdio.h>
	#include <stdlib.h>
	#include <string.h>

	extern nbligne, nbcol;
	extern FILE *yyin;

	char* ch;
%}


%union 
{
   char* str;
}

%token <str>mc_acc_ouv <str>mc_acc_fer <str>mc_pv <str>mc_egal <str>mc_virg <str>mc_par_our <str>mc_par_fer <str>article <str>book <str>misc <str>manual <str>string <str>author <str>title <str><str>journal <str>year <str>key <str>volume <str>number <str>pages <str>month <str>note <str>publisher <str>series <str>address <str>edition <str>organization howpublished <str>nom_fichier <str>nom_fichierTex <str>chaine <str>nom_entity <str>valeur_champs <str>mot <str>comment <str>art <str>boo <str>mis <str>man

%type <str>S
%type <str>ENTITY
%type <str>LIST_COMMENT
%type <str>COMMENT
%type <str>STRING
%type <str>HEADING
%type <str>LIST_ENTITY
%type <str>CHAMPS_OBLIGATOIRES_article
%type <str>CHAMPS_OPTIONNELS_article
%type <str>CHAMPS_OBLIGATOIRES_book
%type <str>CHAMPS_OPTIONNELS_book
%type <str>CHAMPS_OBLIGATOIRES_manual
%type <str>CHAMPS_OPTIONNELS_manual
%type <str>CHAMPS_OPTIONNELS_misc
%type <str>LIST_CHAMPS_article
%type <str>LIST_CHAMPS_book
%type <str>LIST_CHAMPS_manual
%type <str>LIST_CHAMPS_misc

%%

S:	LIST_COMMENT LIST_ENTITY 	{	printf("\nProgramme correct syntaxiquement et sementiquement\n");}		|
	LIST_ENTITY 		  		{	printf("\nProgramme correct syntaxiquement et sementiquement\n");}		
;


COMMENT: 	comment	 	mc_par_our	 chaine 	mc_par_fer
;

STRING:		string 		mc_par_our		mot 	mc_egal 	chaine 		mc_par_fer 
;

LIST_COMMENT:	LIST_COMMENT 	COMMENT 	 STRING	 |
				COMMENT 	STRING 			
;

HEADING: 	nom_entity mc_virg 		{$$ = $1;}
;

ENTITY: 	article mc_acc_ouv	HEADING		LIST_CHAMPS_article		mc_acc_fer	{addEntity($1, $3);}|
			book mc_acc_ouv 	HEADING		LIST_CHAMPS_book		mc_acc_fer	{addEntity($1, $3);}|
			manual mc_acc_ouv 	HEADING		LIST_CHAMPS_manual		mc_acc_fer	{addEntity($1, $3);}|
			misc mc_acc_ouv 	HEADING		LIST_CHAMPS_misc		mc_acc_fer	{addEntity($1, $3);}
;

LIST_ENTITY:	LIST_ENTITY		ENTITY																|
				ENTITY
;

CHAMPS_OBLIGATOIRES_article:	author mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								title mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								journal mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								year mc_egal valeur_champs 				{addParamToCurrentEntity($1, $3);}	
;


CHAMPS_OPTIONNELS_article:		volume 	mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}	|
								number mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}	|
								pages mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}	|
								month mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}	|
								note mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}	|
								key mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}	|
;

CHAMPS_OBLIGATOIRES_book:		author 	mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}						|
								title mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}						|
								publisher mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}						|
								year mc_egal valeur_champs          {addParamToCurrentEntity($1, $3);}	
;

CHAMPS_OPTIONNELS_book:			volume 	mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								series mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								address mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								edition mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								note mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								key mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								month mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
;

CHAMPS_OBLIGATOIRES_manual:		title mc_egal valeur_champs {addParamToCurrentEntity($1, $3);}
;

CHAMPS_OPTIONNELS_manual:		author 	mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}						|
								organization mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}						|
								address mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}						|
								edition mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}						|
								note mc_egal valeur_champs 				{addParamToCurrentEntity($1, $3);}						|
								key mc_egal valeur_champs 				{addParamToCurrentEntity($1, $3);}						|
								month mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}						|
								year mc_egal valeur_champs 				{addParamToCurrentEntity($1, $3);}						|
;

CHAMPS_OPTIONNELS_misc:			author 	mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								title mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								howpublished mc_egal valeur_champs 	{addParamToCurrentEntity($1, $3);}							|
								note mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
								key mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|	
								month mc_egal valeur_champs 		{addParamToCurrentEntity($1, $3);}							|
								year mc_egal valeur_champs 			{addParamToCurrentEntity($1, $3);}							|
;

LIST_CHAMPS_article :		LIST_CHAMPS_article		mc_virg		CHAMPS_OBLIGATOIRES_article										|
					 		LIST_CHAMPS_article		mc_virg		CHAMPS_OPTIONNELS_article										|
							CHAMPS_OBLIGATOIRES_article																			|
							CHAMPS_OPTIONNELS_article											
;

LIST_CHAMPS_book: 		LIST_CHAMPS_book	mc_virg		CHAMPS_OBLIGATOIRES_book 	 											|
						LIST_CHAMPS_book	mc_virg		CHAMPS_OPTIONNELS_book 													|
						CHAMPS_OBLIGATOIRES_book																				|
						CHAMPS_OPTIONNELS_book										
;

LIST_CHAMPS_manual:			LIST_CHAMPS_manual		mc_virg		CHAMPS_OBLIGATOIRES_manual										|
							LIST_CHAMPS_manual		mc_virg		CHAMPS_OPTIONNELS_manual										|
							CHAMPS_OBLIGATOIRES_manual																			|
							CHAMPS_OPTIONNELS_manual
;

LIST_CHAMPS_misc : 			LIST_CHAMPS_misc	mc_virg		CHAMPS_OPTIONNELS_misc												|
							CHAMPS_OPTIONNELS_misc 
;

%%
int yyerror(char* msg )
{
	printf ("erreur sytexique nbligne=%d ,  nbcol=%d",nbligne,nbcol);
	return 1;
}

int main(int argc, char **argv)
{

	Initialisation();
	
	// 	fichier bibtex 	
	char* fileName = "bibtex2.bib";
	yyin=fopen(fileName, "r");

	printf("\n ***** Debut du programme ***** \n\n");
	yyparse();
	printf("\n ***** Fin parse ***** \n\n");
	int opt;int i = 0;
	while ((opt = getopt (argc, argv, "ckust")) != -1){
		switch (opt){
			case 'c':
				showRepetedEntety();
				break;
			case 'k':
				normalize();
				listEntityToFile(fileName);
				break;
			case 'u':
				deleteDuplicatedEntety("bibtex.bib.doublons");
				listEntityToFile(fileName);
				break;
			case 's':
				addComments("bibtexComment.bib");
				break;
			case 't':
				if( argv[2] != NULL ){
					if((strcmp(argv[2], "article") == 0 || strcmp(argv[2], "book") == 0)
						|| (strcmp(argv[2], "manual") == 0 || strcmp(argv[2], "misc") == 0)){
						char str[2] = "@";
						filtreByType(strcat(str, argv[2]));
						listEntityToFile("bibtex_select_type.bib");
					}
				}
				break;
			default:
				printf("no parametres\n");
		}
	}
		
	printf(" \n Le nombre de ligne est : %d \n", nbligne);

}
