#include <stdio.h>
#include <stdlib.h>
#include <string.h>


// Pour stocker les paramètre d'une entité
typedef struct param param;
struct param
{
	char* name;
	char* value;
    struct param *next;
};
typedef param* paramList;

paramList listParam;

//  Pour stocker les entités
typedef struct entity entity;
struct entity
{
	char* name;
	char* id;
	paramList listParam;
    int existe;
    struct entity *next;
}; 
typedef entity* entityList;

entityList listEntity;


void Initialisation ()
{
   listEntity = NULL;
   listParam = NULL;
}

int countByID(char* id){
	entity *tmp = listEntity;
    int count = 0;
    while(tmp != NULL)
    {
        if(strcmp(tmp->id, id) == 0)
        {
            count++;
        }
        tmp = tmp->next;
    }
    return count;
}

void addEntity(char* name, char* id)
{	
	entity* nouvel = malloc(sizeof(entity));
 
    nouvel->name = name;
    nouvel->id = id;
    nouvel->existe = 1 + countByID(id);
	nouvel->listParam = listParam;
	listParam = NULL;
	nouvel->next = NULL;
	
    if(listEntity == NULL)
    {	
		listEntity = nouvel;
    }
    else
    {	
		entity* temp=listEntity;
        while(temp->next != NULL)
        {
            temp = temp->next;
        }
        temp->next = nouvel;
    }
}



void addParamToCurrentEntity(char* name, char* value)
{	
	param* nouvel = malloc(sizeof(param));
 
    nouvel->name = name;
    nouvel->value = value;
    nouvel->next = NULL;
 
    if(listParam == NULL)
    {	
		listParam = nouvel;
    }
    else
    {
		param* temp = listParam;
        while(temp->next != NULL)
        {
            temp = temp->next;
        }
        temp->next = nouvel;
    }
}

int deleteEntety(entity* _entity ){
	entity* tmp = listEntity;
	
	if(_entity == listEntity){
		if(listEntity -> next != NULL){
			listEntity = listEntity -> next;
		}
		else{
			listEntity = NULL;
		}
		
		free(_entity);
		return 1;
	}
	else{
		while(tmp->next != NULL){
			if(tmp->next == _entity){
				tmp->next = _entity->next;
				free(_entity);
				return 1;
			}
			tmp = tmp->next;
		}
	}
	return 0;
}

void affichageParams(paramList _listParam){
	
	param* tmp1 = _listParam;
	while(tmp1 != NULL)
    {
        printf("|%22s|%22s| \n" , tmp1->name , tmp1->value);			
		tmp1 = tmp1->next;
    }
    printf("|______________________________________________|\n");  
}

void Affichage()
{	
	printf("\n/****** Table des symboles ******/\n");
    printf(" ______________________________________________\n");
    printf("| Nom Entite |   ID               |   Existe   |\n");
    printf("|____________|____________________|____________|\n");
	
	entity *tmp = listEntity;
	while(tmp != NULL)
    {
        printf("|%12s|%20s|%12d| \n" , tmp->name , tmp->id, tmp->existe);			
		printf("|____________|____________________|____________|\n");  
		affichageParams(tmp->listParam);
        tmp = tmp->next;
    }
}



entity* findByID(char* id)
{
    entity *tmp=listEntity;
    
    while(tmp != NULL)
    {
        if(strcmp(tmp->id, id) == 0)
        {
            return tmp;
        }
        tmp = tmp->next;
    }
    return NULL;
}

param* findParamByName(paramList _listParam, char* name){
    param *tmp = _listParam;
    
    while(tmp != NULL)
    {
        if(strcmp(tmp->name, name) == 0)
        {
            return tmp;
        }
        tmp = tmp->next;
    }
    return NULL;
}

void printEntityInFile(entity* _entity, FILE* f){
	param* _param;
	if(_entity != NULL && f != NULL)
    {	
		fprintf(f, "%s{%s,\n", _entity->name,  _entity->id);
		
		_param = _entity->listParam;
		while(_param != NULL)
		{
			fprintf(f, "  %s = %s", _param->name,  _param->value);
			_param = _param->next;
			
			if(_param == NULL){
				fputs( "\n" , f);
			}
			else{
				fputs(",\n", f);
			}
		}
		fputs("}\n\n", f);
    }
}

