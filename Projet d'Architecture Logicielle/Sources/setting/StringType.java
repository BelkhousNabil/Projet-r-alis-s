/**
 * 
 */
package com.gil.master1.setting;

/**
 * StringType Class of String type value 
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class StringType implements ValueType {
	
	private String value;
	
	/**
	 * StringType The default constructor
	 * @param value String value
	 */
	public StringType(String value){
		this.value = value;
	}
	
	/**
	 * @param value the value to set
	 */
	public void setValue(String value) {
		this.value = value;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#getValue()
	 */
	@Override
	public Object getValue() {
		// TODO Auto-generated method stub
		return this.value;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#display()
	 */
	@Override
	public String display() {
		// TODO Auto-generated method stub
		return value ;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#DiplayWithType()
	 */
	@Override
	public String diplayWithType() {
		// TODO Auto-generated method stub
		return display() + " (String)";
	}

}
