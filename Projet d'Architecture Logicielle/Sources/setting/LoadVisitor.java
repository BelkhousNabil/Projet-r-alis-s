/**
 * 
 */
package com.gil.master1.setting;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

/**
 * LoadVisitor class for loading setting from file
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 03/01/2015
 */
public class LoadVisitor implements ISettingVisitor {

	private File fileSetting; 
	
	/**
	 * LoadVisitor Default constructor 
	 */
	public LoadVisitor(){
		
	}
	
	/**
	 * LoadVisitor Default constructor 
	 * 
	 * @param fileSetting File of settings
	 */
	public LoadVisitor(File fileSetting){
		this.fileSetting = fileSetting;
	}
	
	
	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ISettingVisitor#visiteSettingTree(com.gil.master1.setting.SettingTree)
	 */
	@Override
	public void visiteSettingTree(SettingTree settingTree) {
		// TODO Auto-generated method stub
		BufferedReader br = null;

		try {

			String sCurrentLine;

			br = new BufferedReader(new FileReader(fileSetting));

			while ((sCurrentLine = br.readLine()) != null) {
				String keys = sCurrentLine.trim();
				ValueType value = null;

				if(sCurrentLine.contains("=")){
					keys = sCurrentLine.substring(0,sCurrentLine.indexOf("=")).trim();
					String val = sCurrentLine.substring(sCurrentLine.indexOf("=") + 1).trim();
					try{
						if(Integer.valueOf(val) != null){
							value = new IntegerType(Integer.valueOf(val));
							settingTree.addSetting(keys, value);
							continue;
						}
					}catch(Exception e){}
					
					try{
						if(Float.valueOf(val) != null){
							value = new FloatType(Float.valueOf(val));
							settingTree.addSetting(keys, value);
							continue;
						}
					}catch(Exception e){}
					
					value = new StringType(val);
					settingTree.addSetting(keys, value);
				}
				else{
					settingTree.addSetting(keys, value);
				}
			}

		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			try {
				if (br != null)br.close();
			} catch (IOException ex) {
				ex.printStackTrace();
			}
		}
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