int listEntityToFile(char* fileName){
	
    FILE* fDest; 
    
    if ((fDest = fopen(fileName, "w+")) == NULL) 
    { 
        fclose(fDest); 
        return 0; 
    } 
    
   	entity *tmp = listEntity;
	
	while(tmp != NULL)
    {	
		printEntityInFile(tmp, fDest);
        tmp = tmp->next;
    }
    
     fclose(fDest); 
     return 1;
}

void showRepetedEntety(){
	entity *tmp = listEntity;
	
	while(tmp != NULL){	
		if(tmp->existe > 1){
			printf("Cette element existe déja : %s\n", tmp->name);
		}
		tmp = tmp->next;
    }
}

void normalize(){
	entity *tmp = listEntity;
	char nbr[100], point[2] = ":";
	while(tmp != NULL){	
		sprintf(nbr, "%d", tmp->existe);
		strcpy(tmp->id, strcat(tmp->id, ":"));
		strcpy(tmp->id, strcat(tmp->id, nbr));
		tmp = tmp->next;
    }
}

int deleteDuplicatedEntety(char* fileName){
	FILE* fDest; 
    
    if ((fDest = fopen(fileName, "w+")) == NULL){ 
        fclose(fDest); 
        return 0; 
    } 
    
	entity *tmp = listEntity;
	entity *tmp2 = tmp;
	while(tmp != NULL){	
		tmp2 = tmp;
		tmp = tmp -> next;
		if(tmp2->existe > 1){
			printEntityInFile(tmp2, fDest);
			deleteEntety(tmp2);
		}
    }
    
    return 1;
}

char* toUpperCase(char* str){
	int counter=0;
	char mychar;
	char * outPut;
	while (str[counter])
	{
		mychar=str[counter];
		putchar (toupper(mychar));
		counter++;
	}
}

int addComments(char* fileName){
	FILE* fDest; 
    
    if ((fDest = fopen(fileName, "w+")) == NULL){ 
        fclose(fDest); 
        return 0; 
    } 
    
	entity *tmp = listEntity;
	while(tmp != NULL){	
		param* _param;
		char val[255];
		if((_param = findParamByName(tmp->listParam, "journal")) != NULL && _param->value != "{}"){
			strcpy(val, strcat(tmp->id, "_journal"));
			fprintf(fDest, "\n@Comment (\"Automatically generated strings for fields of type journal\")\n@String (%s=\"%s\")\n", val, _param->value);
			strcpy(_param->value, val);
		}
		else if((_param = findParamByName(tmp->listParam, "publisher")) != NULL && _param->value != "{}"){
			strcpy(val, strcat(tmp->id, "_publisher"));
			fprintf(fDest, "\n@Comment (\"Automatically generated strings for fields of type publisher\")\n@String (%s=\"%s\")\n", val, _param->value);
			strcpy(_param->value, val);
		}
		else if((_param = findParamByName(tmp->listParam, "series")) != NULL && _param->value != "{}"){
			strcpy(val, strcat(tmp->id, "_series"));
			fprintf(fDest, "\n@Comment (\"Automatically generated strings for fields of type Series\")\n@String (%s=\"%s\")\n",  val, _param->value);
			strcpy(_param->value, val);
		}
		else if((_param = findParamByName(tmp->listParam, "organization")) != NULL && _param->value != "{}"){
			strcpy(val, strcat(tmp->id, "_organization"));
			fprintf(fDest, "\n@Comment (\"Automatically generated strings for fields of type Organization\")\n@String (%s=\"%s\")\n", val, _param->value);
			strcpy(_param->value, val);
		}

		tmp = tmp -> next;
	}
	
    fputs("\n", fDest);
    tmp = listEntity;
    while(tmp != NULL){	
		printEntityInFile(tmp, fDest);
		tmp = tmp -> next;
    }
        
    return 1;
} 

void filtreByType(char* type){
	entity *tmp = listEntity;
	entity *tmp2 = tmp;
	while(tmp != NULL){	
		tmp2 = tmp;
		tmp = tmp -> next;
		if(strcmp(tmp2->name, type) != 0){
			deleteEntety(tmp2);
		}
	}
}
