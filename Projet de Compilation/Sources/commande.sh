#!/bin/bash

flex bibtex.l
bison -d bibtex.y
gcc lex.yy.c bibtex.tab.c -ly -lfl -o mybib
rm bibtex.tab.h bibtex.tab.c lex.yy.o lex.yy.h lex.yy.c
