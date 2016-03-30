package utils;

import java.io.BufferedReader;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import model.Item;

/**
 * La Classe Parser nous permet de parser le fichier de donn&eacutees et de recuperer les Items avec leurs cle dans une Map
 * @author Anouar & Nabil
 *
 */
public class Parser{

	// fichier de donn&eacutees
	private File file;
	
	/**
	 * Constructeur
	 * @param file
	 */
	public Parser(File file) {
		this.file = file;
	}
	
	/**
	 * parseFile permet pour chaque ligne de remplir une map avec l'identifiant de la ligne et l'ensemble des Items de cette id
	 * @return map
	 */
	public Map<Integer, List<Item>> parseFile() {
		
		Map<Integer, List<Item>> map = new HashMap<Integer, List<Item>>();
		
		try{
			  
			FileInputStream fIn = new FileInputStream(this.file);			  
			DataInputStream in = new DataInputStream(fIn);
			BufferedReader br = new BufferedReader(new InputStreamReader(in));
			String strLine;			  
			while ((strLine = br.readLine()) != null)   {
				String[] t = strLine.trim().split("\\|");	
				List<Item> temp = new ArrayList<Item>();
				for (int i = 1; i < t.length; i++) {					
					temp.add(new Item(t[i].trim()));
				}
				
				map.put(Integer.valueOf(t[0]), temp);				
			}		
			in.close();			
		}catch (Exception e) {
			System.err.println("Error: " + e.getMessage());
		}
		return map;
	}
	
}
