import random
from Neuron import *

class Player:
    #constructeur de la classe Player
    def __init__(self,name):
        self.name = name
        self.nbWin = 0

    #Getter du nom du joueur
    def getName(self):
        return self.name

    #Getter du nombre de victoire
    def getNbWin(self):
        return self.nbWin

    #Ajouter une victoire
    def addWin(self):
        self.nbWin+=1

    #Ajouter une defaite
    def addLoss(self):
        pass

#Classe HumainPlayer qui hérite de la classe Player
class HumanPlayer(Player):
    #Fonction qui permet de jouer une partie et de vérifier le nombre de baton pris
    def play(self,sticks):
        if sticks==1: return 1
        else:
            correct = False
            while not correct:
                nb = input('Sticks?\n')
                try:
                    nb=int(nb)
                    if nb>=1 and nb<=3 and sticks-nb>=0:
                        correct=True
                except: pass
            return nb

#classe CPUPlayer qui hérite de la classe Player
class CPUPlayer(Player):
    
    #Constructeur par defaut de la classe
    def __init__(self,name,mode,nbSticks):
        super().__init__(name)
        self.mode = mode
        self.netw = NeuronNetwork(3,nbSticks)
        self.previousNeuron = None

    #fonction qui permet de choisir le niveau du CPU en fonction du mode
    def play(self,sticks):
        if self.mode=='easy': return self.playEasy(sticks)
        elif self.mode=='hard': return self.playHard(sticks)
        else: return self.playMedium(sticks)

    #fonction qui permet de jouer en mode medium
    def playMedium(self,sticks):
        # TODO compléter ici avec les quelques conditions pour éviter de faire une grosse erreur aux derniers tours

        if sticks <= 4 and sticks > 1 : return sticks-1
        return self.playRandom(sticks)

    #fonction qui permet de jouer en mode easy
    def playEasy(self,sticks):
        return self.playRandom(sticks)

    #fonction qui permet de choisir aléatoirement le nombre de baton 1,2 ou 3
    def playRandom(self,sticks):
        if sticks < 4 : return random.randint(1, sticks)
        else : return random.randint (1, 3)

    #fonction qui permet de jouer en mode Hard
    def playHard(self,sticks):
        # TODO utiliser le réseau neuronal pour choisir le nombre de bâtons à jouer
        # utiliser l'attribut self.previousNeuron pour avoir le neuron précédemment sollicité dans la partie
        # calculer un 'shift' qui correspond à la différence entre la valeur du précédent neurone et le nombre de bâtons encore en jeu
        # utiliser la méthode 'chooseConnectedNeuron' du self.previousNeuron puis retourner le nombre de bâtons à jouer
        # bien activer le réseau de neurones avec la méthode 'activateNeuronPath' après avoir choisi un neurone cible
        # attention à gérer les cas particuliers (premier tour ou sticks==1)
        if sticks == 1 :
            return 1
        if self.previousNeuron == None :
            self.previousNeuron = self.netw.getNeuron(sticks)
            shift = 0
        else : 
            shift = self.previousNeuron.index - sticks
        choosenNeuron = self.previousNeuron.chooseConnectedNeuron(shift)
        nb = sticks - choosenNeuron.index
        self.netw.activateNeuronPath(self.previousNeuron, choosenNeuron)
        self.previousNeuron = choosenNeuron
        return nb

    #Getter du réseau de neurones
    def getNeuronNetwork(self): return self.netw

    #Ajouter une victoire pour le CPU
    def addWin(self):
        super().addWin()
        self.netw.recompenseConnections()
        self.previousNeuron=None

    #Ajouter une defairte pour le CPU
    def addLoss(self):
        super().addLoss()
        self.previousNeuron=None




        


