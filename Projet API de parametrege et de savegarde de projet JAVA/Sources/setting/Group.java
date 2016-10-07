package com.gil.master1.setting;

import java.util.ArrayList;

/**
 * Group - Class that represent Group object
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class Group implements ISetting {
	
	private String key;
	private ArrayList<ISetting> listSettingChild;
	private ISetting settingParent;
	private boolean isKeyOfSetting;
	
	
	/**
	 * Group The default constructor
	 */
	public Group(){
		setIsKeyOfSetting(false);
		listSettingChild = new ArrayList<ISetting>();
		this.key = "";
	}
	
	/**
	 * Group The default constructor
	 * 
	 * @param key The content value of Key
	 */
	public Group(String key){
		this.key = key;
		setIsKeyOfSetting(false);
		listSettingChild = new ArrayList<ISetting>();
	}
	

	/**
	 * getSettingChild Get the setting child instance
	 * 
	 * @return the settingChild
	 */
	public ArrayList<ISetting> getListSettingChild() {
		return listSettingChild;
	}


	/**
	 * setSettingChild Set the value of setting child instance
	 * 
	 * @param settingChild the settingChild to set
	 */
	public void setListSettingChild(ArrayList<ISetting> listSettingChild) {
		this.listSettingChild = listSettingChild;
	}
	
	/**
	 * addSettingChild Add setting element to setting
	 * 
	 * @param setting ISetting element
	 * @return boolean Return true if element is inserted else false
	 */
	public boolean addSettingChild(ISetting setting){
		setting.setSettingParent(this);
		return listSettingChild.add(setting);
	}
	
	/**
	 * removeSettingChild This method remove an ISetting object using there Key
	 * 
	 * @param key key of Isetting to remove
	 * @return boolean Return true if the object is removed else false
	 */
	public boolean removeSettingChild(String key){
		ISetting settingToRemove = null;
		for(ISetting  setting  : listSettingChild){
			if(setting.getKey().equals(key)){
				settingToRemove = setting;
				break;
			}
		}
		
		return listSettingChild.remove(settingToRemove);
	}
	
	/**
	 * getSettingChildByKey Retrive the setting child using Key
	 * 
	 * @param key The key value
	 * @return Return the setting object if exist else null
	 */
	public ISetting getSettingChildByKey(String key){
		for(ISetting st : listSettingChild){
			if(st.getKey().equals(key)){
				return st;
			}
		}
		
		return null;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#getSettingParent()
	 */
	@Override
	public ISetting getSettingParent() {
		return settingParent;
	}


	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#setSettingParent()
	 */
	@Override
	public void setSettingParent(ISetting settingParent) {
		this.settingParent = settingParent;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#getKey()
	 */
	@Override
	public String getKey() {
		// TODO Auto-generated method stub
		return this.key;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#setKey(java.lang.String)
	 */
	@Override
	public void setKey(String key) {
		// TODO Auto-generated method stub
		this.key = key;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#setIsKeyOfSetting(boolean)
	 */
	@Override
	public boolean isKeyOfSetting() {
		// TODO Auto-generated method stub
		return this.isKeyOfSetting;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#isKeyOfSetting()
	 */
	@Override
	public void setIsKeyOfSetting(boolean isKeyOfSetting) {
		// TODO Auto-generated method stub
		this.isKeyOfSetting = isKeyOfSetting;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#toString()
	 */
	@Override
	public String toString() {
		// TODO Auto-generated method stub
		String content = "";
		for(ISetting st : listSettingChild){
			if(st.isKeyOfSetting()){
				content += st.toString() + "\n";
			}
			else{
				content += st.getKey() + "\n";
			}
		}
		
		return content;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#getPath()
	 */
	@Override
	public String getPath() {
		// TODO Auto-generated method stub

		if(getSettingParent() != null){
			return getSettingParent().getPath() + "." + getKey();
		}
		else{
			return getKey() ;
		}
	}
}
