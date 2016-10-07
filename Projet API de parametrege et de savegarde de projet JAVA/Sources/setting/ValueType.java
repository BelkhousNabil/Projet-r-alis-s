/**
 * 
 */
package com.gil.master1.setting;

/**
 * ValueType Interface of setting key value type
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public interface ValueType {
	
	/**
	 * getValue This method return the value according to object type
	 * 
	 * @return Object return Object 
	 */
	public Object getValue();
	
	/**
	 * display Display string of object value according to object type
	 * 
	 * @return String 
	 */
	public String display();
	
	/**
	 * DiplayWithType Return string that contain the value of object and  object type 
	 * 
	 * @return String 
	 */
	public String diplayWithType();
	
}
