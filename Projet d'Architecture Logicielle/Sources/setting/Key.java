package com.gil.master1.setting;

/**
 * Key Class that represent the instance of setting key
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class Key implements ISetting {
	
	private String key;
	private ValueType value;
	private boolean isKeyOfSetting;
	private ISetting settingParent;
	
	/**
	 * Key The default constructor of Key class
	 * 
	 * @param key the content value of key setting
	 * @param value the value associate with key setting
	 */
	public Key(String key, ValueType value) {
		this.key = key;
		this.value = value;
		setIsKeyOfSetting(true);
	}
	
	/**
	 * @return the value
	 */
	public ValueType getValue() {
		return value;
	}

	/**
	 * @param value the value to set
	 */
	public void setValue(ValueType value) {
		this.value = value;
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
	public void setIsKeyOfSetting(boolean isKeyOfSetting) {
		// TODO Auto-generated method stub
		this.isKeyOfSetting = isKeyOfSetting;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#isKeyOfSetting()
	 */
	@Override
	public boolean isKeyOfSetting() {
		// TODO Auto-generated method stub
		return isKeyOfSetting;
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
	 * @see com.gil.master1.setting.ISetting#toString()
	 */
	@Override
	public String toString() {
		// TODO Auto-generated method stub
		return getKey() + " = " + getValue().diplayWithType();
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISetting#getPath()
	 */
	@Override
	public String getPath() {
		// TODO Auto-generated method stub
		
		if(getSettingParent() != null){
			return getSettingParent().getPath() + "." + getKey() ;
		}
		else{
			return getKey();
		}
	}
}
