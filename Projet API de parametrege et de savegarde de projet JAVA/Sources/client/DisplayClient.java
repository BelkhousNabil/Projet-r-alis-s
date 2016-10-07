package com.gil.master1.client;

import java.io.File;

import com.gil.master1.setting.DisplayVisitor;
import com.gil.master1.setting.ISettingHandler;
import com.gil.master1.setting.LoadVisitor;
import com.gil.master1.setting.SettingTree;

/**
 * DisplayClient This class represent display client
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class DisplayClient {

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
				
				
				DisplayVisitor displayVisitor = new DisplayVisitor();
				settingTree.accepte(displayVisitor);
				String content = displayVisitor.getSettingToDisplay();
				System.out.println(content);
			}
			else{
				System.out.println("Veuillez vérifier le chemin de votre fichier");
			}
		}
		else{
			System.out.println("Vous devez entrer le nom de fichier en paramètre");
		}
	}

}
