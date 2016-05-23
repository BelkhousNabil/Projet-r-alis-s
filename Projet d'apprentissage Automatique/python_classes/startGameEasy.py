from Game import *
from Player import *
from Neuron import *

JoueurH = HumanPlayer("human")

JoueurCPU = CPUPlayer("CPU","easy",15)

game = Game(15)

game.start(JoueurH,JoueurCPU,True)