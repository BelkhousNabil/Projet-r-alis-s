package view;

import java.util.Vector;

import javax.swing.table.AbstractTableModel;

/**
 * Le modele de donn&eacutees pour le JTable
 * @author Anouar & Nabil
 *
 */
class SimpleTableModel extends AbstractTableModel {
    public String[] m_colNames = { "Regle Gauche", "Regle droite", "Support","Confiance", "Lift" };

    public Class[] m_colTypes = { String.class, String.class, String.class, String.class,String.class };

    Vector m_macDataVector;

    public SimpleTableModel(Vector macDataVector) {
      super();
      m_macDataVector = macDataVector;
    }
    public int getColumnCount() {
      return m_colNames.length;
    }
    public int getRowCount() {
      return m_macDataVector.size();
    }
    public void setValueAt(Object value, int row, int col) {
      Data macData = (Data) (m_macDataVector.elementAt(row));

      switch (col) {
      case 0:
        macData.setRegleGauche((String) value);
        break;
      case 1:
    	  macData.setRegleDroite((String) value);
        break;
      case 2:
    	  macData.setSupport((String) value);
        break;
      case 3:
    	  macData.setConfiance((String) value);
        break;
      case 4:
    	  macData.setLift((String) value);
        break;
      }
    }

    public String getColumnName(int col) {
      return m_colNames[col];
    }

    public Class getColumnClass(int col) {
      return m_colTypes[col];
    }
    
    public Object getValueAt(int row, int col) {
      Data macData = (Data) (m_macDataVector.elementAt(row));

      switch (col) {
      	case 0:
    	   return macData.getRegleGauche();
        case 1:
        	return macData.getRegleDroite();
          
        case 2:
      	  return macData.getSupport();
          
        case 3:
        	return macData.getConfiance();
         
        case 4:
        	return macData.getLift();
      }

      return new String();
    }
  }