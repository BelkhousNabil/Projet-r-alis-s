package com.gil.master1.setting;

/**
 * ISettingHandler Interface that contain the main methods of settings handler according to the setting structure
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public interface ISettingHandler {
	
	/**
	 * accepte Method to accept visitor
	 * 
	 * @param settingVisitor Visitor object
	 */
	public void  accepte(ISettingVisitor settingVisitor);
	
	/**
	 * getSettingByKeys Return reference to a setting using keys
	 * this keys can be a concatenation of many other keys  
	 *
	 * @param cursor The setting parent that contain the keys as childs
	 * @param keys The String keys
	 * @return ISetting return reference to the setting if existing else null
	 */
	public ISetting getSettingByKeys(ISetting cursor, String keys);
	
	/**
	 * addSetting This method allow to add new keys and value (String) to the setting structure
	 * 
	 * @param keys  The String keys
	 * @param value String value
	 * @return boolean Return true if the keys is inserted else false
	 */
	public boolean addSetting(String keys, String value);
	
	/**
	 * addSetting This method allow to add new keys and value to the setting structure
	 * 
	 * @param keys  The String keys
	 * @param value The value of keys (this value can be null in order to add groups keys)
	 * @return boolean Return true if the keys is inserted else false
	 */
	public boolean addSetting(String keys, ValueType value);
	
	/**
	 * removeSetting Remove setting using Keys  
	 * 
	 * @param keys  The string keys
	 * @return boolean Return true if the keys is removed else false
	 */
	public boolean removeSetting(String keys);
	
	/**
	 * accessTo This method give reference to an key if it exists
	 * 
	 * @param keys The string keys to refer
	 * @return ISetting Return ISetting reference
	 */
	public ISetting accessTo(String keys);
	
	/**
	 * returnBack Return back to the parent of current cursor
	 * 
	 * @return ISetting Return ISetting reference
	 */
	public ISetting returnBack();
	
	/**
	 * getCurrentSetting Return the current setting
	 * 
	 * @return ISetting
	 */
	public ISetting getCurrentSetting();
}
