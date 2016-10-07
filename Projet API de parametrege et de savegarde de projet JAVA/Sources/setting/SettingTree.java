package com.gil.master1.setting;

/**
 * SettingsTree Class that contain the list of setting and there methods
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class SettingTree implements ISettingHandler{
	
	private Group root;
	private ISetting cursor;
	
	/**
	 * SettingsTree Default constructor 
	 */
	public SettingTree(){
		this.root = new Group();
		this.cursor = root; 
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#accepte(com.gil.master1.setting.SettingVisitor)
	 */
	@Override
	public void  accepte(ISettingVisitor settingVisitor){
		settingVisitor.visiteSettingTree(this);
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#getSettingByKeys(com.gil.master1.setting.ISetting, java.lang.String)
	 */
	@Override
	public ISetting getSettingByKeys(ISetting cursor, String keys){
		keys = keys.trim();
		if(!keys.equals("")){
			if(cursor.isKeyOfSetting()){
				return null;
			}
			
			if(!keys.contains(".")){
				for(ISetting st : ((Group)cursor).getListSettingChild()){
					if(st.getKey().equals(keys)){
						return st;
					}
				}
			}
			else{
				String[] keyTab = keys.split("\\."); 
				Group tmpCursur = ((Group)cursor);
				ISetting tmp;
				int index = 0, lastIndex = keyTab.length -1;
				for(String key : keyTab){
					tmp = tmpCursur.getSettingChildByKey(key);
					if(tmp == null){ 
						return null;
					}
					else if(index == lastIndex){
						return tmp;
					}
					else if(!tmp.isKeyOfSetting()){
						tmpCursur = (Group)tmp;
					}
					else{
						return null;
					}
					index++;
				}
				
				return null;
			}
		}
		
		return null;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#addSetting(java.lang.String, com.gil.master1.setting.ValueType)
	 */
	@Override
	public boolean addSetting(String keys, String val){
		val = val.trim();
		ValueType value = null;
		if(!val.equals("")){
			try{
				if(Integer.valueOf(val) != null){
					value = new IntegerType(Integer.valueOf(val));
					return addSetting(keys, value);
				}
			}catch(Exception e){}
			
			try{
				if(Float.valueOf(val) != null){
					value = new FloatType(Float.valueOf(val));
					return addSetting(keys, value);
				}
			}catch(Exception e){}
			
			value = new StringType(val); 
			return addSetting(keys, value);
		}
		
		return addSetting(keys, value);
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#addSetting(java.lang.String, com.gil.master1.setting.ValueType)
	 */
	@Override
	public boolean addSetting(String keys, ValueType value){
		keys = keys.trim();
		if(!keys.equals("")){
			String[] groupTab = keys.contains(".") ? keys.split("\\.") :  new String[]{keys}; 
			ISetting settingGroupCursor = cursor;
			int index = 0, lastIndex = groupTab.length -1;
			for(String gr : groupTab){
				ISetting st = getSettingByKeys((Group)settingGroupCursor, gr);
				if(st != null){
					if(st.isKeyOfSetting()){
						if(index == lastIndex && value != null){
							((Key)st).setValue(value);
							return true;
						}
						return false;
					}
					else if(!st.isKeyOfSetting()){
						if(index == lastIndex && value != null){
							return false; // on peut pas attribuer un valeur à un groupe 
						}
						else{
							settingGroupCursor = st;
						}
					}
				}
				else{
					if(index == lastIndex){
						if(value != null){
							return ((Group)settingGroupCursor).addSettingChild(new Key(gr, value));
						}
						else{
							return ((Group)settingGroupCursor).addSettingChild(new Group(gr));
						}
					}
					else{
						Group tmp = new Group(gr);
						((Group)settingGroupCursor).addSettingChild(tmp);
						settingGroupCursor = tmp;
					}
				}
				index++;
			}
		}
		return false;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#removeSetting(java.lang.String)
	 */
	@Override
	public boolean removeSetting(String keys){
		keys = keys.trim();
		if(cursor.isKeyOfSetting()){
			return false;
		}
		
		if(!keys.contains(".")){
			return ((Group)cursor).removeSettingChild(keys);
		}
		else{
			String lastKeyToRemove = keys.substring(keys.lastIndexOf(".") + 1, keys.length());
			String parentsKey = keys.substring(0, keys.lastIndexOf("."));
			ISetting group = getSettingByKeys(cursor, parentsKey);
			if(group != null && !group.isKeyOfSetting()){
				return ((Group)group).removeSettingChild(lastKeyToRemove);
			}
		}
		
		return false;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#accessTo(java.lang.String)
	 */
	@Override
	public ISetting accessTo(String keys){
		keys = keys.trim();
		ISetting settingIndex;
		ISetting tmpCursor = cursor;

		if((settingIndex = getSettingByKeys(cursor, keys)) != null){
			return cursor =  settingIndex;
		}
		else{
			String[] keysTab = keys.contains(".") ? keys.split("\\.") :  new String[]{keys};
			String settingParent = keysTab[0];
			while(tmpCursor.getSettingParent() != null && (tmpCursor = tmpCursor.getSettingParent()) != root){
				if(tmpCursor.getKey().equals(settingParent)){
					if(tmpCursor != root){
						tmpCursor = tmpCursor.getSettingParent();
					}
					break;
				}
			}
					
			settingIndex = getSettingByKeys(tmpCursor, keys);
			if(settingIndex == null){
				return null;
			}
			else{
				return cursor = settingIndex;
			}
		}
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingHandler#returnBack()
	 */
	@Override
	public ISetting returnBack(){
		if(cursor != root){
			return cursor = (Group) cursor.getSettingParent();
		}
		return cursor;
	}
	
	/**
	 * getRootSetting Return reference to the root setting element 
	 * 
	 * @return ISetting
	 */
	public ISetting getRootSetting(){
		return root;
	}

	@Override
	public ISetting getCurrentSetting() {
		// TODO Auto-generated method stub
		return cursor;
	}
	
}
