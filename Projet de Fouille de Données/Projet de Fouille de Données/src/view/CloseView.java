package view;

import java.awt.*;
import java.awt.event.*;
import java.io.File;
import java.util.Vector;

import javax.swing.*;

import model.Close;

import utils.Parser;

import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.table.TableRowSorter;


@SuppressWarnings("serial")
public class CloseView extends JFrame {

	
	
	/****************************************************************************************************************************/
	public static Vector dummyMacData = new Vector();
	
	public static Vector dummyMacData2 = new Vector();
	
	private Container container = getContentPane();
    private JPanel center, areaPanel, bottom;
    private JFileChooser chooser;
    private File fileSelected;
    private JLabel lbParcourir = new JLabel("Vide")
    		,lbFile = new JLabel("Fichier ouvert  : ");
    
    public static JTable m_simpleTable;

    public static  SimpleTableModel m_simpleTableModel;

    private SpinnerModel spinnerModel =new SpinnerNumberModel(0, 0,1,0.01);
    private JSpinner SupMinSpinner = new JSpinner(spinnerModel);
    
    public DemoAction PlayCloseAlgo = new DemoAction("Algorithme Close", new ImageIcon(CloseView.class.getResource("4.gif")), "Algorithme Close", 'C');
    public DemoAction TableauRegleApproximative = new DemoAction("Regles approximatives", new ImageIcon(CloseView.class.getResource("2.gif")), "Regles approximatives", 'A');
    public DemoAction TableauRegleSur = new DemoAction("Regles Surs",new ImageIcon(CloseView.class.getResource("3.gif")), "Regles Surs", 'S');
    public DemoAction Exit = new DemoAction("Fermer",new ImageIcon(CloseView.class.getResource("5.gif")), "Fermer", 'F');
    public DemoAction Import = new DemoAction("Importer",new ImageIcon(CloseView.class.getResource("1.gif")), "Importer", 'I');
   
    private Parser parser;
    private JSplitPane spPane;
    private JTextArea textArea;
    
	private JScrollPane scrollPane;

	public static Object[][] donnees;
	private int i=0;
	
    public CloseView() {
        setTitle("Algorithme Close");
        setLocation(150, 250);
        setSize(1000, 290);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        ToolBarExample example = new ToolBarExample();
        
        setJMenuBar(example.menuBar);
        getContentPane().add(example.toolBar, BorderLayout.SOUTH);

        //Création des éléments pour exécuter l'algorithme

        center = new JPanel(new GridLayout(1, 1));
        center.setBackground(Color.red);

        JTextArea definition = new JTextArea("Explication de l'algorithme CLOSE\n"+
        									"1_ Initialisation de l’ensemble des generateurs \n avec l’ensemble des singletons formes par les mots du corpus\n"+
        									"2_ Calcul de la fermeture des generateurs de \n niveau k et de leur support\n"+
        									"3_Ajout des fermetures des generateurs \n a l’ensemble des ensembles de mots fermes frequents\n"+
        									"4_Generation des generateurs de niveau k + 1\n");
        
        center.add(definition);
        
        textArea = new JTextArea();

        areaPanel = new JPanel(new BorderLayout());
        areaPanel.setBackground(Color.green);
        	
            scrollPane = new JScrollPane(textArea);            
            areaPanel.add(scrollPane);
        

        bottom = new JPanel();
        bottom.setBackground(Color.orange);
            bottom.setLayout(new BoxLayout(bottom, BoxLayout.PAGE_AXIS));
            bottom.add(new JLabel("Règles :"));
            bottom.add(areaPanel);

        spPane = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, center, bottom);

        container.add(spPane, BorderLayout.CENTER);

