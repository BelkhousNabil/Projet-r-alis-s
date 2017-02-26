# -*- coding: utf-8 -*-
from Game import *
from Player import *
from Neuron import *
import pickle

name = input(" Donner votre nom : ")

mode = input("Donner le niveau de difficulté : easy, medium ou hard ? ")

start = input("Voulez vous commencer à jouer en premier : (oui/non)? ")

cpu = CPUPlayer("CPU", mode, 15)
humain = HumanPlayer(name)

game = Game(15)

if mode == 'hard' :
    with open('SerializedNetwork', 'rb') as inp : ns = pickle.load(inp)
    cpu.netw = ns

if start == 'oui' :     
    game.start(humain,cpu , True)
else :
    game.start(cpu,humain , True)
