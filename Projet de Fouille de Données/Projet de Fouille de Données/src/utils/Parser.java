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

public class Parser{

	private File file;
	
	public Parser(File file) {
		this.file = file;
	}
	
	public Map<Integer, List<Item>> parseFile() {
		
		Map<Integer, List<Item>> retMap = new HashMap<Integer, List<Item>>();
		
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
				
				retMap.put(Integer.valueOf(t[0]), temp);				
			}		
			in.close();			
		}catch (Exception e) {
			System.err.println("Error: " + e.getMessage());
		}
		return retMap;
	}
	
}
