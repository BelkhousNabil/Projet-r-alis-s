package com.gil.master1.client;

import java.io.File;
import java.util.Scanner;

import com.gil.master1.setting.DisplayVisitor;
import com.gil.master1.setting.ISetting;
import com.gil.master1.setting.ISettingHandler;
import com.gil.master1.setting.LoadVisitor;
import com.gil.master1.setting.SaveVisitor;
import com.gil.master1.setting.SettingTree;

/**
 * EditClient This class represent edit client that allow navigation, add, remove, save setting
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class EditClient {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		if(args.length > 0){
			String path = args[0];
			File fileSetting = new File(path);
			if(fileSetting.exists() && fileSetting.isFile()){
				ISettingHandler settingTree = new SettingTree();
				LoadVisitor loadVisitor = new LoadVisitor(fileSetting);
				settingTree.accepte(loadVisitor);

				Scanner keyword = new Scanner(System.in);
				String command = "";
				printHelpCommand();
				System.out.println("/" + settingTree.getCurrentSetting().getPath() + " :");
				while(!(command = keyword.nextLine().trim()).equals("exit")){
					if(command.equals("help")){
						printHelpCommand();
					}
					else if(command.equals("display")){
						System.out.println(settingTree.getCurrentSetting());
					}
					else if(command.startsWith("access")){
						String keys = command.replaceFirst("access", "");
						settingTree.accessTo(keys);
					}
					else if(command.equals("back")){
						settingTree.returnBack();
					}
					else if(command.startsWith("save")){
						String pathSave = command.replaceFirst("save", "").trim();
						File fileSave = new File(pathSave);
						SaveVisitor saveVisitor = new SaveVisitor(fileSave);
						settingTree.accepte(saveVisitor);
					}
					else  if(command.startsWith("add")){
						String str, keys =  str = command.replaceFirst("add", "").trim();
						String val = "";
						if(str.contains("=")){
							keys = str.substring(0,str.indexOf("=")).trim();
							val = str.substring(str.indexOf("=") + 1).trim();
						}
						
						if(settingTree.addSetting(keys, val)){
							System.out.println("Le reglage à bien été ajouté");
						}
						else{
							System.out.println("Vous ne pouvez pas ajouter ce reglage");
						}
					}
					else  if(command.startsWith("remove")){
						String keys = command.replaceFirst("remove", "");
						if(settingTree.removeSetting(keys)){
							System.out.println("Le reglage à bien été supprimé");
						}
						else{
							System.out.println("Vous ne pouvez pas supprimer ce reglage");
						}
					}
					
					System.out.println("/" + settingTree.getCurrentSetting().getPath() + " :");
				}
				System.out.println("Vous avez quitté le programme");
			}
			else{
				System.out.println("Veuillez vérifier le chemin de votre fichier");
			}
		}
		else{
			System.out.println("Vous devez entrer le nom de fichier en paramètre");
		}
	}
	
	public static void printHelpCommand(){
		System.out.println("---------------------------------------------------------------");
		System.out.println("exit -> pour quitter le programme");
		System.out.println("help -> pour afficher la liste des commandes");
		System.out.println("display -> pour afficher le contenu du reglage");
		System.out.println("access keys -> pour accéder à un reglage en utilisant une clef, cette clef pouvent etre une concatination de plusieur clef");
		System.out.println("back -> pour revenir en arrière");
		System.out.println("add setting -> pour ajouter un réglage de manière relative");
		System.out.println("remove setting -> pour ajouter un réglage de manière relative");
		System.out.println("save path -> sauvgarder les reglages dans un fichier");
		System.out.println("---------------------------------------------------------------");
	}
}
