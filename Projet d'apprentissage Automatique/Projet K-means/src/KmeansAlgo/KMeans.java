/**
 * Mains Package of the java project
 */
package KmeansAlgo;

import java.io.IOException;
/**
 * Imports
 */
import java.util.ArrayList;
import java.util.Scanner;


/**
 * @author BELKHOUS
 * @version 1.0
 * Date: 30/09/2016
 */
public class KMeans
{	
	// Iterator for the display
	private static int cpt=0;
	
	// Numbre of clusters
    private static int NUM_CLUSTERS = 0;    
    
    // dataCollection that refer to all the points
    private static double dataCollection[][] = new double[][] {	
    															{1.0, 1.0},{2.0, 1.0},{3.0, 1.0}, 
    															{3.0, 2.0}, {4.0, 2.0}, {5.0, 2.0}	};
    															
    // Number of data  
    private static int dataLenght = dataCollection.length;
    
    // array of data that are treated
    private static ArrayList<Data> dataSet = new ArrayList<Data>();
    
    // centroids collection
    private static ArrayList<Centroid> centroids = new ArrayList<Centroid>();
    
    /**
     * Principal function that will cluster the collection data
     */
    private static void kMean(){
    	// Give a really big number that we are sure that it will be bigger than the first comparaison with the distance
        double bigNumber = Math.pow(10, 10); 
        
        // The minimum that will be the reference when we calculate the distences
        double minimum = bigNumber;         
        
        // The distance between two points
        double distance = 0.0; 
        
        // Iterator of the data collection
        int dataNumber = 0;
        
        // assignment of the point cluster
        int cluster = 0;
        
        // the variable that will permit to detect the convergence
        boolean isStillMoving = true;
         
        Data newData = null;
        
        // Get the points from the data collection one by one and recalculating centroids with each new one
        while(dataSet.size() < dataLenght){
            newData = new Data(dataCollection[dataNumber][0], dataCollection[dataNumber][1]);
            dataSet.add(newData);
            minimum = bigNumber;
            for(int i = 0; i < NUM_CLUSTERS; i++){
                distance = dist(newData, centroids.get(i));
                if(distance < minimum){
                    minimum = distance;
                    cluster = i;
                }
            }
            // assignment of the cluster for the point
            newData.setCluster(cluster);
            
            dataNumber++;
        }
        
        displayClusters();
        
        // recalculating of the centroids until the convergence
        while(isStillMoving){
            // calculate new centroids.
            for(int i = 0; i < NUM_CLUSTERS; i++){
                int totalX = 0;
                int totalY = 0;
                int totalInCluster = 0;
                for(int j = 0; j < dataSet.size(); j++){
                    if(dataSet.get(j).getCluster() == i){
                        totalX += dataSet.get(j).getcoordinateX();
                        totalY += dataSet.get(j).getcoordinateY();
                        totalInCluster++;
                    }
                }
                if(totalInCluster > 0){
                    centroids.get(i).setCoordinateX(totalX / totalInCluster);
                    centroids.get(i).setCoordinateY(totalY / totalInCluster);
                }
            }
            
            // Assign all data to the new centroids
            isStillMoving = false;
            
            for(int i = 0; i < dataSet.size(); i++){
                Data tempData = dataSet.get(i);
                minimum = bigNumber;
                for(int j = 0; j < NUM_CLUSTERS; j++){
                    distance = dist(tempData, centroids.get(j));
                    if(distance < minimum){
                        minimum = distance;
                        cluster = j;
                    }
                }
                tempData.setCluster(cluster);
                if(tempData.getCluster() != cluster){
                    tempData.setCluster(cluster);
                    isStillMoving = true;
                }
            }
        }
    }
    
    /**
     * Calculate Euclidean distance.
     * @param d - Data object.
     * @param c - Centroid object.
     * @return - double value.
     */
    private static double dist(Data d, Centroid c){
        return Math.sqrt(Math.pow((c.getCoordinateY() - d.getcoordinateY()), 2) + Math.pow((c.getCoordinateX() - d.getcoordinateX()), 2));
    }
    
