package com.gil.master1.setting;

/**
 * Interface that content the common setting methods  
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public interface ISetting {

	/**
	 * getKey - Return the key of setting
	 * 
	 * @return String the key
	 */
	public String getKey();
	
	/**
	 * setKey - Set the key value of setting
	 * 
	 * @param key the content of key
	 */
	public void setKey(String key);
	
	/**
	 * setIsKeyOfSetting - Set true if the object is key and false if is a goup 
	 * 
	 * @param isKeyOfSetting The boolean value
	 */
	public void setIsKeyOfSetting(boolean isKeyOfSetting); 
	
	/**
	 * isKeyOfSetting - This method return true if the instance is key of setting 
	 * or false if is a key of group
	 * 
	 * @return boolean True or False
	 */
	public boolean isKeyOfSetting();
	
	/**
	 * getSettingParent Get the parent of this instant
	 * 
	 * @return the settingParent
	 */
	public ISetting getSettingParent();
	
	/**
	 * setSettingParent Set the parent of this instance
	 * 
	 * @param settingParent the settingParent to set
	 */
	public void setSettingParent(ISetting settingParent);
	
	/**
	 * toString Return the content of setting according to the type
	 * 
	 * @return String return String content
	 */
	public String toString();
	
	/**
	 * getPath Return path for this setting relative to the root setting parent
	 * 
	 * @return String return String that contain path
	 */
	public String getPath();
}
