package com.gil.master1.setting;

/**
 * SettingVisitor Interface for visiting ISettingHandler
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public interface ISettingVisitor {
	
	/**
	 * visiteSettingTree this method set the visitor of SettingTree type
	 * 
	 * @param settingTree object of setting 
	 */
	public void visiteSettingTree(SettingTree settingTree); 

}
