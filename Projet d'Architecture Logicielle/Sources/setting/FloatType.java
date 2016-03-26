/**
 * 
 */
package com.gil.master1.setting;

/**
 * FloatType Class of Float type value 
 * 
 * @author anouar & nabil
 * @version 1.0
 * @date 02/01/2015
 */
public class FloatType implements ValueType {
	
	private Float value;
	
	/**
	 * FloatType The default constructor
	 * @param value Float value 
	 */
	public FloatType(Float value) {
		this.value = value;
	}

	/**
	 * setValue Set the float value
	 * @param value the value to set
	 */
	public void setValue(Float value) {
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
		return value.toString();
	}

	/* (non-Javadoc)
	 * @see com.gil.master1.setting.ValueType#DiplayWithType()
	 */
	@Override
	public String diplayWithType() {
		// TODO Auto-generated method stub
		return display() + " (Float)";
	}

}
