/**
 * 
 */
package com.gil.master1.setting;

/**
 * IntegerType Class of Intger type value 
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class IntegerType implements ValueType {
	
	private Integer value;
	
	/**
	 * IntegerType - The default constructor
	 * @param value Integer value
	 */
	public IntegerType(Integer value) {
		super();
		this.value = value;
	}

		
	/**
	 * setValue Set the value 
	 * 
	 * @param value the value to set
	 */
	public void setValue(Integer value) {
		this.value = value;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#getValue()
	 */
	@Override
	public Object getValue() {
		// TODO Auto-generated method stub
		return null;
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#display()
	 */
	@Override
	public String display() {
		// TODO Auto-generated method stub
		return value.toString();
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#DiplayWithType()
	 */
	@Override
	public String diplayWithType() {
		// TODO Auto-generated method stub
		return display() + " (Integer)";
	}

}
