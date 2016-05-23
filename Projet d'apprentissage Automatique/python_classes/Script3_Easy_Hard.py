from Game import *
from Player import *
from Neuron import *

JoueurCPU1 = CPUPlayer("CPU","easy",15)

JoueurCPU2 = CPUPlayer("CPU","hard",15)

game = Game(15)

for i in range(50) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')

game = Game(15)
for i in range(100) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')

game = Game(15)
for i in range(200) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')

game = Game(15)
for i in range(300) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')

game = Game(15)
for i in range(1000) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')

game = Game(15)
for i in range(3000) :
    game.start(JoueurCPU1,JoueurCPU2,False)
print(JoueurCPU1.getNbWin())
print(JoueurCPU2.getNbWin())
print('*****************************************')
