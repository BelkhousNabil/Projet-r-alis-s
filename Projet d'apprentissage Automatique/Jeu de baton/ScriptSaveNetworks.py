# -*- coding: utf-8 -*-

from Game import *
from Player import *
from Neuron import *
import pickle

JoueurCPU1 = CPUPlayer("CPU","hard",15)

JoueurCPU2 = CPUPlayer("CPU","hard",15)

game = Game(15)

for i in range(10000) :
    game.start(JoueurCPU1, JoueurCPU2, False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
JoueurCPU1.getNeuronNetwork().printAllConnections()
JoueurCPU2.getNeuronNetwork().printAllConnections()
with open('SerializedNetwork', 'wb') as output : pickle.dump(JoueurCPU1.getNeuronNetwork(), output, pickle.HIGHEST_PROTOCOL)
