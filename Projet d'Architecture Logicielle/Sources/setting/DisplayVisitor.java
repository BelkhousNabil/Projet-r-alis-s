/**
 * 
 */
package com.gil.master1.setting;

/**
 * DisplayVisitor class for displaying Setting Tree
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class DisplayVisitor implements ISettingVisitor {
	
	private String settingToDisplay;
	
	/**
	 * getSettingToDisplay get string who contain the display content of setting tree
	 * 
	 * @return the settingToDisplay
	 */
	public String getSettingToDisplay() {
		return settingToDisplay;
	}

	/**
	 * setSettingToDisplay Set the display content of Setting tree
	 * @param settingToDisplay the settingToDisplay to set
	 */
	public void setSettingToDisplay(String settingToDisplay) {
		this.settingToDisplay = settingToDisplay;
	}
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingVisitor#visiteSettingTree(com.gil.master1.setting.SettingTree)
	 */
	@Override
	public void visiteSettingTree(SettingTree settingTree) {
		// TODO Auto-generated method stub
		String content = settingTreeToStringWithTabulation(settingTree.getRootSetting(), -1);
		if(content.startsWith("\n")){
			content = content.replaceFirst("\n", "");
		}
		setSettingToDisplay(content);
	}
	
	/**
	 * settingTreeToStringWithTabulation Convert setting tree to String using tabulation
	 * 
	 * @param setting The setting node
	 * @return String return the content
	 */
	private String settingTreeToStringWithTabulation(ISetting setting, int tabNbr){
		String content = "";
		String tab = "";
		for(int i = 1; i <= tabNbr; i++){
			tab += "\t";
		}
			
		if(setting.isKeyOfSetting()){
			return tab + setting.getKey() + " = " + ((Key)setting).getValue().diplayWithType() + "\n";
		}
		else if(((Group)setting).getListSettingChild().isEmpty()){
			return tab + setting.getKey() + "\n";
		}
		else{
			content += tab + ((Group)setting).getKey() + "\n";
			for(ISetting settingChild : ((Group)setting).getListSettingChild()){
				content += settingTreeToStringWithTabulation(settingChild, tabNbr + 1);
			}
		}
		
		return content;
	}
	
}