    /**
     * Display the clusters 
     */
    private static void displayClusters(){
    	double w = 0.0, b = 0.0;
        Centroid C = collectionCentroid();
        
    	System.out.println("****************************** Iteration N° : "+cpt+" *********************************");
    	System.out.println("--- first centroid    (" + centroids.get(0).getCoordinateX() + ", " + centroids.get(0).getCoordinateY() + ") ---");
        System.out.println("--- Seconde centroid  (" + centroids.get(1).getCoordinateX() + ", " + centroids.get(1).getCoordinateY() + ") ---\n");
                
        for(int i = 0; i < NUM_CLUSTERS; i++){
            System.out.println("Cluster " + i + " includes:");
            for(int j = 0; j < dataLenght; j++){
                if(dataSet.get(j).getCluster() == i){
                    System.out.println("     (" + dataSet.get(j).getcoordinateX() + " , " + dataSet.get(j).getcoordinateY() + ")");
                   
                    // calculating of the W parameter
                    w += dist(dataSet.get(j), centroids.get(i));
                    
                    // calculating of the B parameter
                    b += Math.sqrt(Math.pow((C.getCoordinateY() - centroids.get(i).getCoordinateY()), 2) + Math.pow((C.getCoordinateX() - centroids.get(i).getCoordinateX()), 2));
                }
            } 
            System.out.println();
        } 
        cpt++;
        
        
        System.out.println("W = "+ w);
        System.out.println("B = "+ b);
        System.out.println("CH = "+ ((dataLenght - NUM_CLUSTERS)*b)/((dataLenght - 1)*w));
        
        System.out.println("*********************************************************************************\n");
    }
     
    
    
    /**
     * Internal class that represent the data
     * @author BELKHOUS
     */
    private static class Data{
        private double coordinateX = 0;
        private double coordinateY = 0;
        private int mCluster = 0;
        
        /**
         * Default constructor
         */
        public Data(){
        	
        }
        
        /**
         * Constructor
         * @param x
         * @param y
         */
        public Data(double x, double y){
            this.setCoordinateX(x);
            this.setCoordinateY(y);
        }
        
        /**
         * setter of coordinateX
         * @param x
         */
        public void setCoordinateX(double x){
            this.coordinateX = x;
        }
        
        /**
         * Getter of coordinateX
         * @return double value
         */
        public double getcoordinateX(){
            return this.coordinateX;
        }
        
        /**
         * setter of coordinateY
         * @param y
         */
        public void setCoordinateY(double y){
            this.coordinateY = y;
        }
        
        /**
         * Getter of coordinateY
         * @return double value
         */
        public double getcoordinateY(){
            return this.coordinateY;
        }
        
        /**
         * Setter of cluster to data
         * @param clusterNumber
         */
        public void setCluster(int clusterNumber){
            this.mCluster = clusterNumber;
            return;
        }
        
        /**
         * Getter of data cluster
         * @return int value
         */
        public int getCluster(){
            return this.mCluster;
        }
    }
    
    /**
     * Internal class that represent the centroid
     * @author BELKHOUS
     */
    private static class Centroid{
        private double coordinateX = 0.0;
        private double coordinateY = 0.0;
        
        /**
         * Default constructor
         */
        public Centroid(){
            
        }
        
        /**
         * Constructor
         * @param X
         * @param Y
         */
        public Centroid(double X, double Y){
            this.coordinateX = X;
            this.coordinateY = Y;
        }
        
        /**
         * Setter of coordinateX
         * @param X
         */
        public void setCoordinateX(double X){
            this.coordinateX = X;
        }
        
        /**
         * Getter of coordinateX
         * @return double value
         */
        public double getCoordinateX(){
            return this.coordinateX;
        }
        
        /**
         * Setter of coordinateY
         * @param Y
         */
        public void setCoordinateY(double Y){
            this.coordinateY = Y;
        }
        
        /**
         * Getter of  coordinateY
         * @return double value
         */
        public double getCoordinateY(){
            return this.coordinateY;
        }
    }
    
    private static Centroid collectionCentroid(){
    	double x=0.0, y=0.0;
    	
    	for(int j = 0; j < dataLenght; j++){
            x += dataSet.get(j).getcoordinateX();
            y += dataSet.get(j).getcoordinateY();  
        } 
    	
    	return new Centroid(x/dataLenght,y/dataLenght);
    }
    
    public static void main(String[] args) throws IOException{
    	Scanner sc = new Scanner(System.in);
        System.out.println("Donner le K pour le nombre de clusters : ");
        NUM_CLUSTERS = sc.nextInt();
        sc.nextLine();
        
        int k=0;
        while(k < NUM_CLUSTERS){
        	System.out.println("Donner le centyroid numéro: "+ k+1);
        	
            System.out.println("--- Coordonnée X du centyroid : ");
            double x = sc.nextDouble();
            
            sc.nextLine();
            
            System.out.println("--- Coordonnée Y du centyroid : ");
            double y = sc.nextDouble();
            
            centroids.add(new Centroid(x, y));
        	k++;
        }
        
        kMean();
        
        displayClusters();
        
        // Print out centroid results.
        System.out.println("Centroids finalized at:");
        for(int i = 0; i < NUM_CLUSTERS; i++){
            System.out.println("     (" + centroids.get(i).getCoordinateX() + ") , (" + centroids.get(i).getCoordinateY()+")");
        }
    }
}