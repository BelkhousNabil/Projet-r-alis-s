#include <stdio.h>
#include <stdlib.h>
#include "file.h"

void initFile(){
	firstNode = NULL;
}

void enfiler(int target){
	
    node new = malloc(sizeof(node));
    
    if (new == NULL){
        exit(EXIT_FAILURE);
    }

    new->target = target;
    new->next = NULL;

    if (firstNode != NULL){
		node tmp = firstNode;
        while (tmp->next != NULL){
            tmp = tmp->next;
        }
        tmp->next = new;
    }
    else{
        firstNode = new;
    }
}


int defiler(){
    if (firstNode == NULL){
        exit(EXIT_FAILURE);
    }
	
	int target;
	
    if (firstNode != NULL){
        node tmp = firstNode;
        target = tmp->target;
        firstNode = tmp->next;
        free(tmp);
    }

    return target;
}

int isEmpty(){
	if(firstNode == NULL){
		return 1;
	}
	
	return 0;
}

void afficherFile()
{
    if (firstNode == NULL){
        exit(EXIT_FAILURE);
    }

    node tmp = firstNode;

    while (tmp != NULL){
        printf("%d ", tmp->target);
         tmp = tmp->next;
    }
}