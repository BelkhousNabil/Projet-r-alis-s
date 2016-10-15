package KmeansAlgo;

/**
 * 
 * @author BELKHOUS
 * 
 * class that represent the data
 */
	public class Data{
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