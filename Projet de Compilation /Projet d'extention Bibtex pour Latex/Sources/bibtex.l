%{ 
	#include <stdio.h>
	#include <stdlib.h>
	#include <string.h>
	
	#include "bibtex.tab.h"

	extern YYSTYPE yylval;

	#include "TS.h"

	int nbligne =0;
	int nbcol = 0;

%}

lettre [a-zA-Z]
mot {lettre}+
chiffre [0-9]
idf {lettre}({lettre}|{chiffre})*

chaine_caract \"[^"\n]*\"

nom_entity {idf}":"{chiffre}+

valeur_champs \{[^\n]*\}

nomFichier {idf}+".bib"

nomFichierTex {idf}+".tex"

blanc [ \t]+

motclef @article|@book|@misc|@manual|@String|@Comment|author|title|journal|year|key|volume|number|page|month|note|publisher|series|address|edition|organization|howpublished

%%

@article {nbcol += yyleng;  	yylval.str = strdup(yytext); return article;} 
@book {nbcol += yyleng;  		yylval.str = strdup(yytext); return book;}
@misc {nbcol += yyleng;  		yylval.str = strdup(yytext); return misc;}
@manual {nbcol += yyleng;  		yylval.str = strdup(yytext); return manual;}
@String {nbcol += yyleng; 		yylval.str = strdup(yytext); return string;}
@Comment {nbcol += yyleng; 		yylval.str = strdup(yytext); return comment;}
author {nbcol += yyleng;  		yylval.str = strdup(yytext); return author;}
title {nbcol += yyleng;  		yylval.str = strdup(yytext); return title;}
journal {nbcol += yyleng;  		yylval.str = strdup(yytext); return journal;}
year {nbcol += yyleng;  		yylval.str = strdup(yytext); return year;}
key {nbcol += yyleng;  			yylval.str = strdup(yytext); return key;}
volume {nbcol += yyleng;  		yylval.str = strdup(yytext); return volume;}
number {nbcol += yyleng;  		yylval.str = strdup(yytext); return number;}
pages {nbcol += yyleng;  		yylval.str = strdup(yytext); return pages;}
month {nbcol += yyleng;  		yylval.str = strdup(yytext); return month;}
note  {nbcol += yyleng;  		yylval.str = strdup(yytext); return note;}
publisher {nbcol += yyleng; 	yylval.str = strdup(yytext); return publisher;}
series {nbcol += yyleng;  		yylval.str = strdup(yytext); return series;}
address {nbcol += yyleng;  		yylval.str = strdup(yytext); return address;}
edition {nbcol += yyleng;  		yylval.str = strdup(yytext); return edition;}
organization {nbcol += yyleng;  yylval.str = strdup(yytext); return organization;}
howpublished {nbcol += yyleng;  yylval.str = strdup(yytext); return howpublished;}

"{" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_acc_ouv;}
"}" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_acc_fer;}
"=" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_egal;}
"," {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_virg;}
"(" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_par_our;}
")" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_par_fer;}
";" {nbcol +=yyleng;   yylval.str = strdup(yytext); return mc_pv;}

"article"	{nbcol +=yyleng;   yylval.str = strdup(yytext); return art;}
"book"	{nbcol +=yyleng;   yylval.str = strdup(yytext); return boo;}
"manual"	{nbcol +=yyleng;   yylval.str = strdup(yytext); return man;}
"misc"	{nbcol +=yyleng;   yylval.str = strdup(yytext); return mis;}

{nomFichier} {nbcol += yyleng;  	yylval.str = strdup(yytext);  return nom_fichier;} 
{nomFichierTex}  {nbcol += yyleng;  	yylval.str = strdup(yytext); return nom_fichierTex;} 
{chaine_caract} {nbcol += yyleng;  	yylval.str = strdup(yytext); return chaine;} 
{nom_entity} {nbcol += yyleng;  	  yylval.str = strdup(yytext);  return nom_entity;} 
{valeur_champs} {nbcol += yyleng;  	yylval.str = strdup(yytext);   return valeur_champs;} 
{mot} {nbcol +=yyleng;   		yylval.str = strdup(yytext); return mot;}

{blanc} {nbcol+=yyleng;}
"\n" {nbcol =0; nbligne++ ;}

. printf("Erreur dans la Ligne %d Colonne %d \n",nbligne,nbcol);
%%