        setVisible(true);
    }
    
    private class ToolBarExample extends JPanel {
    
    	
    public JMenuBar menuBar;
    public JToolBar toolBar;

    public ToolBarExample() {
      menuBar = new JMenuBar();
      
      JMenu formatMenu = new JMenu("Outils de l'Algorithme CLOSE");
      formatMenu.add(PlayCloseAlgo);
      formatMenu.add(Import);
      
      menuBar.add(formatMenu);

      toolBar = new JToolBar("Algorithme CLOSE");
      toolBar.add(PlayCloseAlgo);     
      toolBar.addSeparator();
      toolBar.add(Import);
      toolBar.addSeparator();
      toolBar.add(TableauRegleApproximative);
      toolBar.addSeparator();
      toolBar.add(TableauRegleSur);
      toolBar.addSeparator();
      toolBar.add(Exit);
      toolBar.addSeparator();
      
      
      JLabel label = new JLabel("Support Min");
      toolBar.add(label);
      SupMinSpinner.setPreferredSize(new Dimension(100, 40));
      toolBar.add(SupMinSpinner);
      
      toolBar.addSeparator();

      formatMenu.add(TableauRegleApproximative);
      formatMenu.add(TableauRegleSur);
      formatMenu.add(Exit);

      toolBar.addSeparator();
      
      toolBar.add(lbFile);
      toolBar.addSeparator();
      toolBar.add(lbParcourir);
      toolBar.addSeparator();
      
      //  Disable Actions
      PlayCloseAlgo.setEnabled(false);
      TableauRegleApproximative.setEnabled(false);
      TableauRegleSur.setEnabled(false);
      
    }

    }
    
    private class DemoAction extends AbstractAction {

        public DemoAction(String text, Icon icon, String description,char accelerator) {
          super(text, icon);
          putValue(ACCELERATOR_KEY, KeyStroke.getKeyStroke(accelerator,
              Toolkit.getDefaultToolkit().getMenuShortcutKeyMask()));
          putValue(SHORT_DESCRIPTION, description);
        }

        public void actionPerformed(ActionEvent e) {
          String cas = (String) getValue(NAME);
        	System.out.println(cas);
        	if(cas.equals("Algorithme Close")){

        		dummyMacData2.clear();
        		dummyMacData.clear();
          	if ((lbParcourir.getText()).trim().equals("Vide")) {
                  JOptionPane.showMessageDialog(new JFrame(), "Erreur : Veuillez donner un fichier", "Erreur Fichier",
                          JOptionPane.ERROR_MESSAGE);
              } else {
                 
                      parser = new Parser(fileSelected);
                      Close c = new Close(0.3);

                      c.loadData(parser);
                      textArea.append(c.generateRelations());
                      textArea.append("\n****************************************************************\n");
                      TableauRegleApproximative.setEnabled(true);
                      TableauRegleSur.setEnabled(true);
              }
          
        	}else if(cas.equals("Importer")){

              chooser = new JFileChooser();

              chooser.addActionListener(new ActionListener() {
                  @Override
                  public void actionPerformed(ActionEvent e) {
                      if (chooser.getSelectedFile() != null) {
                          if (!(chooser.getSelectedFile().getName().matches("\\S+.txt"))) {
                              JOptionPane.showMessageDialog(new JFrame(),"Le format de fichier est incorrect, veuillez choisir un format .txt", "Erreur Fichier",
                                      JOptionPane.ERROR_MESSAGE);
                              
                          } else {
                              fileSelected = chooser.getSelectedFile();
                              lbParcourir.setText(fileSelected.getName());
                              PlayCloseAlgo.setEnabled(true);
                          }
                      }
                  }
              });

              chooser.showOpenDialog(container);
          
        	}else if(cas.equals("Regles approximatives")){
        			
        		m_simpleTableModel = new SimpleTableModel(dummyMacData2);
        	    m_simpleTable = new JTable(m_simpleTableModel);
        	    
        	  //Trieur de donnée
                RowSorter<SimpleTableModel> sorter = new TableRowSorter<>(m_simpleTableModel);
                m_simpleTable.setRowSorter(sorter);
                
        	    JScrollPane scrollPane = new JScrollPane(m_simpleTable);
        	    getContentPane().add(scrollPane);
        	  
        	    JFrame m = new JFrame("Regles approximatives");
        	    m.add(scrollPane);
        	    m.setSize(new Dimension(600, 300));
        	    m.setVisible(true);
        	    m.setDefaultCloseOperation(DISPOSE_ON_CLOSE);
        	}
        	else if(cas.equals("Regles Surs")){
        		m_simpleTableModel = new SimpleTableModel(dummyMacData);
        	    m_simpleTable = new JTable(m_simpleTableModel);
        	    
        	  //Trieur de donnée
        	    RowSorter<SimpleTableModel> sorter = new TableRowSorter<>(m_simpleTableModel);
                m_simpleTable.setRowSorter(sorter);
                
        	    JScrollPane scrollPane = new JScrollPane(m_simpleTable);
        	    getContentPane().add(scrollPane);
        	  
        	    JFrame m = new JFrame("Regles Surs");
        	    m.add(scrollPane);
        	    m.setSize(new Dimension(600, 300));
        	    m.setVisible(true);
        	    m.setDefaultCloseOperation(DISPOSE_ON_CLOSE);
        		
        	}else if(cas.equals("Fermer")){
        		System.exit(0);
        	}	
        	
        }
        
      }
    
public static void main(String[] args) {
    	
    	try {
			for (LookAndFeelInfo info : UIManager.getInstalledLookAndFeels()) {
				if("Nimbus".equals(info.getName())){
					UIManager.setLookAndFeel(info.getClassName());
					break;
				}
			}
    		
		} catch (Exception e) {
			
		}
    	
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                new CloseView();
            }
        });
    }
    
}

