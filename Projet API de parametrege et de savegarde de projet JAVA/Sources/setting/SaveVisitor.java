/**
 * 
 */
package com.gil.master1.setting;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

/**
 * SaveVisitor class for saving setting in file
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class SaveVisitor implements ISettingVisitor {
	

	private File fileSetting; 

	/**
	 * SaveVisitor Default constructor
	 * 
	 * @param fileSetting File where saving setting
	 */
	public SaveVisitor(File fileSetting) {
		this.fileSetting = fileSetting;
	}



	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingVisitor#visiteSettingTree(com.gil.master1.setting.SettingTree)
	 */
	@Override
	public void visiteSettingTree(SettingTree settingTree) {
		// TODO Auto-generated method stub
		try {
			
			if (!fileSetting.exists()) {
				fileSetting.createNewFile();
			}
			
			FileWriter fw = new FileWriter(fileSetting.getAbsoluteFile());
			BufferedWriter bw = new BufferedWriter(fw);
			Group rootSetting = (Group)settingTree.getRootSetting();
			String content = settingTreeToString(rootSetting, "");
			bw.write(content);
			bw.close();
			System.out.println("Vous avez bien sauvgardé le fichier bsahtek");
		} catch (IOException e) {
			e.printStackTrace();
			System.out.println("Une erreur s'est produite lors de sauvgarde du fichier");
		}
	}
	
	/**
	 * settingTreeToString Convert setting tree to String
	 * 
	 * @param setting The setting node
	 * @return String return the content
	 */
	private String settingTreeToString(ISetting setting, String line){
		String content = "";
		if(setting.isKeyOfSetting()){
			return line + setting.getKey() + " = " + ((Key)setting).getValue().display() + "\n";
		}
		else if(((Group)setting).getListSettingChild().isEmpty()){
			return line + setting.getKey() + "\n";
		}
		else{
			line += (((Group)setting).getKey().equals("")) ? "" : ((Group)setting).getKey() + ".";
			for(ISetting settingChild : ((Group)setting).getListSettingChild()){
				content += settingTreeToString(settingChild, line);
			}
		}
		
		return content;
	}
	
	/**
	 * getFileSetting get file of Setting
	 * 
	 * @return the fileSetting
	 */
	public File getFileSetting() {
		return fileSetting;
	}

	/**
	 * setFileSetting Set the value of file setting
	 * 
	 * @param fileSetting the fileSetting to set
	 */
	public void setFileSetting(File fileSetting) {
		this.fileSetting = fileSetting;
	}

}
