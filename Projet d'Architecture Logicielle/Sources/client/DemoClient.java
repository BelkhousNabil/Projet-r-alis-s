package com.gil.master1.client;

import com.gil.master1.setting.DisplayVisitor;
import com.gil.master1.setting.ISettingHandler;
import com.gil.master1.setting.SettingTree;

/**
 * DemoClient This class represent the Demo client
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class DemoClient {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		ISettingHandler settingTree = new SettingTree();
		settingTree.addSetting("calcul.group1", "");
		settingTree.addSetting("calcul.group1.group2", "");
		settingTree.addSetting("calcul.group1.group2.val1", "22");
		settingTree.addSetting("calcul.group1.group2.val2", "rien");
		settingTree.addSetting("calcul.group1.group2.val3", "16.5");
		settingTree.accessTo("calcul.group1");
		settingTree.addSetting("group4", "");
		settingTree.addSetting("group4.val5", "99");
		settingTree.returnBack();
		settingTree.addSetting("testText", "text");
		settingTree.returnBack();
		settingTree.returnBack();
		settingTree.addSetting("testText2", "text2");
		settingTree.removeSetting("calcul.group1.group2.val1");
		
		DisplayVisitor displayVisitor = new DisplayVisitor();
		settingTree.accepte(displayVisitor);
		String content = displayVisitor.getSettingToDisplay();
		System.out.println(content);
	}

}
